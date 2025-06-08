<?php

namespace App\Mail;

use App\Models\HoaDon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThongBaoDonHangMail1 extends Mailable
{
    use Queueable, SerializesModels;

    public $hoadon; // Thông tin đơn hàng
    public $chitiethoadon;

    public function __construct(HoaDon $hoadon, $chitiethoadon)
    {
        $this->hoadon = $hoadon;
        $this->chitiethoadon = $chitiethoadon; // Lưu chi tiết đơn hàng

    }

    public function build()
    {
        return $this->from('sale@NIZI.com', 'NIZI Sales')
            ->subject('[NIZI Shop] - Thông báo đơn hàng')
            ->view('client.emailThongBaoDonHang1');
    }
}
