<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREAwsBridge.php
  Description                 : Amazon S3 related functions
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\S3\S3Client;

/**
 * Class COREAwsBridge
 */
class COREAwsBridge
{
    private static $s3Client         = null;
    private static $transcoderClient = null;

    private $key    = 'AKIAJGDMPNCMTTXSALSQ';
    private $secret = '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';

    const ExpertAvatarBucketName = 'com-audvisor-expert-avatars';
    const TopicIconBucketName    = 'com-audvisor-topic-icons';

    const MasterInsightBucketName    = 'com-audvisor-insight-masters';
    const StreamingInsightBucketName = 'com-audvisor-insight-streams';

    const ExpertVoiceOverBucketName  = 'com-audvisor-expert-voiceover';
    const InsightVoiceOverBucketName = 'com-audvisor-insight-voiceover';
    
    private $advisorClientIdsArr = array('audvisor11012017','audvisor','audvisor11012017Test');
    const AudvisorBucketSuffix = '-audvisor11012017';

    const TranscoderPipeline       = '1421146511956-y2uhmr'; // Insights_HLS_Pipeline_Prod_Audv11012017 (B2B prod)
    const TranscoderPipeline_Stage = '1487245380204-jtqao7'; // Insights_HLS_Pipeline_Stage_Compasites (B2B stage)

    private $buckets = array(
        'com-audvisor-expert-avatars',
        'com-audvisor-expert-voiceover',
        'com-audvisor-topic-icons',
        'com-audvisor-insight-voiceover',
        'com-audvisor-insight-masters',
        'com-audvisor-insight-streams');

    public function __construct()
    {
    }

    /**
     * @return S3Client|null
     */
    private function GetS3Client()
    {
        if(is_null(self::$s3Client))
        {
            self::$s3Client = S3Client::factory(array(
                                                    'key'    => $this->key,
                                                    'secret' => $this->secret,
                                                ));
        }

        return self::$s3Client;
    }

    /**
     * @return ElasticTranscoderClient|null
     */
    private function GetTranscoderClient()
    {
        if(is_null(self::$transcoderClient))
        {
            self::$transcoderClient = ElasticTranscoderClient::factory(array(
                                                                           'key'    => $this->key,
                                                                           'secret' => $this->secret,
                                                                           'region' => 'us-west-2'
                                                                       ));
        }

        return self::$transcoderClient;
    }

    /**
     * @param $filePath
     * @param $imageName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadAvatarToS3($filePath, $imageName)
    {
        $imageName = '/avatars/'.$imageName;

        return $this->UploadFileToS3($this->GetExpertAvatarBucketName(), $filePath, $imageName, true);
    }

    /**
     * @param $keyName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function DeleteAvatarFromS3($keyName)
    {
        $s3     = S3Client::factory();
        $bucket = $this->GetExpertAvatarBucketName();
        $result = $s3->deleteObject(array(
                                        'Bucket' => $bucket,
                                        'Key'    => $keyName
                                    ));

        return $result;
    }

    /**
     * @param $avatarsToUpload
     *
     * @return mixed
     */
    public function UploadAvatarsToS3($avatarsToUpload)
    {

        return $this->UploadFilesToS3($this->GetExpertAvatarBucketName(), $avatarsToUpload, '/avatars/', true);
    }

    /**
     * This DOES NOT validate the URL but merely provides a S3(or CDN) URL by prefixing the provided path with appropriate URL domain.
     *
     * @param $imageName
     *
     * @return string
     */
    public function GetS3ExpertAvatarURL($imageName,$clientId="")
    {
        return $imageName;
        // for cloudinary images implementation -  Start
       /* $imageName = '/avatars/'.$imageName;

        return $this->GetTimeExpiringS3URL($this->GetExpertAvatarBucketName($clientId), $imageName, '');
        */
        // for cloudinary images implementation -  End
    }

    /**
     * @param $imageName
     *
     * @return null
     */
    public function GetS3ExpertAvatarURLs($imageName,$clientId="")
    {
        $expertImage_s3_urls =  array();
        if(is_array($imageName) && !empty($imageName)) {
            for($i = 0; $i < count($imageName); $i++)
            {
                $expertImage_s3_urls[$imageName[$i]] = $imageName[$i];
            }
        }
        return $expertImage_s3_urls;
        // for cloudinary images implementation -  Start
        /*
        $expertImage_s3_urls = null;
        for($i = 0; $i < count($imageName); $i++)
        {
            $ExpertImageName[$i]                 = '/avatars/'.$imageName[$i];
            $expertImage_s3_urls[$imageName[$i]] = $this->GetTimeExpiringS3URL($this->GetExpertAvatarBucketName($clientId), $ExpertImageName[$i], '');
        }

        return $expertImage_s3_urls;
        */
        // for cloudinary images implementation -  End
    }

