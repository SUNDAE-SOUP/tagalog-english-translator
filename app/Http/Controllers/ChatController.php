<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatController extends Controller
{

    public function chat(Request $request): string
    {

        try {
            /** @var array $response */
            $response = json_decode(Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('OPEN_API_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                        "model" => $request->post('model'),
                        "store" => true,
                        "messages" => [
                            [
                                "role" => "user",
                                "content" => $request->post('content')
                            ]
                        ],
                        "temperature" => 0,
                        "max_tokens" => 2048
                    ])->body(), true);

            Log::info('ChatController Response: ', (array) $response);

            // Check if 'choices' key exists before accessing it
            if (isset($response['choices']) && count($response['choices']) > 0) {
                return response()->json($response['choices'][0]['message']['content']);
            } else {
                return "Chat GPT Limit Reached. The monthly quota has been reached.";
            }
            //return $response['choices'][0]['message']['content'];
        } catch (Throwable $e) {
            Log::error('ChatController Error2: ' . $e->getMessage());
            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
        }
    }
}
