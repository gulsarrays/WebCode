<?php

namespace App\Repository;

use GuzzleHttp\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class ChannelRepository {

	public function createChannel($input,$url)
	{
        $imageString = [
                [
                    'name' => 'files',
                    'contents' => file_get_contents($_FILES["image"]["tmp_name"]),
                    'filename' => $_FILES["image"]['name'],                 
                ]                
            ];

        if(isset($_FILES['contractfile']['name']) && !empty($_FILES['contractfile']['name'])){
            $imageString[] = [
                    'name' => 'contractfile',
                    'contents' => file_get_contents($_FILES["contractfile"]["tmp_name"]),
                    'filename' => $_FILES['contractfile']['name'],                 
                ];
        }

		$data = [
			'ageGroupId' => $input['ageGroup'],
			'categoryId' => $input['category'],
			'channelType' => $input['channel_type'],
			'startDate' => $input['start_date'].' 00:00:00',
			'endDate' => $input['end_date'].' 00:00:00',
			'channelTitle' => $input['title'],
			'channelDescription' => $input['description'],
			"isWebLogin" => true,
			"userId" => $input['userId']
		];
						
		$jwt_token = session('jwt_token');
		$client = new Client();

		try{

		$response = $client->request('POST', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'query' => [ 'channels' => json_encode($data)
            ],
            'multipart' => $imageString
            ])->getBody();

			$response = json_decode($response, true);
			if(isset($response['status']) && ($response['status'] === 1)){
				echo true;
			}else{
				echo false;
			}

		}
		catch(\Exception $e)
		{
			$exception = json_decode($e->getResponse()->getBody());
			
			if(isset($exception->errorMsg)){
				echo $exception->errorMsg;
			}else{
				echo 'couldnot create channel';
			}
		}
		
	}

	public function getChannelContent($url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->get( API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
		$response = json_decode($response, true);

		$result = [];
		 if(isset($response['status']) && ($response['status'] == 1)){
            $result = $response['data']['item'];
            return $result;
        }else{
        	return false;
        }		
		
	}

    public function getContentComments($url) {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response;
        } else {
            return false;
        }
    }

    public function sendChannelReminder($url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->get( API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
		$response = json_decode($response, true);

		$result = [];
		if(isset($response['status']) && ($response['status'] == 1)){
            return 1;
        }else{
        	return 0;
        }
	}

	public function updateReminderDuration($input, $url)
	{
		$data = [
			 "name" => "MailReminder",
			  "settingId" => $input['settingId'],
			  "value" => $input['daycount']
		];

		$jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('PUT', $url,
            [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'body' => json_encode($data)
            ])->getBody();
        $response = json_decode($response, true);
        
        try{
          if(isset($response['status']) && ($response['status'] == 1)){            
              return true;
          }
          else{
              return false;
          }
        }
        catch(\Exception $e){
          return false;
        }
	}

    public function uploadContent($input) {
        $data = [
            'contentTitle' => $input['title'],
            'contentDescription' => $input['description'],
            'contentText' => $input['description'],
            'listGroupId' => []
        ];

       
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $imgData = $_FILES['file'];

            if($_FILES['file']['size'] > UPLOAD_FILE_DATA_RESTRICTION) { //50 MB (size is also in bytes)
                echo 'upload file size must be less than 50MB';
                exit;
            }

            $imageString = [
                [
                    'name' => 'files',
                    'contents' => file_get_contents($_FILES["file"]["tmp_name"]),
                    'filename' => $imgData['name'],
                ],
                [
                    'name' => 'files',
                    'contents' => file_get_contents($_FILES["file"]["tmp_name"]),
                ]
            ];
        } else {
            $imageString = '';
        }

        $jwt_token = session('jwt_token');
        $client = new Client();

        try {
            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {

                $response = $client->request('POST', API_BASE_URL . UPLOAD_CONTENT, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $jwt_token
                            ],
                            'query' => [ 'content-details' => json_encode($data)],
                            'multipart' => $imageString
                        ])->getBody();
            } else {

                $response = $client->request('POST', API_BASE_URL . UPLOAD_CONTENT, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $jwt_token
                            ],
                            'query' => [ 'content-details' => json_encode($data)],
                            'multipart' => []
                        ])->getBody();
            }

            $response = json_decode($response, true);
            if (isset($response['status']) && ($response['status'] === 1)) {
                echo true;
            } else {
                echo false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                echo $exception->errorMsg;
            } else {
                echo 'could not upload content';
            }
        }
    }
    
    public function deleteContent($url) {
            
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('DELETE', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response;
        } else {
            return false;
        }
    }
    
    public function getContent($url) {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
            ]])->getBody();
        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response;
        } else {
            return false;
        }
    }
        
    function updateContent($input) {

        $data = [
            'contentId' => $input['contentId'],
            'contentTitle' => $input['title'],
            'contentDescription' => $input['description'],
            'contentText' => $input['description'],
            'listGroupId' => []
        ];
        $url = API_BASE_URL . UPDATE_CONTENT;

        $jwt_token = session('jwt_token');
        $client = new Client();

        try {
            $response = $client->request('PUT', $url, [
                        'headers' => [
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer ' . $jwt_token,
                        ],
                        'body' => json_encode($data)
                    ])->getBody();
            $response = json_decode($response, true);

            if (isset($response['status']) && ($response['status'] == 1)) {
                echo true;
            } else {
                echo false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                echo $exception->errorMsg;
            } else {
                echo 'could not update content';
            }
        }
    }

}