    /**
     * @param $iconsToUpload
     *
     * @return mixed
     */
    public function UploadTopicIconsToS3($iconsToUpload)
    {
        return $this->UploadFilesToS3($this->GetTopicIconBucketName(), $iconsToUpload, '/topic_icons/', true);
    }

    /**
     * @param $filePath
     * @param $imageName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadTopicIconToS3($filePath, $imageName)
    {
        $imageName = '/topic_icons/'.$imageName;

        return $this->UploadFileToS3($this->GetTopicIconBucketName(), $filePath, $imageName, true);
    }

    /**
     * @param $imageName
     *
     * @return string
     */
    public function GetS3TopicIconURL($imageName,$clientId)
    {
        return $imageName;
        // for cloudinary images implementation -  Start
        /*
        $imageName = '/topic_icons/'.$imageName;

        return $this->GetTimeExpiringS3URL($this->GetTopicIconBucketName($clientId), $imageName, '');
        */
    }

    /**
     * @param $imageName
     *
     * @return null
     */
    public function GetS3TopicIconURLs($imageName)
    {
        $topic_icon_s3_urls = null;
        for($i = 0; $i < count($imageName); $i++)
        {
            $imageName[$i]          = '/topic_icons/'.$imageName[$i];
            $topic_icon_s3_urls[$i] = $this->GetTimeExpiringS3URL($this->GetTopicIconBucketName(), $imageName[$i], '');
        }

        return $topic_icon_s3_urls;
    }

    /**
     * @param $filePath
     * @param $insightName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadInsightToS3($filePath, $insightName, $client_id=null)
    {
        return $this->UploadFileToS3($this->GetMasterInsightBucketName($client_id), $filePath, $insightName, false,$client_id);
    }

    /**
     * @param      $bucketName
     * @param      $filePath
     * @param      $s3Path
     * @param bool $makePublic
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadFileToS3($bucketName, $filePath, $s3Path, $makePublic = false, $client_id=null)
    {
        if(!empty($client_id)) {
            //$s3Path = $client_id."/".$s3Path;
        }
        $s3_params = array(
            'Bucket'       => $bucketName,
            'Key'          => $s3Path,
            'SourceFile'   => $filePath,
            'CacheControl' => 'max-age=315360000',
            'Expires'      => gmdate("D, d M Y H:i:s T", strtotime("+10 year")),
        );

        if($makePublic)
        {
            $s3_params['ACL'] = 'public-read';
        }

        return $this->GetS3Client()->putObject($s3_params);
    }

    /**
     * @param      $bucketName
     * @param      $localFilePaths
     * @param      $s3FolderName
     * @param bool $makePublic
     *
     * @return mixed Returns the result of the executed command or an array of commands if executing multiple commands
     */
    public function UploadFilesToS3($bucketName, $localFilePaths, $s3FolderName, $makePublic = false)
    {
        $s3     = $this->GetS3Client();
        $s3_ops = array();

        foreach($localFilePaths as $avatar)
        {
            //k TODO: basename may not play nice with non-Ascii chars. https://bugs.php.net/bug.php?id=37268
            $s3_path   = $s3FolderName.'/'.basename($avatar);
            $s3_params = array(
                'Bucket'       => $bucketName,
                'Key'          => $s3_path,
                'SourceFile'   => $avatar,
                'CacheControl' => 'max-age=315360000',
                'Expires'      => gmdate("D, d M Y H:i:s T", strtotime("+10 year")),
            );

            if($makePublic)
            {
                $s3_params['ACL'] = 'public-read';
            }

            $s3_ops[] = $s3->getCommand('PutObject', $s3_params);;
        }

        /* Execute the requests in parallel. This may take a few seconds to a few minutes depending on the size of the files and how fast your upload speeds are. */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $file_upload_response = $s3->execute($s3_ops);

        return $file_upload_response;
    }

