<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Client\Response;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['reply' => 'Xin lỗi, mình không nhận được tin nhắn nào 😅'], 400);
        }

        // Prompt hệ thống để giữ câu trả lời ngắn gọn, chuyên về GYM
        // Đọc file prompt ngoài

        try {
            $systemPrompt = file_get_contents(resource_path('prompts/gym_info.txt'));
            $apiKey = env('GEMINI_API_KEY');

            // Thêm kiểm tra API Key
            if (!$apiKey) {
                Log::error('GEMINI_API_KEY is not set in .env file.');
                return response()->json(['reply' => 'Lỗi cấu hình: API Key chưa được thiết lập. 😔']);
            }

            // Thử gọi Model chính (2.5-flash)
            $modelChinh = 'gemini-2.5-flash';
            $response = $this->callGeminiApi($modelChinh, $systemPrompt, $message, $apiKey); // GỌI HÀM MỚI

            // Kiểm tra nếu Model chính bị 503 (Quá tải)
            if ($response->failed() && ($response->status() === 503 || $response->status() === 500)) {
                
                // Ghi log lại
                Log::warning("Model chính ($modelChinh) bị quá tải (503). Tự động chuyển sang model dự phòng.");

                // Thử gọi Model dự phòng (1.5-flash)
                $modelDuPhong = 'gemini-2.5-pro';
                $response = $this->callGeminiApi($modelDuPhong, $systemPrompt, $message, $apiKey); // GỌI HÀM MỚI LẦN 2
            }

            // Xử lý kết quả
            if ($response->failed()) {
                $status = $response->status();
                $body = $response->body();
                Log::error('Gemini API Error (Final)', ['status' => $status, 'response' => $body]);

                // Lỗi 503 (cả 2 model đều quá tải)
                if ($status === 503 || $status === 500) {
                    return response()->json(['reply' => 'Xin lỗi, cả 2 model AI đều đang bị quá tải. Bạn thử lại sau nhé!']);
                }
                // Lỗi 403 (Sai key)
                if ($status === 403 || $status === 401) {
                    return response()->json(['reply' => 'Lỗi API Key, vui lòng kiểm tra lại cấu hình.']);
                }
                // Lỗi chung
                return response()->json(['reply' => 'Xin lỗi, có lỗi xảy ra khi kết nối đến máy chủ.']);
            }

            // Thành công 
            $data = $response->json();
            $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, mình chưa rõ câu hỏi.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Mình đang gặp sự cố kỹ thuật, bạn thử lại sau nhé!']);
        }
    }

    private function callGeminiApi(string $model, string $systemPrompt, string $message, string $apiKey): Response
    {
        return Http::withHeaders([
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
                'maxOutputTokens' => 1000,
            ]
        ]);
    }
}