<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Ở đây cho phép mọi người (public).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules để validate khi gửi yêu cầu quên mật khẩu.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email'
        ];
    }

    /**
     * Messages tuỳ chỉnh (tiếng Việt).
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
        ];
    }
}
