<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\GymDataHelper;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    private $availableModels = [
        'gemini-2.5-flash-lite',
        'gemini-2.5-flash',
        'gemini-3-flash',
    ];

    public function chat(Request $request)
    {
        $message = trim($request->input('message'));
        if (!$message) {
            return response()->json(['reply' => 'Bạn gửi tin nhắn trống rồi! 😅'], 400);
        }

        $userId = Auth::check() ? Auth::id() : null;

        try {
            $basePrompt = file_get_contents(resource_path('prompts/gym_info.txt'));
            $dynamicData = GymDataHelper::getRelevantData($message, $userId);
            $systemPrompt = $basePrompt . ($dynamicData ? "\n\n" . $dynamicData : '');

            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) {
                Log::error('GEMINI_API_KEY not set');
                return response()->json(['reply' => 'Lỗi cấu hình: API Key chưa được thiết lập. 😔']);
            }

            // 1. Lấy lịch sử hội thoại từ session
            $history = $request->session()->get('chat_history', []);

            // 2. Tạo contents đầy đủ: system + history + message mới
            $contents = [
                ['role' => 'model', 'parts' => [['text' => $systemPrompt]]], // system prompt
            ];

            // Thêm history cũ
            foreach ($history as $item) {
                $contents[] = $item;
            }

            // Thêm message mới của user
            $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

            $reply = null;
            $usedModel = null;

            foreach ($this->availableModels as $model) {
                $response = Http::retry(3, 2000)->withHeaders(['Content-Type' => 'application/json'])
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                        'contents' => $contents,
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 500,
                        ]
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Mình chưa hiểu lắm...';
                    $usedModel = $model;
                    break;
                }

                Log::warning("Gemini failed with {$model}", ['status' => $response->status()]);
            }

            if (!$reply) {
                return response()->json(['reply' => 'Mình đang bị giới hạn, thử lại sau 1 phút nhé! 😴']);
            }

            // 3. Thêm reply của bot vào history
            $history[] = ['role' => 'model', 'parts' => [['text' => $reply]]];

            // Giới hạn history 20 tin nhắn để tránh quá dài
            if (count($history) > 20) {
                array_shift($history);
            }

            // 4. Lưu lại history vào session
            $request->session()->put('chat_history', $history);

            return response()->json(['reply' => trim($reply)]);

        } catch (\Exception $e) {
            Log::error('Chatbot error', ['message' => $e->getMessage()]);
            return response()->json(['reply' => 'Mình đang gặp sự cố kỹ thuật, thử lại sau nhé!']);
        }
    }

}
