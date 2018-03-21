<?php

namespace App\Repository;

use GuzzleHttp\Client;

class ReportRepository {

	public function getReports($url)
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
		foreach ($response as $items) {
			$result[] = $items['item'];
		}
		
		return $result[0];
	}

	public function getReportTypes($url)
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
		foreach ($response as $items) {
			$result[] = $items['item'];
		}
		
		return $result[0];
	}

	public function createReportType($input, $url)
	{
		$data = [
			'userCommentsCategoryDesc' => $input['name'],
			'isactive' => $input['is_active']
		];
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('POST', API_BASE_URL.$url,
			[
            'headers' => [
            	'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'body' => json_encode($data)
            ])->getBody();
		$response = json_decode($response, true);

		if(isset($response['status']) && ($response['status'] === 1)){
			return true;
		}else{
			return false;
		}		
		
	}

	public function fetchReportType($id, $url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('GET', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'query' => [
            	'userCommentsCategoryId' => $id
            ]
            ])->getBody();
		$response = json_decode($response, true);
		
		// return $response;
		return $response['data']['item'];
	}

	public function updateReportType($input, $url)
	{
		$data = [
			'userCommentsCategoryId' => $input['reportTypeId'],
			'userCommentsCategoryDesc' => $input['name'],
            'isactive' => $input['is_active']
		];		
		
		$jwt_token = session('jwt_token');
		$client = new Client();			
		$response = $client->request('PUT', API_BASE_URL.$url,
		[
        'headers' => [
        	'Content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $jwt_token
        ],
        'body' => json_encode($data)
        ])->getBody();
		
		$response = json_decode($response, true);
		
		if(isset($response['status']) && ($response['status'] === 1)){
			return true;
		}else{
			return false;
		}
	}

	public function deleteReportType($id, $url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('DELETE', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'query' => [
            	'commentCategoryId' => $id
            ]
            ])->getBody();
		$response = json_decode($response, true);		
		
		if(isset($response['status']) && ($response['status'] === 1)){
			return true;
		}else{
			return false;
		}
	}


}