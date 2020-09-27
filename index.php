<?php

require_once('classes.php');

$request = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);

if(is_null($request)) {
    $userArr = json_decode(file_get_contents('logs.json'), true);
    usort($userArr, 'sortByDate');
    echo json_encode($userArr);
} else {
    $factory = new StrategyFactory();
    $response = $factory->chooseStrategy($request);

    $curl = new CallTelegramApi();
    $response = $curl->sendPostRequest($response['method'][0], $response['params']);

    $json = file_get_contents('logs.json');
    $data = json_decode($json);
    $jsonArr = [];
    $jsonArr['username'] = 'https://web.telegram.org/#/im?p=@' . $request['message']['from']['username'];
    $jsonArr['message'] = $request['message']['text'];
    $jsonArr['image_url'] = $response['photo'];
    $jsonArr['requested_at'] = getTime();
    $data[] = $jsonArr;
    file_put_contents('logs.json', json_encode($data));
}

function getTime(): string {
    $tz = 'Europe/Warsaw';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp

    return $dt->format('H:i:s, d-m-Y');
}

function sortByDate($a, $b) {
    return $a['requested_at'] < $b['requested_at'];
}