    /**
     * @param        $bucketName
     * @param        $s3Path
     * @param string $expiry
     *
     * @return string
     */
    public function GetTimeExpiringS3URL($bucketName, $s3Path, $expiry = '+12 hours')
    {
        $S3URL = null;
        if($expiry == '')
        {
            $S3URL = $this->GetS3Client()->getObjectUrl($bucketName, $s3Path);
            $S3URL = $this->GetCloudFrontURL($bucketName, $S3URL);
        }
        else
        {
            $S3URL = $this->GetS3Client()->getObjectUrl($bucketName, $s3Path, $expiry);
        }

        return $S3URL;
    }

    /**
     * This DOES NOT validate the URL but merely provides a S3(or CDN) URL by prefixing the provided path with appropriate URL domain.
     *
     * @param $insightFilePath
     *
     * @return string
     */
    public function GetS3InsightURL($insightFilePath,$clientId=Null)
    {
        return $this->GetTimeExpiringS3URL($this->GetStreamingInsightBucketName($clientId), $insightFilePath, '');
    }

    /**
     * @param $insightFileName
     *
     * @return string
     */
    public function GetS3MasterInsightURL($insightFileName,$clientId=Null)
    {
        return $this->GetTimeExpiringS3URL($this->GetMasterInsightBucketName($clientId), $insightFileName,'');
    }

    /**
     * @param $s3FileName
     *
     * @return mixed
     */
    public function PrepareInsightForHLS($s3FileName)
    {
        # HLS Presets that will be used to create an adaptive bit-rate playlist.
        $hls_28k_audio_preset_id  = '1424842096652-a0e2je';
        $hls_64k_audio_preset_id  = '1351620000001-200071';
        $hls_160k_audio_preset_id = '1351620000001-200060';

        $hls_presets = array(
            'hlsAudio28'  => $hls_28k_audio_preset_id,
            'hlsAudio64'  => $hls_64k_audio_preset_id,
            'hlsAudio160' => $hls_160k_audio_preset_id,
        );

        return $this->CreateHLSJob($this->GetTranscoderClient(), $this->GetTranscoderPipelineID(), $s3FileName, '', $hls_presets, 10);
    }

    /**
     * Returns the first playlist URL.
     *
     * @deprecated Use GetHLSPlaylistURLsForJob instead.
     *
     * @param $transcoderJob
     *
     * $transcoderResponse = PrepareInsightForHLS($s3FileName);
     * $transcoderJob = $transcoderResponse['transcoderJob'];
     *
     * @return string
     */
    public function GetHLSPlaylistURLForJob($transcoderJob,$client_id)
    {
        $s3TranscodedPath = $transcoderJob['OutputKeyPrefix'].$transcoderJob['Playlists'][0]['Name'].'.m3u8';

        $bucketName = $this->GetStreamingInsightBucketName($client_id);
        $S3URL      = $this->GetS3Client()->getObjectUrl($bucketName, $s3TranscodedPath);

        $S3URL = $this->GetCloudFrontURL($bucketName, $S3URL);

        return $S3URL;
    }

    /**
     * The paths are stored under the key designated with playlist format. At present, HLSv3 and HLSv4 are the two supported playlists.
     * If absolute URLs are required, use the method GetHLSPlaylistURLsForJob.
     *
     * @param $transcoderJob
     *
     * @return array|null
     */
    public function GetHLSPlaylistsForJob($transcoderJob)
    {
        $playlistPaths = NULL;

        foreach($transcoderJob['Playlists'] as $playlist)
        {
            $s3TranscodedPath                   = $transcoderJob['OutputKeyPrefix'].$playlist['Name'].'.m3u8';
            $playlistPaths[$playlist['Format']] = $s3TranscodedPath;
        }

        return $playlistPaths;
    }

    /**
     * The URLs are stored under the key designated with playlist format. At present, HLSv3 and HLSv4 are the two supported playlists.
     * If relative paths are desired, use the method GetHLSPlaylistsForJob.
     *
     * @param $transcoderJob
     *
     * @return array|null
     */
    public function GetHLSPlaylistURLsForJob($transcoderJob,$client_id)
    {
        $playlistURLs  = NULL;
        $playlistPaths = $this->GetHLSPlaylistsForJob($transcoderJob);
        $bucketName    = $this->GetStreamingInsightBucketName($client_id);

        foreach($playlistPaths as $playlistType => $playlistPath)
        {
            $S3URL = $this->GetS3Client()->getObjectUrl($bucketName, $playlistPath);
            $S3URL = $this->GetCloudFrontURL($bucketName, $S3URL);

            $playlistURLs[$playlistType] = $S3URL;
        }

        return $playlistURLs;
    }

