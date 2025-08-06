<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Telegram
{
    public static function sendMessage($chat_id, $message)
    {
        $token = config('services.telegram.bot_token');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
