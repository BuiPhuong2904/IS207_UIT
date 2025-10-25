<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['reply' => 'Xin lỗi, mình không nhận được tin nhắn nào 😅'], 400);
        }

        // Prompt hệ thống để giữ câu trả lời ngắn gọn, chuyên về GYM
        // 📄 Đọc file prompt ngoài
        $systemPrompt = file_get_contents(resource_path('prompts/gym_info.txt'));

        try {
            $model = env('GEMINI_MODEL', 'gemini-2.5-flash');
            $apiKey = env('GEMINI_API_KEY');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt],
                            ['text' => $message]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 300,
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error', ['response' => $response->body()]);
                return response()->json(['reply' => 'Xin lỗi, có lỗi xảy ra khi kết nối đến máy chủ. 😔']);
            }

            $data = $response->json();
            $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, mình chưa rõ câu hỏi.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Mình đang gặp sự cố kỹ thuật 😅']);
        }
    }
}