    /**
     * @param $transcoder_client ElasticTranscoderClient
     * @param $pipeline_id
     * @param $input_key
     * @param $output_key_prefix
     * @param $hls_presets
     * @param $segment_duration
     *
     * @return mixed
     */
    private function CreateHLSJob($transcoder_client, $pipeline_id, $input_key, $output_key_prefix, $hls_presets, $segment_duration)
    {
        # Setup the job input using the provided input key.
        $input = array('Key' => $input_key);

        #Setup the job outputs using the HLS presets.
        $output_key = hash('sha256', utf8_encode($input_key));

        # Specify the outputs based on the hls presets array specified.
        $outputs = array();
        foreach($hls_presets as $prefix => $preset_id)
        {
            array_push($outputs, array('Key' => "$prefix/$prefix", 'PresetId' => $preset_id, 'SegmentDuration' => $segment_duration));
        }

        # Setup master playlist which can be used to play using adaptive bit-rate.
        $playlist = array(
            'Name'       => 'hls',
            'Format'     => 'HLSv3',
            'OutputKeys' => array_map(function ($x)
            {
                return $x['Key'];
            }, $outputs)
        );

        $playlistV4 = array(
            'Name'       => 'hls4',
            'Format'     => 'HLSv4',
            'OutputKeys' => array_map(function ($x)
            {
                return $x['Key'];
            }, $outputs)
        );

        # Create the job.
        $create_job_request = array(
            'PipelineId'      => $pipeline_id,
            'Input'           => $input,
            'Outputs'         => $outputs,
            'OutputKeyPrefix' => "$output_key_prefix$output_key/",
            'Playlists'       => array($playlist, $playlistV4)
        );

        $create_job_result = $transcoder_client->createJob($create_job_request)->toArray();

        return $create_job_result['Job'];
    }

    /**
     * @param $filePath
     * @param $ExpertVoiceOverFileName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadExpertVoiceOver($filePath, $ExpertVoiceOverFileName)
    {
        $ExpertVoiceOverFileName = '/expert_voiceover/'.$ExpertVoiceOverFileName;

        return $this->UploadFileToS3($this->GetExpertVoiceOverBucketName(), $filePath, $ExpertVoiceOverFileName, true);
    }

    /**
     * @param $filePath
     * @param $InsightVoiceOverFileName
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function UploadInsightVoiceOver($filePath, $InsightVoiceOverFileName,$clientId=Null)
    {
        $InsightVoiceOverFileName = '/insight_voiceover/'.$InsightVoiceOverFileName;

        return $this->UploadFileToS3($this->GetInsightVoiceOverBucketName($clientId), $filePath, $InsightVoiceOverFileName, true);
    }

    /**
     * @param $ExpertVoiceOverFileName
     *
     * @return string
     */
    public function GetExpertVoiceOverURL($ExpertVoiceOverFileName,$clientId=Null)
    {
        $ExpertVoiceOverFileName = '/expert_voiceover/'.$ExpertVoiceOverFileName;

        return $this->GetTimeExpiringS3URL($this->GetExpertVoiceOverBucketName($clientId), $ExpertVoiceOverFileName, '');
    }

    /**
     * @param $InsightVoiceOverFileName
     *
     * @return string
     */
    public function GetInsightVoiceOverURL($InsightVoiceOverFileName,$clientId=Null)
    {
        $InsightVoiceOverFileName = '/insight_voiceover/'.$InsightVoiceOverFileName;

        return $this->GetTimeExpiringS3URL($this->GetInsightVoiceOverBucketName($clientId), $InsightVoiceOverFileName, '');
    }

