<?php

namespace App\Http\Controllers\Channels;

use Illuminate\Routing\Controller;
use App\Repository\ChannelRepository as ChannelRepo;

use Illuminate\Http\Request;

class ChannelController extends Controller {

	public function __construct(ChannelRepo $channelRepo)
	{
		$this->channel = $channelRepo;
	}

	public function createChannel(Request $request)
	{
			
		$this->channel->createChannel($request->all(), CREATE_CHANNEL);
		
	}

	public function viewChannel($chId)
	{
		// get channel details
		$channelData = $this->channel->getChannelContent(FETCH_CHANNEL_CONTENT.$chId);
		
		return view('channel.view_channel',compact('chId','channelData'));
	}

	public function getComments($content_id)
	{
		$channelData = $this->channel->getContentComments(FETCH_CONTENT_COMMENT.$content_id);
		return $channelData;
	}

	public function channelReminder($chId)
	{
		$channelData = $this->channel->sendChannelReminder(SEND_REMINDER.$chId);
		return $channelData;
	}

	public function updateSettings(Request $request)
	{
		$channelData = $this->channel->updateReminderDuration($request->all(), AD_API_BASE.UPDATE_EMAIL_SETTING);
		if($channelData){
			return redirect ('/sadmin#emailsetting')->withSuccess ( "Updated successfully" );
		}

		return redirect ('/sadmin#emailsetting')->withError ( "Could not update!" );
	}

	public function uploadContent(Request $request)
	{
		$input = $request->all();
		$channelData = $this->channel->uploadContent($input);
	}
	public function deleteContent($content_id)
	{
		$channelData = $this->channel->deleteContent(DELETE_CONTENT_DETAILS.$content_id);
	}
        public function getContent($content_id)
	{
		$channelData = $this->channel->getContent(FETCH_CONTENT_DETAILS.$content_id);
		return $channelData;
	}
        public function updateContent(Request $request)
	{
		$input = $request->all();
		$channelData = $this->channel->updateContent($input);
	}

	public function getContentById($content_id)
	{
		$channelData = $this->channel->getContent(FETCH_CONTENT_DETAILS.$content_id);

		if(!$channelData){
			echo '0';
		}else{
			return $channelData;
		}		
	}
}