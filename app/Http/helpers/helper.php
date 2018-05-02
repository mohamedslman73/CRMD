<?php

function loadOption($option)
{
    $option = \App\Settings::getOption($option);
    return $option;
}

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
function notify1($id, $msg)
{
    if (!defined('API_ACCESS_KEY1'))
        define('API_ACCESS_KEY1', 'AAAA6_P3TvM:APA91bGNkpv1pEGt_e3ClSv5c7BPb1R_jm8a7w1YrvvkLycO4Z2IV9Rd0AHkfFPtNLtDowinuwO5VYwgQJlj4CFhvUPp0eWhNzu9Xp2RFhAuunHdlTchGpKzqjvFF3uWCNMdbcG-5TTT');

    foreach ($id as $registrationId) {
        $fields = array
        (
            'to' => $registrationId,
            'notification' => $msg,
            'data' => null,
        );
//dd($msg);
       // dd($fields);
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY1,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
     //   dd($result);
        curl_close($ch);
    }

}