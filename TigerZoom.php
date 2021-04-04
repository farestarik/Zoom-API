<?php

namespace App\Libraries\Zoom;

class TigerZoom{

  public static function createZoomMeeting($meetingConfig = []){
    
    if(is_null(\zoom_refresh_token())){
        return ['response' => null];
    }

    $requestBody = [
        'topic'			=> $meetingConfig['topic'] 		?? 'TIGER ZOOM',
        'type'			=> $meetingConfig['type'] 		?? 2,
        'start_time'	=> $meetingConfig['start_time']	?? date('Y-m-dTh:i:00').'Z',
        'duration'		=> $meetingConfig['duration'] 	?? 30,
        'password'		=> $meetingConfig['password'] 	?? mt_rand(),
        'timezone'		=> 'Africa/Cairo',
        'agenda'		=> 'PHP Session',
        'settings'		=> [
              'host_video'			=> false,
              'participant_video'		=> true,
              'cn_meeting'			=> false,
              'in_meeting'			=> false,
              'join_before_host'		=> true,
              'mute_upon_entry'		=> true,
              'watermark'				=> false,
              'use_pmi'				=> false,
              'approval_type'			=> 1,
              'registration_type'		=> 1,
              'audio'					=> 'voip',
            'auto_recording'		=> 'none',
            'waiting_room'			=> false
        ]
    ];

    // $zoomUserId = "q_c3VW6hQAG5Fi83u0X_xg";
    if(getZoomUserId() == null){
      return ['response' => 'uid'];
    }
    $zoomUserId = getZoomUserId();

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/users/".$zoomUserId."/meetings",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($requestBody),
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".getZoomJwtToken(),
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    

    if(isset(json_decode($response)->code)){
      if(json_decode($response)->code == 124){
        self::reGenerateToken();
      }
    }
    
    if ($err) {
      //dd("SD");
      return [
          'success' 	=> false, 
          'msg' 		=> 'cURL Error #:' . $err,
          'response' 	=> ''
      ];
    } else {
      return [
          'success' 	=> true,
          'msg' 		=> 'success',
          'response' 	=> json_decode($response)
      ];
    }
  }

  public static function updateZoomMeeting($id, $meetingConfig = []){
    if(is_null(\zoom_refresh_token())){
      return ['response' => null];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/meetings/".$id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PATCH",
      CURLOPT_POSTFIELDS => json_encode($meetingConfig),
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".getZoomJwtToken(),
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if(isset(json_decode($response)->code)){
      if(json_decode($response)->code == 124){
        self::reGenerateToken();
      }
    }

    if ($err) {
      return [
          'success' 	=> false, 
          'msg' 		=> 'cURL Error #:' . $err,
          'response' 	=> ''
      ];
    } else {
      return [
          'success' 	=> true,
          'msg' 		=> 'success',
          'response' 	=> json_decode($response)
      ];
    } 

   
  } // End Update Meeting Method

  public static function readZoomMeeting($id){

    if(is_null(\zoom_refresh_token())){
      return ['response' => null];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/meetings/".$id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".getZoomJwtToken(),
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if(isset(json_decode($response)->code)){
      if(json_decode($response)->code == 124){
        self::reGenerateToken();
      }
    }

    if ($err) {
      return [
          'success' 	=> false, 
          'msg' 		=> 'cURL Error #:' . $err,
          'response' 	=> ''
      ];
    } else {
      return [
          'success' 	=> true,
          'msg' 		=> 'success',
          'response' 	=> json_decode($response)
      ];
    } 

   
  } // End Read Meeting Method

  public static function deleteZoomMeeting($id){

    if(is_null(\zoom_refresh_token())){
      return ['response' => null];
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/meetings/".$id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".getZoomJwtToken(),
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if(isset(json_decode($response)->code)){
      if(json_decode($response)->code == 124){
        self::reGenerateToken();
      }
    }

    if ($err) {
      return [
          'success' 	=> false, 
          'msg' 		=> 'cURL Error #:' . $err,
          'response' 	=> ''
      ];
    } else {
      return [
          'success' 	=> true,
          'msg' 		=> 'success',
          'response' 	=> json_decode($response)
      ];
    } 

   
  } // End Delete Meeting Method

  public static function reGenerateToken(){

    $client = new \GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token?grant_type=refresh_token&refresh_token='.zoom_refresh_token(), [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(env('ZOOM_CLIENT_ID').':'.env('ZOOM_CLIENT_SECRET'))
                ],
                'form_params' => [
                    // "grant_type" => "refresh_token",
                    // "refresh_token" => \zoom_refresh_token()
                ]
            ]);
    $refresh_token = json_decode($response->getBody()->getContents(), true);
    \update_zoom_refresh_token($refresh_token);
    return true;
  } // End Regenrate Token Method


  public static function requestToken($code){
    $client = new \GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token?grant_type=authorization_code&code='.$code.'&redirect_uri='.env("ZOOM_REDIRECT_URI"), [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(env('ZOOM_CLIENT_ID').':'.env('ZOOM_CLIENT_SECRET'))
                ],
                'form_params' => [
                    
                ]
            ]);
        $response = json_decode($response->getBody()->getContents(), true);
        \update_zoom_refresh_token(json_encode($response));
  } // End Request Token Method

  public static function requestUserId($email = null){
    if(!$email){
      return false;
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/users/".$email,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".getZoomJwtToken(),
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if(isset(json_decode($response)->code)){
      if(json_decode($response)->code == 124){
        self::reGenerateToken();
      }
    }

    if ($err) {
      return [
          'success' 	=> false, 
          'msg' 		=> 'cURL Error #:' . $err,
          'response' 	=> ''
      ];
    } else {
      return [
          'success' 	=> true,
          'msg' 		=> 'success',
          'response' 	=> json_decode($response)->id
      ];
    } 

   
  } // End Request UID Method

}

// Data Attributes 
/**
 * topic
 * type
 * start_time
 * agenda
 * password
 * settings => 
 * [
 *  host_video,
 *  participant_video,
 *  approval_type,
 *  waiting_room,
 *  allow_multiple_devices,
 *  show_share_button,
 *  join_before_host,
 *  mute_upon_entry
 * ]
 */
