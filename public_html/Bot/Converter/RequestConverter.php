<?php

class RequestConverter
{
    public function toArray($request): array
    {

        $requestArray = explode (",", mb_strtolower($request['message']['text']));

        $searchWords = str_replace(' ', '+', $requestArray[0]);

        $textParamsArr = [];

        foreach ($requestArray as &$item) {
            array_push($textParamsArr,$item);
        }

        unset($textParamsArr[0]);

        $requestArray = [
            'searchWords' => $searchWords,
            'textParamsArr' => $textParamsArr
        ];

        return $requestArray;
    }
}