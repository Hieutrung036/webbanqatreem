<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietSanPham;
use App\Models\DanhMucSanPham;
use App\Models\GioHang;
use App\Models\KichThuoc;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\MaGiamGia;
use App\Models\Mau;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class giohangController extends Controller
{
    // public function index()
    // {
    //     // Kiểm tra xem người dùng có đăng nhập không
    //     if (auth()->check()) {
    //         $idkh = auth()->user()->idkh;

    //         // Lấy các loại sản phẩm, loại tin tức, mã giảm giá
    //         $danhmucsanpham = DanhMucSanPham::all();
    //         $loaitintuc = LoaiTinTuc::all();
    //         $giamgia = MaGiamGia::all();

    //         // Lấy chi tiết giỏ hàng của người dùng
    //         $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
    //             ->whereHas('giohang', function ($query) use ($idkh) {
    //                 $query->where('idkh', $idkh);
    //             })
    //             ->get();

    //         // Tính tổng tiền và số lượng sản phẩm
    //         $tongTien = 0;
    //         $soLuongSanPham = 0;
    //         foreach ($chitietgiohang as $ctgh) {
    //             foreach ($ctgh->chitietsanpham as $ctsp) {
    //                 $giaSanPham = $ctsp->sanpham->gia;

    //                 // Kiểm tra giảm giá
    //                 if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
    //                     $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
    //                 }

    //                 // Cộng dồn tổng tiền và số lượng sản phẩm
    //                 $tongTien += $giaSanPham * $ctgh->soluong;
    //                 $soLuongSanPham += $ctgh->soluong;
    //             }
    //         }

    //         return view('client.giohang', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'giamgia', 'soLuongSanPham'));
    //     } else {
    //         return redirect()->route('dangnhap')->with('message', 'Vui lòng đăng nhập để xem giỏ hàng.');
    //     }
    // }
    public function index()
    {
        // Lấy các loại sản phẩm, loại tin tức, mã giảm giá
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $giamgia = MaGiamGia::all();
        $tongTien = 0;
        $soLuongSanPham = 0;

        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy chi tiết giỏ hàng từ cơ sở dữ liệu
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham', 'chitietsanpham.mau', 'chitietsanpham.kichthuoc')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính toán tổng tiền và số lượng sản phẩm
            foreach ($chitietgiohang as $ctgh) {
                
                // Kiểm tra xem có chi tiết sản phẩm hay không
                if ($ctgh->chitietsanpham) {
                    // Nếu có, lấy chi tiết sản phẩm đầu tiên
                    $chitietsanpham = $ctgh->chitietsanpham->first(); // Giả sử chitietsanpham là collection

                    if ($chitietsanpham && $chitietsanpham->sanpham) {
                        // Lấy giá sản phẩm
                        $giaSanPham = $chitietsanpham->sanpham->gia ?? 0;

                        // Kiểm tra giảm giá
                        if ($chitietsanpham->sanpham->giamgia && $chitietsanpham->sanpham->giamgia->phantram > 0) {
                            $giaSanPham -= ($giaSanPham * $chitietsanpham->sanpham->giamgia->phantram) / 100;
                        }
                        
                        // Cộng tổng tiền và số lượng
                        $tongTien += $giaSanPham * $ctgh->soluong;
                        $soLuongSanPham += $ctgh->soluong;
                    }
                }
            }
            // Trả về view `giohang` nếu người dùng đã đăng nhập
            return view('client.giohang', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'giamgia', 'soLuongSanPham'));
        } else {
            // Lấy chi tiết giỏ hàng từ session
            $chitietgiohang = session('giohang', []);

            $tongTien = 0; // Khởi tạo tổng tiền
            $soLuongSanPham = 0; // Khởi tạo số lượng sản phẩm

            foreach ($chitietgiohang as $item) {
                if (isset($item['sanpham']) && $item['sanpham'] instanceof \App\Models\ChiTietSanPham) {
                    $sanpham = $item['sanpham']; // Lấy đối tượng ChiTietSanPham

                    // Lấy giá sản phẩm
                    $giaSanPham = $sanpham->sanpham->gia ?? 0;

                    // Kiểm tra và áp dụng giảm giá nếu có
                    if (isset($sanpham->sanpham->giamgia) && $sanpham->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $sanpham->sanpham->giamgia->phantram) / 100;
                    }
                    
                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $item['soluong'];
                    $soLuongSanPham += $item['soluong'];
                }
            }

            // Trả về view `giohang1` với các giá trị đã tính toán
            return view('client.giohang1', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'giamgia', 'soLuongSanPham'));
        }
    }

    public function store(Request $request)
    {
        $mau = $request->input('mau');
        $kichthuoc = $request->input('kichthuoc');
        $IDSPs = $request->input('idsp');
        $quantity = $request->input('quantity', 1);

        $IDmau = Mau::where('idm', $mau)->first();
        $IDsize = KichThuoc::where('idkt', $kichthuoc)->first();

        if (!$IDmau || !$IDsize) {
            return redirect()->back()->withErrors(['error' => 'Màu hoặc kích thước không hợp lệ']);
        }

        $IDMs = $IDmau->idm;
        $IDKTs = $IDsize->idkt;

        $danhsachchitiet = ChiTietSanPham::where('idsp', $IDSPs)->get();
        $chitietsanpham = $danhsachchitiet->where('idm', $IDMs)->where('idkt', $IDKTs)->first();

        if (!$chitietsanpham) {
            return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại với màu và kích thước này']);
        }

        $productId = $chitietsanpham->idctsp;

        if ($chitietsanpham->soluong < $quantity) {
            return redirect()->back()->withErrors(['error' => 'Số lượng sản phẩm không đủ']);
        }

        if (auth()->check()) {
            $userId = auth()->user()->idkh;

            $cart = GioHang::where('idkh', $userId)->first();

            if (!$cart) {
                $cart = new GioHang();
                $cart->idkh = $userId;
                $cart->save();
            }

            $cartDetail = ChiTietGioHang::where('idgh', $cart->idgh)
                ->where('idctsp', $productId)
                ->first();

            $newQuantity = $cartDetail ? $cartDetail->soluong + $quantity : $quantity;

            if ($newQuantity > $chitietsanpham->soluong) {
                return redirect()->back()->withErrors(['error' => 'Số lượng sản phẩm vượt quá tồn kho']);
            }

            if ($cartDetail) {
                $cartDetail->soluong = $newQuantity;
                $cartDetail->save();
            } else {
                $cartDetail = new ChiTietGioHang();
                $cartDetail->idgh = $cart->idgh;
                $cartDetail->idctsp = $productId;
                $cartDetail->soluong = $quantity;
                $cartDetail->save();
            }

            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật.');
        } else {
            $cart = session('giohang', []);

            $exists = false;
            foreach ($cart as &$item) {
                if ($item['idctsp'] == $productId) {
                    $newQuantity = $item['soluong'] + $quantity;

                    if ($newQuantity > $chitietsanpham->soluong) {
                        return redirect()->back()->withErrors(['error' => 'Số lượng sản phẩm vượt quá tồn kho']);
                    }

                    $item['soluong'] = $newQuantity;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                if ($quantity > $chitietsanpham->soluong) {
                    return redirect()->back()->withErrors(['error' => 'Số lượng sản phẩm vượt quá tồn kho']);
                }

                $cart[] = [
                    'idctsp' => $productId,
                    'soluong' => $quantity,
                    'sanpham' => $chitietsanpham
                ];
            }

            session(['giohang' => $cart]);

            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật.');
        }
    }



    public function destroy($idctsp)
    {
        if (auth()->check()) {
            $chiTietGioHang = ChiTietGioHang::find($idctsp);

            if ($chiTietGioHang) {
                $chiTietGioHang->delete();
                return back()->with('success', 'Xóa thành công');
            } else {
                return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
            }
        } else {
            $giohang = session('giohang', []);
            foreach ($giohang as $key => $item) {
                if (isset($item['idctsp']) && $item['idctsp'] == $idctsp) {
                    unset($giohang[$key]);

                    session(['giohang' => array_values($giohang)]);

                    return back()->with('success', 'Xóa sản phẩm thành công');
                }
            }

            return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
        }
    }



    public function update(Request $request)
    {
        if ($request->ajax()) {
            $idctgh = $request->input('idctgh');
            $soluong = $request->input('soluong');

            if (!$idctgh || !$soluong || !is_numeric($soluong) || $soluong < 1) {
                return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
            }

            $chiTietGioHang = ChiTietGioHang::find($idctgh);

            if ($chiTietGioHang) {
                $chitietsanpham = ChiTietSanPham::find($chiTietGioHang->idctsp);

                if (!$chitietsanpham) {
                    return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin sản phẩm'], 404);
                }

                if ($soluong > $chitietsanpham->soluong) {
                    return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho'], 400);
                }

                $chiTietGioHang->update(['soluong' => min(100, $soluong)]);

                return response()->json(['success' => true, 'message' => 'Cập nhật thành công', 'soluong' => $chiTietGioHang->soluong], 200);
            }

            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'], 404);
        }

        return response()->json(['success' => false, 'message' => 'Yêu cầu không hợp lệ'], 400);
    }






    public function updateSeassion(Request $request)
    {
        $idctsp = $request->input('idctsp');
        $soluong = $request->input('soluong');

        if ($soluong < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng không hợp lệ.'
            ]);
        }

        $giohang = session('giohang', []);

        if (empty($giohang)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Giỏ hàng trống.'
            ]);
        }

        foreach ($giohang as $key => $item) {
            if (isset($item['idctsp']) && $item['idctsp'] == $idctsp) {
                $giohang[$key]['soluong'] = $soluong;
                $sanpham = ChiTietSanPham::find($idctsp);
                if ($sanpham) {
                    $giaSanPham = $sanpham->sanpham->gia;

                    if ($sanpham->sanpham->giamgia && $sanpham->sanpham->giamgia->phantram > 0) {
                        $giaSanPham = $giaSanPham - ($giaSanPham * $sanpham->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính lại tổng tiền cho sản phẩm
                    $tongTien = $giaSanPham * $soluong;
                    // Cập nhật lại giỏ hàng trong session
                    session(['giohang' => $giohang]);

                    // Trả lại phản hồi JSON với thông tin mới
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Cập nhật số lượng thành công.',
                        'tongtien' => number_format($tongTien, 0, ',', '.'), // Trả về tổng tiền mới

                        'soluong' => $soluong
                    ]);
                }
            }
        }
        // Nếu không tìm thấy sản phẩm trong giỏ hàng
        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'
        ]);
    }
















    public function deleteSelected(Request $request)
    {
        $selectedItems = $request->input('selected_items'); // Mảng các ID sản phẩm đã chọn

        // Kiểm tra nếu có ID nào được gửi đến
        if (count($selectedItems) > 0) {
            // Xóa các chi tiết giỏ hàng đã chọn
            ChiTietGioHang::whereIn('idctgh', $selectedItems)->delete();

            return back()->with('success', 'Xóa thành công');
        } else {
            return back()->with('success', 'Không có sản phẩm nào được chọn');
        }
    }
}
