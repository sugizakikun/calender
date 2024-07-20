<?php

namespace App\Http\Services;

class GetCalender
{
    public function execute()
    {
        // APIアクセスURL
        $url = 'https://mixtend.github.io/schedule.json';

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Content-type: application/json; charset=UTF-8', //JSON形式で表示
                'user_agent'=>"Mixtend Coding Test"
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        $raw_data = file_get_contents($url, false, $context);

        // json の内容を連想配列として $data に格納する
        return json_decode($raw_data);
    }
    
}

