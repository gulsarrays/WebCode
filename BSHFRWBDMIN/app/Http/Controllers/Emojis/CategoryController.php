<?php

namespace App\Http\Controllers\Emojis;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Redis;
use JWTAuth;
use Carbon\Carbon;
use App\Repository\EmojiRepository;
use GuzzleHttp\Client;

class CategoryController extends Controller {

    public function __construct(EmojiRepository $emojirepo) {
        $this->emoji = $emojirepo;
    }

    public function index() {
        $emojiCategories = $this->emoji->getCategories(LIST_EMOJI_STICKER_CATEGORY . 'emoji');
        $stickerCategories = $this->emoji->getCategories(LIST_EMOJI_STICKER_CATEGORY . 'sticker');

        $emojis = $this->emoji->getCategories(LIST_EMOJIS . 'emoji');
        $stickers = $this->emoji->getCategories(LIST_EMOJIS . 'sticker');

        return view('emojis.index', compact('emojiCategories', 'stickerCategories', 'emojis', 'stickers'));
    }

    public function create(Request $request) {

        $v_type = 'emoji';
        if (!empty($request['type'])) {
            $v_type = $request['type'];
        }

        $emojiCategories = $this->emoji->getCategories(LIST_EMOJI_STICKER_CATEGORY . 'emoji');
        $stickerCategories = $this->emoji->getCategories(LIST_EMOJI_STICKER_CATEGORY . 'sticker');

        return view('emojis.createEmojiCat', compact('v_type', 'stickerCategories', 'emojiCategories'));
    }

    public function show() {
        
    }

    public function edit($id) {
        $emojiCat = $this->emoji->getCategoryData(GET_EMOJI_STICKER_CATEGORY . $id);
        return view('emojis.editEmojiCat', compact('emojiCat'));
    }

    public function update(Request $request, $id) {
        try {
            $input = $request->all();
            $response = $this->emoji->updateEmojiCategory($input, UPDATE_EMOJI_STICKER_CATEGORY);
            $hashtag = ($input['type'] === 'emoji') ? '#emojicategory' : '#stickercategory';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($input['type']) . ' category updated successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, 'Could not process! Please try later.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage().' Could not process! Please try later.');
        }
    }

    public function destroy($id) {
        
    }

    public function store(Request $request) {
        try {
            $input = $request->all();
            $response = $this->emoji->addEmojiStickerCategory($input);
            $hashtag = ($input['type'] === 'emoji') ? '#emojicategory' : '#stickercategory';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($input['type']) . ' category created successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, 'Could not process! Please try later.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not process! Please try later.');
        }
    }

    public function deleteCategory($type, $id) {
        try {
            $response = $this->emoji->deleteCategory($id);
            $hashtag = ($type === 'emoji') ? '#emojicategory' : '#stickercategory';
            if ($response === true) {
                return redirect('emojis' . $hashtag)->withSuccess(ucFirst($type) . ' category deleted successfully');
            } else {
                return redirect('emojis' . $hashtag)->with(ERROR, 'Could not process! Please try later.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(ERROR, $e->getMessage() . ' Could not delete! Please try later.');
        }
    }

}
