<?php

namespace App\Libraries\Zoom;

class TigerZoom{

  const jwtToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IldTSURCOWFkVHAteTNnMTNQc3ZpbHciLCJleHAiOjE2MTY4NjkxOTMsImlhdCI6MTYxNjI2NDM5M30.WHWz2G5e2oNSHEe3vCnWEyoxxIqDAkm4HuD8SYemzXg';

  public static function createZoomMeeting($meetingConfig = []){
    
    $requestBody = [
        'topic'			=> $meetingConfig['topic'] 		?? 'PHP General Talk',
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

    $zoomUserId = "q_c3VW6hQAG5Fi83u0X_xg";

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
        "Authorization: Bearer ".self::jwtToken,
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

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
  }

  public static function updateZoomMeeting($id, $meetingConfig = []){

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
        "Authorization: Bearer ".self::jwtToken,
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

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
        "Authorization: Bearer ".self::jwtToken,
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

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
        "Authorization: Bearer ".self::jwtToken,
        "Content-Type: application/json",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

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