<?php
namespace App\Http\Controllers\Channels;

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

class TrendingController extends Controller {

	public function getTrending()
	{
		
		return view('channel.trendingchannel');
	}
	public function getCreateTrending()
	{
		
		return view('channel.createtrending');
	}
}
?>