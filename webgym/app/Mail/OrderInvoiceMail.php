<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; 

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Xác nhận đơn hàng #' . $this->data['order_code'])
                    ->view('emails.order_confirmation')
                    ->with(['data' => $this->data]);
    }
}