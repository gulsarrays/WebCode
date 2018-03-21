<?php
namespace App\Http\Controllers\Others;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Vcard;
use App\Models\UserVcard;
use App\Models\ChannelUserDetails;
use App\Models\UserChannels;
use Redis;
use JWTAuth;
use App\Repository\HelpRepository;

class OthersController extends Controller {
	
	public function __construct(HelpRepository $helpRepo){
		$this->helpRepo = $helpRepo;
	}

	public function getCategories(Request $request)
	{
		$categories = $this->helpRepo->getApiResponse(GET_ALL_CATEGORIES);
		//$paginatedResults = $this->helpRepo->getPaginated($categories, 10, $request->input('page',1), $request );
		
	    return view('others.categories', [
	    	'categories' => $categories/*,
			'paginator' => $paginatedResults*/
			]);
	}

	public function getageGroups(Request $request)
	{
		$ageGroups = $this->helpRepo->getApiResponse(GET_ALL_AGEGROUPS);
//		$paginatedResults = $this->helpRepo->getPaginated($ageGroups, 10, $request->input('page',1), $request );

		return view('others.ageGroup', [
			'ageGroups' => $ageGroups/*,
			'paginator' => $paginatedResults*/
			]);
	}

	public function getGender()
	{
		$genders = $this->helpRepo->getApiResponse(GET_GENDER);
		return view('others.gender', compact('genders'));
	}

	public function getOthersCreateCategory()
	{
		return view('others.createcategory');
	}

