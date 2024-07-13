<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class MessageController extends Controller
{
    public function new_message(MessageRequest $request)
    {
        $result = Gemini::geminiPro(config('gemini.api_key'));
        $prompt = "This is a message from a customer via WhatsApp asking you about Laravel and PHP, so act like a Laravel Expert. Respond by formatting the response so that it matches whatsapp writing. Answer in portuguese: "
                . $request->get('Body');
        $result = Gemini::geminiPro()->generateContent([$prompt]);

        $twilio = new Client(config('twilio.account_sid'), config('twilio.auth_token'));
        $twilio->messages->create('whatsapp:+55000000000',
            [
              'from' => "whatsapp:" . config('twilio.phone_number'),
              'body' => $result->text()
            ]
        );

        response("ok", 200);
    }

    public function status(Request $request)
    {
        Log::driver('stderr')->error(json_encode($request->all()));
        Log::driver('stderr')->error('STATUS');
    }
}
