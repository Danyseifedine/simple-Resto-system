<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekController extends Controller
{
    /**
     * Display the DeepSeek interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('web.deepseek');
    }

    /**
     * Send a request to the OpenRouter API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRequest(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $apiKey = env('DEEP_SEEK_API_KEY');

        if (empty($apiKey)) {
            return response()->json([
                'error' => 'API key is not configured',
            ], 500);
        }

        try {
            // Get all menu items to provide to the AI
            $menuItems = Menu::with('category')->get();
            $menuData = $menuItems->map(function ($item) {
                return [
                    'name' => $item->name,
                    'description' => $item->description,
                    'category' => $item->category ? $item->category->name : 'Uncategorized',
                    'price' => $item->price
                ];
            });

            // Enhance the prompt with menu data
            $enhancedPrompt = $request->prompt . "\n\nHere is our menu data to use for recommendations:\n" .
                json_encode($menuData, JSON_PRETTY_PRINT);

            // OpenRouter API endpoint
            $endpoint = 'https://openrouter.ai/api/v1/chat/completions';

            // Prepare the request payload with the enhanced prompt
            $payload = [
                'model' => 'openai/gpt-3.5-turbo',  // Using a reliable model
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $enhancedPrompt,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ];

            // Make the API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => 'https://restaurant-app.com',  // Use a fixed value
                'X-Title' => 'Restaurant App',  // Use a fixed value
                'Content-Type' => 'application/json',
            ])->post($endpoint, $payload);

            if ($response->successful()) {
                // Format the response to match what the frontend expects
                $responseData = $response->json();

                // Check if we have the expected structure
                if (isset($responseData['choices']) && !empty($responseData['choices'])) {
                    return response()->json($responseData);
                } else {
                    // If the structure is different, reformat it to match what the frontend expects
                    $formattedResponse = [
                        'choices' => [
                            [
                                'message' => [
                                    'content' => $responseData['choices'][0]['message']['content'] ??
                                        ($responseData['message'] ?? 'No response content available'),
                                    'role' => 'assistant'
                                ],
                                'index' => 0,
                            ]
                        ]
                    ];

                    return response()->json($formattedResponse);
                }
            } else {
                // Handle error response
                $errorDetails = $response->json();
                $errorMessage = isset($errorDetails['error']['message'])
                    ? $errorDetails['error']['message']
                    : 'Unknown error';

                Log::error('API error', [
                    'status' => $response->status(),
                    'error_message' => $errorMessage,
                    'error_details' => $errorDetails,
                ]);

                return response()->json([
                    'error' => 'API request failed: ' . $response->status(),
                    'message' => $errorMessage,
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception when connecting to API', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to connect to API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
