<?php
/**
 * User Controller
 *
 * Controller where user can get perform their registration on.
 *
 * @category  compassites
 * @package   compassites
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   V2.0
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\MessageRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class MessageController extends Controller {
    /**
     * Class property to hold the Request instance
     * 
     * @var \Illuminate\Http\Request
     **/
    protected $request = null;
    /**
     * Class property to hold the MessageRepository instance
     * 
     * @var \App\Repository\MessageRepository
     **/
    protected $messageRepository = null;
    /**
     * Class Constructor
     * 
     * @param \App\Repository\MessageRepository $messageRepository
     * @return void
     */
    public function __construct(Request $request,MessageRepository $messageRepository) {
        $this->request = $request;
        $this->messageRepository = $messageRepository;
    }
    /**
     * Send deleivery response to XMPP server
     * 
     * @return Response
     */
    public function sendDeliveryResponse() {
        $validator = Validator::make ( $this->request->all (), [ 
            COM_MESSAGE_ID_KEYWORD  => COM_REQUIRED_KEYWORD,    
            COM_MESSAGE_FROM_KEYWORD => COM_REQUIRED_KEYWORD,
            COM_MESSAGE_TO_KEYWORD  => COM_REQUIRED_KEYWORD,
            COM_CHATTYPE_KEYWORD  => COM_REQUIRED_KEYWORD,
            COM_MESSAGE_TYPE_KEYWORD => COM_REQUIRED_KEYWORD
        ] );

        if($validator->fails()){
            $response = $this->getValidationFailureResponse($validator);
        } else {
            try{
                $this->messageRepository->sendDeliveryResponse();

                $response = $this->getSuccessJsonResponse(SUCCESSFULLY_SEND_DELEIVERY_RESPONSE,$this->messageRepository->getMessageResponse());
            } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                $response = $this->getResponseFromException($e,404);
            } catch(Exception $e){
                $response = $this->getResponseFromException($e);
            }
        }

        return $response;
    }

    public function sendMessage()
    {
        try{
            $response = $this->messageRepository->sendMessageXmpp();
        } catch(Exception $e){
            $response = $this->getResponseFromException($e);
        }
        return $response;
    }
}