<?php

require_once('classes.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

//get response from telegram api
$request = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);

//save logs, info about  latest conversation
file_put_contents( 'bot_logs.txt', file_get_contents('php://input'));

if(is_null($request)) {
    if(isset($_COOKIE['secret']) && $_COOKIE['secret'] === 'vova' ) {
        readfile("FE/index.html");
    } else{
        readfile("FE/auth.html");
    }
} else {
    //chose response strategy
    $factory = new StrategyFactory();
    $response = $factory->chooseStrategy($request);

    //send response message to user
    $curl = new CallTelegramApi();
    $curl->sendPostRequest($response['method'][0], $response['params']);
}