<?php

/**
 * Message Repository
 *
 * In this message repository having the methods to process the message data.
 *
 * @category  compassites
 * @package   compassites Fly
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2014 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 2.0
 */
namespace App\Repository;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Fabiang\Xmpp\Options as XmppOptions;
use Fabiang\Xmpp\Client as XmppClient;
use App\Lib\Xmpp\Message;
use App\Lib\Xmpp\OneToOneMessage;
use App\Models\GroupChat;
use App\Contracts\LoggingModel;
use App\Models\Chat;
use RuntimeException;
use ReflectionClass;
use ReflectionException;
use Log;

class MessageRepository {
    /**
     * Class property to hold the Users instance
     * 
     * @var \App\User
     **/
    protected $user = null;    
    /**
     * Class property to hold the Request instance
     * 
     * @var \Illuminate\Http\Request
     **/
    protected $request = null;    
    /**
     * Class property to hold the XMPP Client instance
     * 
     * @var \Fabiang\Xmpp\Client
     **/
    protected $xmppClient = null;
    /**
     * Class property to hold exposed message types
     * 
     * @var array
     **/
    protected $exposedMessageTypes = [IMAGE,VIDEO,CONTACT];
    /**
     * Class property to hold associated message type  models
     * 
     * @var array
     **/
    protected $associatedMessageTypeModels = [
        GROUPCHAT => GroupChat::class,
        CHAT  => Chat::class,
    ];            
    /**
     * Class Constructor
     * 
     * @param \App\User $user
     * @return void
     */
    public function __construct(Users $user,Request $request) {
        $this->user = $user;
        $this->request = $request;
    }
    /**
     * Prepare the user with request params
     *
     * @return \App\Repository\MessageRepository
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function prepareUser() {
        $this->user = $this->user->where(USERNAME,$this->request->input(COM_MESSAGE_FROM_KEYWORD))
                                 ->select([USERNAME,PASSWORD])
                                 ->first();    

        if(!$this->user instanceof User || !$this->user->exists){
            throw new ModelNotFoundException(trans(LANG_RESOURCE_NOT_EXIST));
        }

        return $this;
    }

    private function prepareUserPeer() {

        $input = \Input::all ();
        $request = json_decode($input['data']);
        $message_from = $request->message_from; //session(COM_MESSAGE_FROM_KEYWORD);
        
        $this->user = $this->user->where(USERNAME, $message_from)
                                 ->select([USERNAME,PASSWORD])
                                 ->first();    
        
        if(!$this->user instanceof Users || !$this->user->exists){
            throw new ModelNotFoundException(trans(LANG_RESOURCE_NOT_EXIST));
        }

        return $this;
    }

    /**
     * Prepare the xmpp connection
     *
     * @uses package fabiang/xmpp
     * @see https://github.com/fabiang/xmpp
     * @return \App\Repository\MessageRepository
     */
    private function prepareXMPPConnection() {
        $this->xmppClient = new XmppClient(
            (new XmppOptions(config(XMPP_ADDRESS)))->setUsername($this->user->username)
                             ->setPassword($this->user->password)
                             ->setLogger(app()->make('log'))
        ); 
        return $this;
    }    
    /**
     * Form message xml as string by updating required attributes
     *
     * @return \App\Libs\Xmpp\Message
     */
    private function getMessage() {
        $serverHost = str_replace("tcp://","",config(XMPP_ADDRESS));
        $serverPath = str_replace(":5222","",$serverHost);
        return (new Message)->setTo($this->request->input(COM_MESSAGE_TO_KEYWORD).'@'.$serverPath)
                            ->setId($this->request->input(COM_MESSAGE_ID_KEYWORD))
                            ->setTime(time())
                            ->setType(RECEIPTS)
                            ->setChatType($this->request->input(COM_CHATTYPE_KEYWORD));
    }     
    /**
     * Send deleivery response to XMPP server
     * 
     * @return void
     */
    public function sendDeliveryResponse() {
        $this->prepareUser()->prepareXMPPConnection();
        $this->xmppClient->send($this->getMessage());
        $this->xmppClient->disconnect();
    }
    /**
     * Get Message delivery response data
     * 
     * @return array
     */
    public function getMessageResponse() {
        $chatType = $this->request->input(COM_CHATTYPE_KEYWORD);
        $messageType = $this->request->input(COM_MESSAGE_TYPE_KEYWORD);
        $messageId   = $this->request->input(COM_MESSAGE_ID_KEYWORD);
        $responseData = [];

        if(
            $messageId 
            && in_array($messageType, $this->exposedMessageTypes)
            && ($loggingMessageModel = $this->getLoggingMessageModel($chatType))
        ){
            try {
               $messageInfo = $loggingMessageModel->getMessageInfoByMessageId($messageId);

               if(is_array($messageInfo)){
                   $responseData = array_merge($messageInfo,[
                        COM_CHATTYPE_KEYWORD => $chatType,
                        COM_MESSAGE_FROM_KEYWORD => $this->request->input(COM_MESSAGE_TO_KEYWORD),
                        COM_MESSAGE_TO_KEYWORD => $this->request->input(COM_MESSAGE_FROM_KEYWORD)
                   ]);
               }
           } catch (RuntimeException $e) {
                Log::error($e->getMessage());
            }
        }

        return $responseData;
    } 
    /**
     * validate Message Model and get content
     * 
     * @param string $chatType
     * @return \App\Contracts\LoggingModel | null
     */
    public function getLoggingMessageModel($chatType) {
        $loggingMessageModel = null;

        if(array_key_exists($chatType, $this->associatedMessageTypeModels)){
            try {
                $loggingMessageModel = (new ReflectionClass(
                    $this->associatedMessageTypeModels[$chatType]
                ))->newInstance();

                $loggingMessageModel = ($loggingMessageModel instanceof LoggingModel) ? $loggingMessageModel : null;
            } catch (ReflectionException $e) {
                Log::error($e->getMessage());
            }
        }            
        
        return $loggingMessageModel;
    }

    public function sendMessageXmpp()
    {
        $response = $this->prepareUserPeer()->prepareXMPPConnection();
        $this->xmppClient->send($this->getTextMessage());        
        $this->xmppClient->disconnect();
    }

    private function getTextMessage()
    {   
        $input = \Input::all ();
        $request = json_decode($input['data']);

        $message_content = json_encode([
            'message'=> $request->message,
            'message_type' => 'text']);        

        $messageId    = substr ( str_shuffle ( "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, 15);;        
        $iv        = "ddc0f15cc2c90fca";        
        $hash = hash('sha256', $messageId);         
        $key = mb_substr($hash, 0, 32);                
        $plaintext_utf8 = rawurlencode($message_content);                
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');         
        $pad = $size - (strlen($plaintext_utf8) % $size);         
        $plaintext_utf8 = $plaintext_utf8 . str_repeat(chr($pad), $pad);         
        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', $iv);        
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext_utf8, 
            MCRYPT_MODE_CBC, $iv);        
        $enciphertext = base64_encode($ciphertext);
        
        // $deciphertext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext, MCRYPT_MODE_CBC, $iv);
        
        return (new OneToOneMessage)->setTo($request->message_to.'@'.env('xmpp'))
                            ->setMessage($enciphertext)
                            ->setId($messageId)
                            ->setType("chat");
                            
    }
}
