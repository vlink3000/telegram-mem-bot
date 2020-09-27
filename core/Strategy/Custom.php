<?php

class Custom implements StrategyInterface{

    public function prepareResponse(array $request) {

        $converter = new RequestConverter();
        $requestArray = $converter->toArray($request);

        $useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";
        $ch = curl_init ("");
        curl_setopt ($ch, CURLOPT_URL, "http://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=".'risovach+создать+мем+'.$requestArray['searchWords'].'');
        curl_setopt ($ch, CURLOPT_USERAGENT, $useragent); // set user agent
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $html = curl_exec ($ch);
        curl_close($ch);

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $html, $matches);

        $urlsArr = $matches[0];
        $search = 'generator';

        $resultArr = [];
        $i=-1;
        foreach ($urlsArr as $item) {
            if (preg_match("/{$search}/i", $item)) {
                $i++;
                array_push($resultArr, $item);
            }
        }

        $tmpId = preg_replace('#^.*?(_.*?&).*$#i', '$1', $resultArr[rand(0,$i)]);

        $memId = preg_replace("/[^0-9]/","",$tmpId);

        $words = '&text1=';
        $i = 2;


        foreach ($requestArray['textParamsArr'] as $word) {
            $words .=ltrim($word).'&text'.$i.'=';
            ++$i;
        }

        $requestArray = explode (",", mb_strtolower($request['message']['text']));


        if(is_numeric($requestArray[0])){
            $url = "http://risovach.ru/generator/preview?id=".$requestArray[0].$words."";
            $memId = $requestArray[0];
        } else {
            $url = "http://risovach.ru/generator/preview?id=".$memId.$words."";
        }

        $url = str_replace(' ', '%20', $url);

        $useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";
        $ch = curl_init ("");
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_USERAGENT, $useragent); // set user agent
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $curl = curl_exec ($ch);
        curl_close($ch);

        $imgName = strtotime("now");
        file_put_contents('tmp/' . $imgName . '.png', $curl);

        $photoUrl = 'https://mem-bot-v2.5v.pl/tmp/'.$imgName.'.png';

        return [
            'params' => [
                'chat_id' => $request['message']['chat']['id'],
                'photo' => $photoUrl,
                'parse_mode' => 'html',
                'caption' => 'с помощью @memasny_bot<pre> уникальный id: </pre>'.$memId,
            ],
            'method' => [
                'sendPhoto'
            ]
        ];
    }
}