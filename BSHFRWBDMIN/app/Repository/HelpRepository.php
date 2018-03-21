<?php 

namespace App\Repository;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;

class HelpRepository{
	
	public function getPaginated($results, $perPage, $page, $request)
	{
		$currentPage = Paginator::resolveCurrentPage();
		$collection = new Collection($results);
		$currentPageResults = $collection-> slice (($currentPage -1) * $perPage, $perPage)->all();
	    return $paginatedResults = new Paginator($currentPageResults, count($collection), $perPage, $page, ['path'  => $request->url(),'query' => $request->query()]);
	}

	public function getApiResponse($url)
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


  	public function fetchDashboardApiResponse($url)
  	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('GET', API_BASE_URL.$url,
				[
				'headers' => [
				  'Authorization' => 'Bearer ' . $jwt_token,
				]
		    ])->getBody();
		$response = json_decode($response, true);
		$result = [];
		foreach ($response as $items) {
		  $result[] = $items['item'];
		}
		return $result;
	}

	public function getEmailSetting($url)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->get( $url,
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
}