<?php

namespace App\Http\Controllers\Emojis;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Redis;
use JWTAuth;
use Carbon\Carbon;
use App\Repository\EmojiRepository;
use GuzzleHttp\Client;

class EmojisController extends Controller {

    public function __construct(EmojiRepository $emojirepo) {
        $this->emoji = $emojirepo;
    }

    public function index(Request $request) {

        $search_text_emoji = '';
        $search_text_sticker = '';
        $search_text_emojicategory = '';
        $search_text_stickercategory = '';
        $search_text = '';
        $search_text_arr = array(
            'search_in_emoji' => '',
            'search_in_sticker' => '',
            'search_in_emojicategory' => '',
            'search_in_stickercategory' => ''
        );

        if (!empty($request['search_in_emoji'])) {
            $search_text_emoji = $request['search_in_emoji'];
            $search_text_arr['search_in_emoji'] = $search_text_emoji;
            $search_text = $search_text_emoji;
        } else if (!empty($request['search_in_sticker'])) {
            $search_text_sticker = $request['search_in_sticker'];
            $search_text_arr['search_in_sticker'] = $search_text_sticker;
            $search_text = $search_text_sticker;
        } else if (!empty($request['search_in_emojicategory'])) {
            $search_text_emojicategory = $request['search_in_emojicategory'];
            $search_text_arr['search_in_emojicategory'] = $search_text_emojicategory;
            $search_text = $search_text_emojicategory;
        } else if (!empty($request['search_in_stickercategory'])) {
            $search_text_stickercategory = $request['search_in_stickercategory'];
            $search_text_arr['search_in_stickercategory'] = $search_text_stickercategory;
            $search_text = $search_text_stickercategory;
        }

        $emojiCategories = $this->emoji->getCategories(true, 'emoji', $search_text_emojicategory);
        $stickerCategories = $this->emoji->getCategories(true, 'sticker', $search_text_stickercategory);

        $emojis = $this->emoji->getCategories(false, 'emoji', $search_text_emoji);
        $stickers = $this->emoji->getCategories(false, 'sticker', $search_text_sticker);


        return view('emojis.index', compact('emojiCategories', 'stickerCategories', 'emojis', 'stickers', 'search_text_arr', 'search_text'));
    }

    public function create(Request $request) {
        $v_type = 'emoji';
        if (!empty($request['type'])) {
            $v_type = $request['type'];
        }

        $emojiCategories = $this->emoji->getCategories(true, 'emoji');
        $stickerCategories = $this->emoji->getCategories(true, 'sticker');

        return view('emojis.createEmojis', compact('v_type', 'stickerCategories', 'emojiCategories'));
    }

    public function show() {
        
    }

    public function edit($id) {
        $emojiStrickerData = array();
        $emojiStrickerData = $this->emoji->getEmojiStickersData($id);
        $emojiCategories = $this->emoji->getCategories(true, 'emoji');
        $stickerCategories = $this->emoji->getCategories(true, 'sticker');

        return view('emojis.editEmoji', compact('emojiStrickerData', 'stickerCategories', 'emojiCategories'));
    }

    public function update(Request $request, $id) {
        try {
            $input = $request->all();
            $response = $this->emoji->updateEmojiStickers($input, $id);
            $hashtag = ($input['type'] === 'emoji') ? '#emoji' : '#sticker';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($input['type']) . ' updated successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, $response.' Could not process! Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not process! Please try later.');
        }
    }

    public function destroy($id) {
        
    }

    public function deleteEmojiStickers($type, $id) {
        try {
            $response = $this->emoji->deleteEmojiStickers($id);
            $hashtag = ($type === 'emoji') ? '#emoji' : '#sticker';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($type) . ' deleted successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, $response.' Could not process! Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not delete! Please try later.');
        }
    }

    public function store(Request $request) {
        try {
            $input = $request->all();
            $response = $this->emoji->uploadEmojiStickers($input);
            $hashtag = ($input['type'] === 'emoji') ? '#emoji' : '#sticker';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($input['type']) . ' created successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, $response.' Could not process! Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not process! Please try later.');
        }
    }

}
