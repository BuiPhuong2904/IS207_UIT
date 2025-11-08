<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if (!$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'error' => 'Không nhận được file. Vui lòng gửi dưới key "image" và định dạng File (form-data).'
            ], 400);
        }

        try {
            $file = $request->file('image');

            // ✅ Upload lên Cloudinary qua Storage disk
            $uploadedFilePath = Storage::disk('cloudinary')->putFile('uploads', $file);

            // ✅ Lấy URL bảo mật (https)
            $secureUrl = Storage::disk('cloudinary')->url($uploadedFilePath);

            return response()->json([
                'success'   => true,
                'image_url' => $secureUrl,
                'path'      => $uploadedFilePath,
            ]);
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error'   => 'Lỗi upload Cloudinary: ' . $e->getMessage(),
            ], 500);
        }
    }
}
