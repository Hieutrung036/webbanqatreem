<?php

namespace App\Exports;

use App\Models\HoaDon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HoaDonExport implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return HoaDon::with('khachhang', 'chitiethoadon.chitietsanpham.sanpham', 'trangthaidonhang') // Liên kết với các bảng
        ->whereYear('ngaydathang', $this->year)
            ->whereMonth('ngaydathang', $this->month)
            ->whereHas('trangthaidonhang', function ($query) {
                // Kiểm tra tên trạng thái là 'Mua hàng thành công' hoặc 'Giao hàng thành công'
                $query->whereIn('ten', ['Mua hàng thành công', 'Giao hàng thành công']);
            })
            ->get()
            ->map(function ($hoadon) {
                // Lấy thông tin người dùng từ bảng KhachHang
                $nguoidung = $hoadon->khachhang ? $hoadon->khachhang->ten : 'Không rõ';
            $phuongthucthanhtoan = $hoadon->phuongthucthanhtoan ? $hoadon->phuongthucthanhtoan->ten : 'Không rõ';

                // Khởi tạo các mảng để lưu thông tin sản phẩm và số lượng
                $sanpham = [];
                $soluong = [];

                // Duyệt qua tất cả các chi tiết hóa đơn
                foreach ($hoadon->chitiethoadon as $chitiethoadon) {
                    // Kiểm tra nếu có sản phẩm, lấy tên sản phẩm và số lượng
                    $sanpham[] = $chitiethoadon->chitietsanpham->first()->sanpham->ten ?? 'Không có sản phẩm'; // Sử dụng first() để lấy sản phẩm đầu tiên
                    $soluong[] = $chitiethoadon->soluong ?? 0;
                }

                // Trả về mảng dữ liệu
                return [
                    'idhd' => $hoadon->idhd,
                    'nguoidung' => $nguoidung,
                    'tongtien' => $hoadon->tongtien,
                    'ngaydathang' => $hoadon->ngaydathang
                        ? \Carbon\Carbon::parse($hoadon->ngaydathang)->format('d-m-Y')
                        : 'Không rõ',
                    'sanpham' => implode(', ', $sanpham), // Gộp tất cả sản phẩm
                    'soluong' => implode(', ', $soluong), // Gộp tất cả số lượng
                'phuongthucthanhtoan' => $phuongthucthanhtoan, // Gộp tất cả số lượng

                ];
            });
    }








    public function headings(): array
    {
        return ['ID Hóa Đơn', 'Người Dùng', 'Tổng Tiền', 'Ngày Đặt Hàng', 'Sản Phẩm', 'Số Lượng','Phương Thức Thanh Toán'];
    }
}
