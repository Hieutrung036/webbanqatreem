<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HoaDonExport;
use App\Exports\XuatExcel;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\HoaDon;
use App\Models\LoaiSanPham;
use App\Models\KhachHang;
use App\Models\SanPham;
use App\Models\TrangThaiDonHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class thongkeController extends Controller
{



    // public function thongkenam(Request $request)
    // {

    //     if (Auth::check()) {
    //         if (Auth::user()->Quyen == 1) {
    //             $nguoidungs = NguoiDung::all();
    //             $donhangs = DonHang::all();
    //             $demdonhangthanhcong = 0;
    //             foreach ($donhangs as $donhang) {
    //                 if ($donhang->IDTTDH == 6) {
    //                     $demdonhangthanhcong++;
    //                 }
    //             }
    //             $dennguoidung = 0;
    //             $nguoidungDaDem[] = 0;
    //             foreach ($nguoidungs as $nguoidung) {
    //                 foreach ($donhangs as $donhang) {
    //                     if ($donhang->IDND == $nguoidung->IDND) {
    //                         if (!in_array($donhang->IDND, $nguoidungDaDem)) {
    //                             $nguoidungDaDem[] = $donhang->IDND;
    //                             $dennguoidung++;
    //                         }
    //                     }
    //                 }
    //             }
    //             $nam = $request->input('nam', Carbon::now()->year);
    //             $sanphams = SanPham::all();
    //             $doanhThu = DonHang::selectRaw('MONTH(Ngaydathang) as thang, YEAR(Ngaydathang) as nam, SUM(Tongtien) as tong_doanhthu')
    //                 ->whereYear('Ngaydathang', $nam)
    //                 ->groupBy('thang', 'nam')
    //                 ->orderBy('thang', 'asc')
    //                 ->get();
    //             $batdau = null;
    //             $ketthuc = null;

    //             $trangthais = TrangThaiDonHang::all();
    //             $soLuongTheoTrangThai = [];
    //             foreach ($trangthais as $trangThai) {
    //                 $soLuongTheoTrangThai[$trangThai->IDTTDH] = $donhangs->where('IDTTDH', $trangThai->IDTTDH)->count();
    //             }
    //             $loaisanphams = LoaiSanPham::all();
    //             $soLuongTheoLoaiSP = [];
    //             foreach ($loaisanphams as $loaisanpham) {
    //                 // Đếm số lượng đơn hàng với trạng thái hiện tại
    //                 $soLuongTheoLoaiSP[$loaisanpham->IDLSP] = SanPham::where('IDLSP', $loaisanpham->IDLSP)->count();
    //             }
    //             $months = 0;
    //             $revenueByMonth = [];
    //             $tongnam = 0;
    //             foreach (range(1, 12) as $month) {
    //                 $doanhThuThang = $doanhThu->firstWhere('thang', $month);
    //                 $revenueByMonth[$month] = $doanhThuThang ? $doanhThuThang->tong_doanhthu : 0;
    //                 $doanhThuThangValue = $doanhThuThang ? $doanhThuThang->tong_doanhthu : 0;
    //                 $tongnam += $doanhThuThangValue;
    //             }
    //             return view('admin.thongke', compact('tongnam', 'demdonhangthanhcong', 'dennguoidung', 'nguoidungs', 'months', 'revenueByMonth', 'batdau', 'doanhThu', 'ketthuc', 'nam', 'donhangs', 'sanphams', 'soLuongTheoLoaiSP', 'soLuongTheoTrangThai', 'trangthais', 'loaisanphams'));
    //         } else {
    //             return view('admin.khongcoquyen');
    //         }
    //     } else {
    //         return view('account.dangnhap');
    //     }
    // }

    public function index(Request $request)
    {
        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::guard('admin')->check()) {
            // Lấy thông tin admin đang đăng nhập
            $admin = Auth::guard('admin')->user();

            // Nếu admin đăng nhập thành công
            if ($admin) {
                // Lấy danh sách khách hàng và đơn hàng
                $khachhang = KhachHang::all();
                $donhangs = HoaDon::all();

                // Đếm số lượng đơn hàng thành công
                $demdonhangthanhcong = 0;
                $demdonhangdaban = 0;  // Đảm bảo biến này được khai báo đúng

                foreach ($donhangs as $donhang) {
                    // Kiểm tra nếu trạng thái là "Giao hàng thành công"
                    if ($donhang->trangthaidonhang->ten == 'Giao hàng thành công') {
                        $demdonhangthanhcong++;
                    }
                    // Kiểm tra nếu trạng thái là "Đã xác nhận" hoặc phương thức thanh toán là "Tại cửa hàng"
                    elseif ($donhang->phuongthucthanhtoan->ten == 'Tại cửa hàng') {
                        $demdonhangdaban++;  // Đảm bảo dùng đúng tên biến
                    }
                }

                // Đếm số lượng người dùng đã thực hiện đơn hàng
                $demkhachhang = 0;
                $nguoidungDaDem = [];
                foreach ($khachhang as $kh) {
                    foreach ($donhangs as $donhang) {
                        // Kiểm tra xem đơn hàng có thuộc khách hàng này không
                        if ($donhang->idkh == $kh->idkh) {
                            // Kiểm tra nếu khách hàng chưa được đếm
                            if (!in_array($kh->idkh, $nguoidungDaDem)) {
                                // Thêm idkh của khách hàng vào mảng nguoidungDaDem
                                $nguoidungDaDem[] = $kh->idkh;
                                $demkhachhang++; // Tăng số lượng người dùng đã mua hàng
                            }
                        }
                    }
                }


                // Lọc theo năm được chọn
                $nam = $request->input('nam', Carbon::now()->year);

                // Lấy thông tin các sản phẩm và trạng thái đơn hàng
                $sanphams = SanPham::all();
                $trangthais = TrangThaiDonHang::all();

                // Đếm số lượng đơn hàng theo trạng thái
                $soLuongTheoTrangThai = [];
                foreach ($trangthais as $trangThai) {
                    $soLuongTheoTrangThai[$trangThai->idttdh] = HoaDon::where('idttdh', $trangThai->idttdh)->count();
                }

                // Đếm số lượng sản phẩm theo loại
                $loaisanphams = LoaiSanPham::withCount('sanpham')->get();
                $soLuongTheoLoaiSP = $loaisanphams->pluck('sanpham_count', 'idlsp')->toArray();

                foreach ($loaisanphams as $loaisanpham) {
                    $soLuongTheoLoaiSP[$loaisanpham->idlsp] = SanPham::where('idlsp', $loaisanpham->idlsp)->count();
                }

                // Doanh thu theo tháng trong năm
                $doanhThu = HoaDon::selectRaw('MONTH(ngaydathang) as thang, YEAR(ngaydathang) as nam, SUM(tongtien) as tong_doanhthu')
                    ->whereYear('ngaydathang', $nam)
                    ->groupBy('thang', 'nam')
                    ->orderBy('thang', 'asc')
                    ->get();

                // Doanh thu hàng tháng
                $monthlyRevenue = HoaDon::selectRaw('MONTH(ngaydathang) as month, YEAR(ngaydathang) as year, SUM(tongtien) as revenue')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();

                // Tổng doanh thu theo tháng
                $revenueByMonth = [];
                $tongnam = 0;
                foreach (range(1, 12) as $month) {
                    $doanhThuThang = $doanhThu->firstWhere('thang', $month);
                    $revenueByMonth[$month] = $doanhThuThang ? $doanhThuThang->tong_doanhthu : 0;
                    $tongnam += $revenueByMonth[$month];
                }

                // Tạo mảng các tháng
                $months = range(1, 12);

                // Trả về view với dữ liệu
                return view('admin.thongke', compact(
                    'tongnam',
                    'demdonhangthanhcong',
                    'demkhachhang',
                    'revenueByMonth',
                    'nam',
                    'donhangs',
                    'doanhThu',
                    'sanphams',
                    'monthlyRevenue',
                    'soLuongTheoLoaiSP',
                    'soLuongTheoTrangThai',
                    'trangthais',
                    'loaisanphams',
                    'khachhang',
                    'demdonhangdaban',
                    'doanhThu',
                    'revenueByMonth',
                    'months'   // Truyền tháng vào view
                ));
            } else {
                return view('admin.dangnhap');
            }
        } else {
            return view('admin.dangnhap');
        }
    }


    public function showViewThang(Request $request)
    {
        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::guard('admin')->check()) {
            // Lấy thông tin admin đang đăng nhập
            $admin = Auth::guard('admin')->user();

            // Nếu admin đăng nhập thành công
            if ($admin) {
                // Lấy danh sách khách hàng và đơn hàng
                $nam = $request->input('nam', Carbon::now()->year);
                $khachhang = KhachHang::all();
                $donhangs = HoaDon::all();
                $sanphams = SanPham::all();
                $doanhThu = HoaDon::selectRaw('MONTH(ngaydathang) as thang, YEAR(ngaydathang) as nam, SUM(tongtien) as tong_doanhthu')
                    ->whereYear('ngaydathang', $nam)
                    ->groupBy('thang', 'nam')
                    ->orderBy('thang', 'asc')
                    ->get();
                $batdau = $request->input('batdau');
                $ketthuc = $request->input('ketthuc');
                $donhangs = HoaDon::whereBetween('Ngaydathang', [$batdau, $ketthuc])->get();

                // Đếm số lượng đơn hàng thành công
                $demdonhangthanhcong = 0;
                $demdonhangdaban = 0;  // Đảm bảo biến này được khai báo đúng

                foreach ($donhangs as $donhang) {
                    // Kiểm tra nếu trạng thái là "Giao hàng thành công"
                    if ($donhang->trangthaidonhang->ten == 'Giao hàng thành công') {
                        $demdonhangthanhcong++;
                    }
                    // Kiểm tra nếu trạng thái là "Đã xác nhận" hoặc phương thức thanh toán là "Tại cửa hàng"
                    elseif ($donhang->phuongthucthanhtoan->ten == 'Tại cửa hàng') {
                        $demdonhangdaban++;  // Đảm bảo dùng đúng tên biến
                    }
                }

                // Đếm số lượng người dùng đã thực hiện đơn hàng
                $demkhachhang = 0;
                $nguoidungDaDem = [];
                foreach ($khachhang as $kh) {
                    foreach ($donhangs as $donhang) {
                        // Kiểm tra xem đơn hàng có thuộc khách hàng này không
                        if ($donhang->idkh == $kh->idkh) {
                            // Kiểm tra nếu khách hàng chưa được đếm
                            if (!in_array($kh->idkh, $nguoidungDaDem)) {
                                // Thêm idkh của khách hàng vào mảng nguoidungDaDem
                                $nguoidungDaDem[] = $kh->idkh;
                                $demkhachhang++; // Tăng số lượng người dùng đã mua hàng
                            }
                        }
                    }
                }


                // Lọc theo năm được chọn

                // Lấy thông tin các sản phẩm và trạng thái đơn hàng
                $trangthais = TrangThaiDonHang::all();

                // Đếm số lượng đơn hàng theo trạng thái
                $soLuongTheoTrangThai = [];
                foreach ($trangthais as $trangThai) {
                    $soLuongTheoTrangThai[$trangThai->idttdh] = HoaDon::where('idttdh', $trangThai->idttdh)->count();
                }

                // Đếm số lượng sản phẩm theo loại
                $loaisanphams = LoaiSanPham::withCount('sanpham')->get();
                $soLuongTheoLoaiSP = $loaisanphams->pluck('sanpham_count', 'idlsp')->toArray();

                foreach ($loaisanphams as $loaisanpham) {
                    $soLuongTheoLoaiSP[$loaisanpham->idlsp] = SanPham::where('idlsp', $loaisanpham->idlsp)->count();
                }

                // Doanh thu theo tháng trong năm


                // Doanh thu hàng tháng
                $monthlyRevenue = HoaDon::selectRaw('MONTH(ngaydathang) as month, YEAR(ngaydathang) as year, SUM(tongtien) as revenue')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'asc')
                    ->orderBy('month', 'asc')
                    ->get();

                // Tổng doanh thu theo tháng
                $revenueByMonth = [];
                $tongnam = 0;
                foreach (range(1, 12) as $month) {
                    $doanhThuThang = $doanhThu->firstWhere('thang', $month);
                    $revenueByMonth[$month] = $doanhThuThang ? $doanhThuThang->tong_doanhthu : 0;
                    $tongnam += $revenueByMonth[$month];
                }

                // Tạo mảng các tháng
                $months = range(1, 12);

                // Trả về view với dữ liệu
                return view('admin.thongke', compact(
                    'tongnam',
                    'demdonhangthanhcong',
                    'demkhachhang',
                    'revenueByMonth',
                    'nam',
                    'donhangs',
                    'doanhThu',
                    'sanphams',
                    'monthlyRevenue',
                    'soLuongTheoLoaiSP',
                    'soLuongTheoTrangThai',
                    'trangthais',
                    'loaisanphams',
                    'khachhang',
                    'demdonhangdaban',
                    'doanhThu',
                    'revenueByMonth',
                    'months'   // Truyền tháng vào view
                ));
            } else {
                return view('admin.dangnhap');
            }
        } else {
            return view('admin.dangnhap');
        }
    }

    public function exportExcel(Request $request)
    {
        $monthYear = $request->input('month_year'); // Lấy dữ liệu từ form

        // Kiểm tra dữ liệu nhập
        if (!$monthYear) {
            return redirect()->back()->with('error', 'Vui lòng nhập tháng/năm!');
        }

        $dateParts = explode('/', $monthYear); // Tách thành tháng và năm
        if (count($dateParts) != 2 || !is_numeric($dateParts[0]) || !is_numeric($dateParts[1])) {
            return redirect()->back()->with('error', 'Định dạng MM/YYYY không hợp lệ!');
        }

        $month = $dateParts[0];
        $year = $dateParts[1];

        // Thay thế "/" trong tên file bằng "-"
        $fileName = 'doanhthu' . str_replace('/', '-', $monthYear) . '.xlsx';

        return Excel::download(new HoaDonExport($month, $year), $fileName);
    }
}
