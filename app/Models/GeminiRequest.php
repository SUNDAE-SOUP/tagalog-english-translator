<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeminiRequest extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'prompt',
        'response',
    ];

    public function __invoke($prompt)
    {
        // Replace with your actual Gemini API credentials and endpoint
        $url = 'https://api.gemini.com/v1/your-endpoint'; 
        $apiKey = 'AIzaSyAnnZpF66HxifV8W56eo-jHmT-1_eRNfPk'; 

        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ];

        $data = [
            'prompt' => $prompt,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        // Handle potential errors (e.g., API errors, network issues)
        if ($response === false) {
            return ['success' => false, 'message' => 'API request failed'];
        }

        // Parse the API response (assuming JSON)
        $responseData = json_decode($response, true);

        // Store the response in the database
        $this->prompt = $prompt;
        $this->response = json_encode($responseData); 
        $this->save();

        return ['success' => true, 'data' => $responseData];
    }
}
