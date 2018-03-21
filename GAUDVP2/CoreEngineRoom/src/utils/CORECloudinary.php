<?php
/**
 * Class CORECloudinary
 */
class CORECloudinary {

    private $eager_params = array();
    
    private $default_upload_options = array(
        "tags" => "basic_sample",
        "use_filename" => TRUE,
        "folder" => "fcreated1");
    
    public function __construct() {
        
        \Cloudinary::config(array(
            "cloud_name" => CLOUDINARY_CLOUD_NAME,
            "api_key" => CLOUDINARY_API_KEY,
            "api_secret" => CLOUDINARY_API_SECRET
        ));
    }

    public function do_uploads($image_to_be_upload_path, $preset_folder, $eager_params = null) {
        
        if (!empty($preset_folder)) {
            if(ENVIRONMENT === "Production") {
                $this->default_upload_options['folder'] = 'PROD/'.$preset_folder; //prod
            } else {
                $this->default_upload_options['folder'] = 'DEV/'.$preset_folder;// stage
            }            
        }
        
        if (empty($eager_params)) {
            $eager_params = $this->eager_params;
        }

        # Eager transformations are applied as soon as the file is uploaded, instead of waiting
        # for a user to request them. 
        $cloudinary_images_upload = \Cloudinary\Uploader::upload($image_to_be_upload_path, $this->default_upload_options);

        $cloudinary_images_upload_details = array(
            'public_id' => $cloudinary_images_upload['public_id'],
            'version' => $cloudinary_images_upload['version'],
            'image_url' => $cloudinary_images_upload['secure_url']
        );

        return $cloudinary_images_upload_details;
    }
    
    public function delete_image($cloudinary_image_public_id) {
        
        $s =\Cloudinary\Uploader::destroy($cloudinary_image_public_id,array('invalidate' => true));
    }
    
    public function getCloudinaryTransformedImageUrls($cloudinary_version=null,$cloudinary_public_id=null) {
        
        $cloudinary_transformed_images['player_screen_image_url'] = null;                
        $cloudinary_transformed_images['player_swipe_screen_image_url'] = null;
        $cloudinary_transformed_images['expert_screen_image_url'] = null;
        $cloudinary_transformed_images['play_list_screen_image_url'] = null;
        $cloudinary_transformed_images['bio_screen_image_url'] = null;
        
        $cloudinary_transformed_images['topic_screen_image_url'] = null;
            
            
        if(!empty($cloudinary_version) && !empty($cloudinary_public_id)) {
            $image_url = CLOUDINARY_SECURE_URL;
            $image_path = "/v".$cloudinary_version."/".$cloudinary_public_id.".jpg"; 
            
            $cloudinary_transformed_images['player_screen_image_url'] = $image_url.$this->play_screen_transformation.$image_path;                
            $cloudinary_transformed_images['player_swipe_screen_image_url'] = $image_url.$this->playswipe_transformation.$image_path;
            $cloudinary_transformed_images['expert_screen_image_url'] = $image_url.$this->expert_screen_transformation.$image_path;
            $cloudinary_transformed_images['play_list_screen_image_url'] = $image_url.$this->playlist_screen_transformation.$image_path;
            $cloudinary_transformed_images['bio_screen_image_url'] = $image_url.$this->bio_screen_transformation.$image_path;
            
            $cloudinary_transformed_images['topic_screen_image_url'] = $image_url.$this->topic_screen_transformation.$image_path;
            
        } 
        
        return $cloudinary_transformed_images;
    }

}