    /**
     * @return string
     */
    private function GetTopicIconBucketName($clientId=Null)
    {
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            $clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID];
            $bucket_suffix = '-'.$clientId;
        }         
        return (self::TopicIconBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetExpertAvatarBucketName($clientId=Null)
    {
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            $clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID];
            $bucket_suffix = '-'.$clientId;
        }         
        return (self::ExpertAvatarBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetExpertVoiceOverBucketName($clientId=Null)
    { 
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            $clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID];
            $bucket_suffix = '-'.$clientId;
        }         
        return (self::ExpertVoiceOverBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetInsightVoiceOverBucketName($clientId=Null)
    {
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            $clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID];
            $bucket_suffix = '-'.$clientId;
        }
        return (self::InsightVoiceOverBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetMasterInsightBucketName($clientId=null)
    {
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            //$clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID];
            $clientId = STATIC_BUCKET_NAME_CLIENT_ID; // so all insights will store under one bucket
            $bucket_suffix = '-'.$clientId;
        }        
        return (self::MasterInsightBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetStreamingInsightBucketName($clientId=Null)
    {
        if(in_array($clientId, $this->advisorClientIdsArr)) {
            $bucket_suffix = self::AudvisorBucketSuffix;
        } else {
            //$clientId = ($clientId)?$clientId:$_SESSION[CLIENT_ID]; 
            $clientId = STATIC_BUCKET_NAME_CLIENT_ID; // so all insights will store under one bucket
            $bucket_suffix = '-'.$clientId;
        }        
        return (self::StreamingInsightBucketName.$this->GetBucketSuffixForCurrentEnvironment().$bucket_suffix);
    }

    /**
     * @return string
     */
    private function GetBucketSuffixForCurrentEnvironment()
    {
        return (ENVIRONMENT === "Production") ? "-prod" : ((ENVIRONMENT === "Stage") ? "-stage" : "-dev");
    }

    /**
     * @return string
     */
    private function GetTranscoderPipelineID()
    {
        return (ENVIRONMENT === "Production") ? self::TranscoderPipeline : ((ENVIRONMENT === "Stage") ? self::TranscoderPipeline_Stage : self::TranscoderPipeline_Dev);
    }

    /**
     * @param $bucketName
     * @param $S3URL
     *
     * @return string
     */
    private function GetCloudFrontURL($bucketName, $S3URL)
    {
        $cloudFrontURL    = $S3URL;
        $cloudFrontDomain = $this->GetCloudFrontDomainForS3Bucket($bucketName);

        if($cloudFrontDomain)
        {
            $s3bucketURL     = $bucketName.'.s3.amazonaws.com';
            $patterns        = array();
            $patterns[0]     = '/https/';
            $patterns[1]     = '/'.$s3bucketURL.'/';
            $replacements    = array();
            $replacements[2] = 'http';
            $replacements[1] = $cloudFrontDomain;
            $cloudFrontURL   = preg_replace($patterns, $replacements, $cloudFrontURL);

            if(null == $cloudFrontURL)
            {
                $cloudFrontURL = $S3URL;
            }
        }

        return $cloudFrontURL;
    }

    /**
     * @param $bucketName
     *
     * @return null|string
     */
    private function GetCloudFrontDomainForS3Bucket($bucketName)
    {
        $cloudFrontDomain = null;
        switch($bucketName)
        {
            case 'com-audvisor-insight-streams':
            {
                $cloudFrontDomain = 'dh3ky7erntdm.cloudfront.net';
                break;
            }
            case 'com-audvisor-topic-icons':
            {
                $cloudFrontDomain = 'd17v6h1365yoj9.cloudfront.net';
                break;
            }
            case 'com-audvisor-insight-voiceover':
            {
                $cloudFrontDomain = 'dgt2jjsw8f9tx.cloudfront.net';
                break;
            }
            case 'com-audvisor-expert-avatars':
            {
                $cloudFrontDomain = 'd1njiflr8ih92q.cloudfront.net';
                break;
            }
            case 'com-audvisor-expert-voiceover':
            {
                $cloudFrontDomain = 'di9mvinkqnp8a.cloudfront.net';
                break;
            }
            case 'insights-stream':
            {
                $cloudFrontDomain = 'd1813oz3ffthx4.cloudfront.net';
                break;
            }
            case 'com-audvisor-expert-avatars-stage':
            {
                $cloudFrontDomain = 'd2jd25nui2edb3.cloudfront.net';
                break;
            }
        }

        return $cloudFrontDomain;
    }
    
    /**
     * @param $clientId
     *
     */
    public function createBuckets($clientId)
    {
        foreach($this->buckets as $bucket) {
            echo $bucket.$this->GetBucketSuffixForCurrentEnvironment().'-'.$clientId."<br>";
            $this->GetS3Client()->PutBucket(array(
                'Bucket'             => $bucket.$this->GetBucketSuffixForCurrentEnvironment().'-'.$clientId,
                'LocationConstraint' => 'us-west-2',
            ));
        }
    }
}

