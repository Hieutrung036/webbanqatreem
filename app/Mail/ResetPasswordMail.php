<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this
        ->from('sale@NIZI.com', 'NIZI Sales') // Địa chỉ email người gửi
            ->subject('[NIZI Shop] - Đặt lại mật khẩu')
            ->view('taikhoan.email') // Đường dẫn đến view email
            ->with(['url' => $this->url]);
    }
}
