<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\HoaDon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThongBaoDonHangNotLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hoadon;
    public $chitiethoadon;

    public function __construct($hoadon, $chitiethoadon)
    {
        $this->hoadon = $hoadon;
        $this->chitiethoadon = $chitiethoadon;
    }

    public function build()
    {
        return $this->from('sale@NIZI.com', 'NIZI Sales')
            ->subject('[NIZI Shop] - Thông báo đơn hàng')
            ->view('client.emailThongBaoDonHangnotlogin');
    }
}
