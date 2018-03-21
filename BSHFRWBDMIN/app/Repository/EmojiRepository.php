<?php

namespace App\Repository;

use GuzzleHttp\Client;

class EmojiRepository {

    //=====================================================
    // Emoji/Sticker Category Functions Start
    //=====================================================
    public function getCategories($is_category = false, $type = 'emoji', $search_text = null) {
        if ($is_category === true) {
            $url = LIST_EMOJI_STICKER_CATEGORY . $type;
        } else {
            $url = LIST_EMOJIS . $type;
        }

        if (!empty($search_text)) {
            $url .= "&searchText=" . $search_text;
        }

        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();
        $response = json_decode($response, true);

        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['data']['item'];
        } else {
            return false;
        }
    }

    public function getCategoryData($url) {
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();
        $response = json_decode($response, true);

        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['data']['item'];
        } else {
            return false;
        }
    }

    public function addEmojiStickerCategory($input) {

        $data = [
            'categoryName' => $input['categoryName'],
            'type' => $input['type']
        ];
        $url = ADD_EMOJI_STICKER_CATEGORY;
        $jwt_token = session('jwt_token');
        $client = new Client();

        try {
            $response = $client->request('POST', $url, [
                        'headers' => [
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer ' . $jwt_token,
                        ],
                        'body' => json_encode($data)
                    ])->getBody();
            $response = json_decode($response, true);

            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {

            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                $error_response = $exception->errorMsg;
            } else {
                $error_response = 'could not add ' . $input['type'] . ' category';
            }
            return $error_response;
        }
    }

    public function updateEmojiCategory($input, $url) {
        $data = [
            "categoryId" => $input['categoryId'],
            "categoryName" => $input['categoryName'],
            "type" => $input['type']
        ];

        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->request('POST', $url, [
                    'headers' => [
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . $jwt_token,
                    ],
                    'body' => json_encode($data)
                ])->getBody();
        $response = json_decode($response, true);

        try {
            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCategory($id) {
        $url = DELETE_EMOJIS_STICKER_CATEGORY . $id;
        $jwt_token = session('jwt_token');

        $client = new Client();
        $error_response = '';
        try {
            $response = $client->request('DELETE', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                ]])->getBody();
            $response = json_decode($response, true);

            $result = [];
            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                $error_response = $exception->errorMsg;
            } else {
                $error_response = 'could not delete category';
            }
            return $error_response;
        }
    }

    //=====================================================
    // Emoji/Sticker Category Functions End
    //=====================================================
    //=====================================================
    // Emoji/Sticker Functions Start
    //=====================================================
    public function getEmojiStickersData($id) {
        $url = GET_EMOJI_STICKER_DATA . $id;
        $jwt_token = session('jwt_token');
        $client = new Client();
        $response = $client->get($url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwt_token
                    ]
                ])->getBody();

        $response = json_decode($response, true);

        $result = [];
        if (isset($response['status']) && ($response['status'] == 1)) {
            return $response['data']['item'];
        } else {
            return false;
        }
    }

    public function uploadEmojiStickers($input) {
        $url = UPLOAD_EMOJI_STICKER_DATA;
        $data = [
            'categoryName' => $input['categoryId'],
            'title' => $input['title'],
            'type' => $input['type']
        ];

        $error_response = '';
        $allowed =  array('png');
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) ) {
            $error_response = 'upload file extension must be .png';
            return $error_response;
        }
/*
        $image_info = getimagesize($_FILES["file"]["tmp_name"]);
        $image_width = $image_info[0];
        $image_height = $image_info[1];        
        if($image_width > 60 || $image_height > 60) {
            $error_response = 'upload file Height and Width must not exceed 60px.';
            return $error_response;
        }*/
        
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $imgData = $_FILES['file'];

            if ($_FILES['file']['size'] > UPLOAD_FILE_DATA_RESTRICTION) { //50 MB (size is also in bytes)
                $error_response = 'upload file size must be less than 50MB';
                return $error_response;
            }

            $imageString = [
                [
                    'name' => 'uploadedFile',
                    'contents' => file_get_contents($_FILES["file"]["tmp_name"]),
                    'filename' => $imgData['name'],
                ],
                [
                    'name' => 'uploadedFile',
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

                $response = $client->request('POST', $url, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $jwt_token
                            ],
                            'query' => [ 'details' => json_encode($data)],
                            'multipart' => $imageString
                        ])->getBody();
            } else {

                $response = $client->request('POST', $url, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $jwt_token
                            ],
                            'query' => [ 'details' => json_encode($data)],
                            'multipart' => []
                        ])->getBody();
            }

            $response = json_decode($response, true);
            if (isset($response['status']) && ($response['status'] === 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                $error_response = $exception->errorMsg;
                return $error_response;
            } else {
                $error_response = 'could not upload content';
                return $error_response;
            }
        }
    }

    public function updateEmojiStickers($input, $id) {

        $data = [
            'categoryId' => $input['categoryId'],
            'emojiStickerId' => $id,
            'title' => $input['title'],
            'type' => $input['type']
        ];
        $url = UPDATE_EMOJI_STICKER_DATA;
        $jwt_token = session('jwt_token');
        $client = new Client();

        $error_response = '';
        
        try {
            $response = $client->request('POST', $url, [
                        'headers' => [
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer ' . $jwt_token,
                        ],
                        'body' => json_encode($data)
                    ])->getBody();
            $response = json_decode($response, true);

            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {

            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                $error_response = $exception->errorMsg;
            } else {
                $error_response = 'could not update sticker';
            }
            return $error_response;
        }
    }

    public function deleteEmojiStickers($id) {
        $url = DELETE_EMOJIS_STICKER . $id;
        $jwt_token = session('jwt_token');

        $client = new Client();
        $error_response = '';
        try {
            $response = $client->request('DELETE', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwt_token
                ]])->getBody();
            $response = json_decode($response, true);

            $result = [];
            if (isset($response['status']) && ($response['status'] == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $exception = json_decode($e->getResponse()->getBody());
            if (isset($exception->errorMsg)) {
                $error_response = $exception->errorMsg;
            } else {
                $error_response = 'could not delete sticker';
            }
            return $error_response ;
        }
    }

    //=====================================================
    // Emoji/Sticker Functions End
    //=====================================================
}
