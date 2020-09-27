<?php

class Start implements StrategyInterface{

    public function prepareResponse(array $request)
    {
        $message = "Привет! Меня зовут Мем Бот и я умею делать... правильно - МЕМЫ!\n----------\n Как создать свой мем - <b>/info</b>";

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