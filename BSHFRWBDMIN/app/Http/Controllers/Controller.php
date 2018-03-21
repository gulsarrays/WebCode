<?php
/**
 * Controller Controller
 *
 * This is the home controller
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Validator;
use Exception;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get validation failure response
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */ 
    public function getValidationFailureResponse(Validator $validator){
        return $this->getErrorJsonResponse($this->_formatValidationMessages($validator->messages()->toArray()),[],422);
    }
    /**
     * Get response from exception
     * 
     * @param \Exception $e
     * @param int $statusCode
     * @return void
     */    
    public function getResponseFromException(Exception $e,$statusCode = 500){
        return $this->getErrorJsonResponse([$e->getMessage()],[],$statusCode);
    }
    /**
     * Get error json response
     * 
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return void
     */
    protected function getErrorJsonResponse($message,array $data = [],$statusCode = 500) {
        return response ()->json (array_merge([
            COM_ERROR_KEY => true,
            COM_MESSAGE_KEYWORD => $message,
        ],$data),$statusCode);
    }
    /**
     * Get success json response
     * 
     * @param string $message
     * @param array $data
     * @return void
     */
    protected function getSuccessJsonResponse($message,array $data = []) {
        return response ()->json(array_merge([
            COM_ERROR_KEY => false,
            COM_MESSAGE_KEYWORD => $message,
        ],$data),200);
    }    
    /**
     * Message Formator Validator Response.
     * 
     * @param array $errors
     * Error Message.
     * @return array Formated Array.
     */
    public function _formatValidationMessages($errors) {
        /**
         * Returns all the errors at once.
         */ 
        $formattedErrors='';
      foreach ($errors as $error){
          /**
           * Returns the top most error.
           * @var unknown
           */
          $formattedErrors[]=$error[0];
          break;
      }
      /**
       * return the formatted errors in an array
       */
      return implode(" ",array_values($formattedErrors));
    }   
}