	public function postAddCategory(Request $request)
	{
		try{
			$input = $request->all ();
			$result = $this->addCategoryApi($input, CREATE_CATEGORY_API);
			if($result){
				return redirect ('/categories')->withSuccess ( 'Category created!' );
			}else{
				return redirect ('/categories')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){
			// echo $e->getMessage();
			return redirect ('/categories')->withError ( 'Already Exists' );
		}
	}

	public function postAgeGroup(Request $request)
	{
		try{
			$input = $request->all ();
			$result = $this->addAgeGroupApi($input, CREATE_AGEGROUP_API);
			if($result){
				return redirect ('/ageGroups')->withSuccess ( 'Age group created!' );
			}else if($result == 0){
				return redirect ()->back()->withError ( 'This Age group Already exists' );
			}else{
				return redirect ('/ageGroups')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){			
			// return $e->getMessage();
			return redirect ('/ageGroups')->withError ( 'This Age group Already exists' );
		}		
	}

	public function deleteCategory($cid)
	{
		try{
			$result = $this->deleteApiResponse(DELETE_CATEGORY_API, $cid, 'categoryId');
			if($result){
				return redirect ('/categories')->withSuccess ( 'Category deleted!' );
			}else{
				return redirect ('/categories')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){
			return $e->getMessage();
			return redirect ('/categories')->withError ( 'Something went wrong' );
		}	
	}

	public function deleteAgeGroup($agid)
	{
		try{
			$result = $this->deleteApiResponse(DELETE_AGEGROUP_API, $agid, 'ageGroupId');
			if($result){
				return redirect ('/ageGroups')->withSuccess ( 'Age group deleted!' );
			}else{
				return redirect ('/ageGroups')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){
			return $e->getMessage();
			return redirect ('/ageGroups')->withError ( 'Something went wrong' );
		}	
	}

	public function editCategory($cid)
	{
		$category = $this->fetchApiResponse(FETCH_CATEGORY_API, $cid, 'categoryId');		
		return view('others.editCategory', [
			'category' => $category
			]);
	}

	public function editAgeGroup($agid)
	{
		$agegroup = $this->fetchApiResponse(FETCH_AGEGROUP_API, $agid, 'ageGroupId');
		
		return view('others.editAgeGroup', [
			'agegroup' => $agegroup
			]);
	}

	public function postUpdateCategory(Request $request)
	{
		try{
			$input = $request->all ();
			$result = $this->updateCategoryApi(UPDATE_CATEGORY_API, $input);
			if($result){
				return redirect ('/categories')->withSuccess ( 'Category updated!' );
			}else{
				return redirect ('/categories')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){
			// return $e->getMessage();
			return redirect ('/categories')->withError ( 'Already Exists' );
		}
	}
	
	public function postUpdateAgeGroup(Request $request)
	{
		try{
			$input = $request->all ();
			$result = $this->updateAgeGroupApi(UPDATE_AGEGROUP_API, $input);
			if($result){
				return redirect ('/ageGroups')->withSuccess ( 'Age group updated!' );
			}else{
				return redirect ('/ageGroups')->withError ( 'Something went wrong' );
			}
		}catch(\Exception $e){
			return $e->getMessage();
			return redirect ('/ageGroups')->withError ( 'Already Exists' );
		}
	}
		
	public function getOthersAgeGroup()
	{
		return view('others.createagegroup');
	}

	// public function getApiResponse($url)
	// {
	// 	$jwt_token = session('jwt_token');
	// 	$client = new Client();
	// 	$response = $client->get( API_BASE_URL.$url,
	// 		[
 //            'headers' => [
 //                'Authorization' => 'Bearer ' . $jwt_token
 //            ]])->getBody();
	// 	$response = json_decode($response, true);

	// 	$result = [];
	// 	foreach ($response as $items) {
	// 		$result[] = $items['item'];
	// 	}
		
	// 	return $result[0];
	// }

	function addCategoryApi($input, $url)
	{

		$imgData = $_FILES['categoryImage'];
		$jwt_token = session('jwt_token');
		$client = new Client();

		$response = $client->request('POST', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'query' => [
            	'categoryName' => $input['name'],
            	'isactive' => $input['is_active']
            ],
            'multipart' => [
	            [
	            	'name' => 'file',
	            	'contents' => file_get_contents($_FILES["categoryImage"]["tmp_name"]),
	            	'filename' => $imgData['name'],	            	
	            ],
	            [
	            	'name' => 'file',
	            	'contents' => file_get_contents($_FILES["categoryImage"]["tmp_name"]),
	            ]
            ]

            ])->getBody();

		$response = json_decode($response, true);
		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else{
			return false;
		}
	}

	function addAgeGroupApi($input, $url)
	{
		$data = [
			  "ageGroupDescription"=> strval($input['desc']),
			  "ageGroupMax"=> intval($input['to']),
			  "ageGroupMin"=> intval($input['from']),
			  "isActive" => intval($input['is_active'])	
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

		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else if(isset($response['status']) && ($response['status'] === 0)){
			return 0;
		}else{
			return false;
		}
	}

	function deleteApiResponse($url, $id, $idname)
	{		
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('DELETE', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'query' => [
            	$idname => $id
            ]
            ])->getBody();
		$response = json_decode($response, true);
		
		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else{
			return false;
		}
	}

	function fetchApiResponse($url, $id, $idname)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('GET', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token,
            ],
            'query' => [
            	$idname => $id
            ]
            ])->getBody();
		$response = json_decode($response, true);
		
		return $response;
	}

	public function updateCategoryApi($url, $input)
	{
		$data = [
			'categoryId' => $input['categoryId'],
			'categoryName' => $input['name'],
            'isactive' => $input['is_active']
		];		
		
		$jwt_token = session('jwt_token');
		$client = new Client();
		
		if(isset($_FILES['categoryImage']) && !empty(($_FILES['categoryImage']['name']))){
			$imgData = $_FILES['categoryImage'];
			$response = $client->request('PUT', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'query' =>[
            	'category-details' => json_encode($data)
            ],
            'multipart' => [
	            [
	            	'name' => 'file',
	            	'contents' => file_get_contents($_FILES["categoryImage"]["tmp_name"]),
	            	'filename' => $imgData['name'],	            	
	            ],
	            [
	            	'name' => 'file',
	            	'contents' => file_get_contents($_FILES["categoryImage"]["tmp_name"]),
	            ]
            ]
            ])->getBody();

		}else{	

			$response = $client->request('PUT', API_BASE_URL.$url,
			[
            'headers' => [
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'query' =>[
            	'category-details' => json_encode($data)
            ]
            ])->getBody();
		}

		$response = json_decode($response, true);
		
		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else{
			return false;
		}
	}

	public function updateAgeGroupApi($url, $input)
	{
		$jwt_token = session('jwt_token');
		$client = new Client();
		$response = $client->request('PUT', API_BASE_URL.$url,
			[
            'headers' => [
            	'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $jwt_token
            ],
            'query' => [
            	'ageGroupId' => $input['ageGroupId']
            ]
            ])->getBody();

		$response = json_decode($response, true);
		
		if(isset($response['status']) && ($response['status'] == 1)){
			return true;
		}else{
			return false;
		}
	}
}
?>