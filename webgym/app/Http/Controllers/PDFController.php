// app/Http/Controllers/OrderController.php (Ví dụ)

public function completeOrder($orderId)
{
    // ... Logic xác nhận thanh toán ...
    $order = Order::findOrFail($orderId);
    $user = $order->user;

    // --- BẮT ĐẦU ĐOẠN CODE CỦA BẠN ---
    use Barryvdh\DomPDF\Facade\Pdf; 

    $pdf = Pdf::loadView('pdf.invoice', [
        'order' => $order,
        'user' => $user,
    ]);

    $pdfPath = storage_path('app/invoice_'.$order->id.'.pdf');
    $pdf->save($pdfPath);
    // --- KẾT THÚC ĐOẠN CODE CỦA BẠN ---

    // Gửi email sau khi lưu file
    // Mail::to($user->email)->send(new InvoiceMail($pdfPath, $order));

    return view('order.success');
}