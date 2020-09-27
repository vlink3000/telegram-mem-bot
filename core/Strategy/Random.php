<?php

class Random implements StrategyInterface{

    public function prepareResponse(array $request)
    {
        $message = "Функция в разработке";

        return [
            'params' => [
                'chat_id' => $request['message']['chat']['id'],
                'parse_mode' => 'html',
                'text' => $message
            ],
            'method' => [
                'sendMessage'
            ]
        ];
    }
}