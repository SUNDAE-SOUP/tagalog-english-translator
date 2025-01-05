<?php

namespace App\Http\Controllers;

use App\Models\GeminiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GeminiAPI\Client;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;

class GeminiController extends Controller
{
    //
    public function index(Request $request)
    {
        
        $question = $request->input('prompt');
        Log::info('Gemini Request:', ['prompt' => $question]);
        // Initialize the Gemini API client with the API key from the .env file
        $client = new Client(env('GEMINI_API_KEY'));
         //geminiPro()
        $response = $client->generativeModel(ModelName::GEMINI_1_5_FLASH)->generateContent(
            new TextPart($question),
        );
        // Extract the answer from the API response
        $answer = $response->text();
        // Return the generated answer as a JSON response
        Log::info('Gemini Response:', ['response' => $answer]);
        return response()->json(['response' => $answer]);

        // try {
        //     $apiKey = config('services.gemini.api_key');
        //     $prompt = $request->input('prompt');

        //     // Log the request for debugging
        //     Log::info('Gemini Request:', ['prompt' => $prompt]);

        //     $response = Http::withHeaders([
        //         'Content-Type' => 'application/json',
        //         // Remove any Authorization header - we'll use the API key in the URL
        //     ])->post("https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$apiKey}", [
        //         'contents' => [
        //             [
        //                 'parts' => [
        //                     [
        //                         'text' => $prompt
        //                     ]
        //                 ]
        //             ]
        //         ]
        //     ]);

        //     // Log the raw response for debugging
        //     Log::info('Gemini Raw Response:', ['response' => $response->json()]);

        //     if ($response->successful()) {
        //         $result = $response->json();
        //         return response()->json([
        //             'response' => $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response content'
        //         ]);
        //     } else {
        //         Log::error('Gemini API Error:', ['status' => $response->status(), 'body' => $response->json()]);
        //         return response()->json([
        //             'error' => 'Failed to get response from Gemini API',
        //             'details' => $response->json()
        //         ], 500);
        //     }

        // } catch (\Exception $e) {
        //     Log::error('Gemini Exception:', ['message' => $e->getMessage()]);
        //     return response()->json([
        //         'error' => 'An error occurred',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
    }
}
