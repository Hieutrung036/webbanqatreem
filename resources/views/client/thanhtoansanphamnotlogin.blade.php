@extends('client.layout.master')

@section('title', 'Thanh toán sản phẩm')


<!-- Add your site or application content here -->
@section('body')
    <!--pos page start-->
    <div class="pos_page">
        <div class="container">
            <!--pos page inner-->
            <div class="pos_page_inner">

                <!--breadcrumbs area start-->
                <div class="breadcrumbs_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb_content">
                                <ul>
                                    <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                                    <li><i class="fa fa-angle-right"></i></li>
                                    <li>Thanh toán sản phẩm</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs area end-->
                @if (session('success'))
                    <div id="success-alert" class="alert alert-success"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div id="error-popup" class="alert alert-danger"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ rtrim($error, '.') }}</li> <!-- Xóa dấu chấm ở cuối -->
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div id="error-alert" class="alert alert-danger"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        {{ session('error') }}
                    </div>
                @endif

                <!--Checkout page section-->
                <div class="Checkout_section">
                  
                    <form action="{{ route('xulythanhtoannotlogin') }}" method="POST">
                        @csrf
                        <input type="hidden" id="iddc" name="iddc" value="">

                        <div class="checkout_form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <h3>Thông tin giao hàng</h3>
                                    <div class="row">
                                        {{-- <div class="col-12 mb-20">
                                            <label for="">Bạn đã có tài khoản?</label>
                                            <a href="{{ route('dangnhap') }}?redirect={{ urlencode(url()->current()) }}"
                                                style="color: rgb(88, 88, 215); font-size:15px">Đăng nhập</a>
                                        </div> --}}
                                        
                                        

                                        <!-- Các trường nhập liệu -->
                                        <div class="col-12 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="ten" name="tennguoinhan" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Họ và tên</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 mb-10">
                                            <div class="form-group">
                                                <input type="email" id="email" name="email" class="form-control floating-input"
                                                    placeholder=" " value=""
                                                    style="font-size: 15px">
                                                <label for="email" class="floating-label">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="sdt" name="sdt" class="form-control floating-input" placeholder=" " style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Số điện thoại</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="diachi"  name="diachi" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Địa chỉ</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="phuongxa" name="phuongxa" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Phường / Xã</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="quanhuyen" name="quanhuyen" class="form-control floating-input"
                                                    placeholder=" " value=""style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Quận / Huyện</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="tinhthanhpho" name="tinhthanhpho" class="form-control floating-input"
                                                    placeholder=" " value=""style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Tỉnh / Thành
                                                    Phố</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-10">
                                            <label for="phuongThucVanChuyen">Phương thức vận chuyển</label>
                                            <select id="phuongthucvanchuyen" name="phuongthucvanchuyen"
                                                class="form-control">
                                                <option value="" disabled selected>Chọn phương thức vận chuyển
                                                </option>
                                                @foreach ($phuongthucgiaohang as $phuongthuc)
                                                    @if ($phuongthuc->ten !== 'Tại cửa hàng')
                                                        <option value="{{ $phuongthuc->idptgh }}"
                                                            data-phuongthucgiaohang="{{ $phuongthuc->phigiaohang }}">
                                                            {{ $phuongthuc->ten }} -
                                                            {{ number_format($phuongthuc->phigiaohang, 0, ',', ',') }}
                                                            VND
                                                            ({{ $phuongthuc->mota }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                </div>

                              


                                <div class="col-lg-6 col-md-6">

                                    <h3>Đơn hàng của bạn</h3>
                                    <div class="order_table table-responsive mb-30">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Tổng cộng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $giohang = session('giohang');
                                                @endphp
                                                @foreach ($giohang as $ctgh)
                                                    <tr>
                                                        <td><strong>
                                                                {{ isset($ctgh['sanpham']->sanpham) ? $ctgh['sanpham']->sanpham->ten : 'Sản phẩm không tồn tại' }}

                                                            </strong>
                                                            <p>
                                                                Màu:
                                                                {{ isset($ctgh['sanpham']->mau) ? $ctgh['sanpham']->mau->ten : 'Không có' }}
                                                                , Kích thước:
                                                                {{ isset($ctgh['sanpham']->kichthuoc) ? $ctgh['sanpham']->kichthuoc->ten : 'Không có' }}
                                                            </p>
                                                        </td>
                                                        <td>{{ $ctgh['soluong'] }}</td>
                                                        <td>
                                                            @if (isset($ctgh['sanpham']))
                                                                {{-- Lấy đối tượng sản phẩm từ chi tiết sản phẩm --}}
                                                                @php
                                                                    $sanpham = $ctgh['sanpham']->sanpham; // Lấy đối tượng 'sanpham' liên kết với ChiTietSanPham
                                                                    $giaSanPham = $sanpham->gia; // Giá gốc của sản phẩm

                                                                    // Kiểm tra giảm giá
                                                                    if (
                                                                        $sanpham->giamgia &&
                                                                        $sanpham->giamgia->phantram > 0
                                                                    ) {
                                                                        $giaSanPham =
                                                                            $giaSanPham -
                                                                            ($giaSanPham *
                                                                                $sanpham->giamgia->phantram) /
                                                                                100;
                                                                    }

                                                                    // Tính tổng tiền cho sản phẩm (bao gồm số lượng)
                                                                    $tongTienSanPham = $giaSanPham * $ctgh['soluong'];
                                                                @endphp

                                                                <!-- Hiển thị giá gốc -->

                                                                <!-- Hiển thị tổng tiền sau khi giảm giá -->
                                                                <span class="tong-tien"
                                                                    data-tongtien="{{ $tongTienSanPham }}">{{ number_format($tongTienSanPham, 0, ',', '.') }}
                                                                    VND</span>
                                                            @else
                                                                Sản phẩm không tồn tại
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach




                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Tổng tiền</th>
                                                    <td></td>
                                                    <td>
                                                        <strong>
                                                            {{ number_format($tongTien, 0, ',', ',') }} VND
                                                        </strong>
                                                    </td>
                                                    <input type="hidden" name="tongTien" value="{{ $tongTien }}">

                                                </tr>
                                                <tr>
                                                    <th>Phí vận chuyển </th>
                                                    <td></td>
                                                    <td><strong id="phigiaohang">
                                                            _____
                                                        </strong></td>
                                                </tr>
                                                <!-- Thông tin mã voucher -->
                                                <tr>
                                                    <th>Mã voucher</th>
                                                    <td></td>
                                                    <td class="voucher">
                                                        <div class="input-group">
                                                            <input type="text" id="maVoucher" class="form-control"
                                                                placeholder="Mã giảm giá" name="voucherCode"
                                                                value="">
                                                            <div class="input-group-append">
                                                                <button class="nutxacnhan btn btn-primary"
                                                                    type="button">Xác nhận</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <!-- Thông tin tổng tiền đã giảm (sau khi mã giảm giá) -->
                                                <tr class="order_discounted_total">
                                                    <th>Tổng cộng (Sau giảm giá)</th>
                                                    <td></td>
                                                    <td><strong
                                                            id="tongTienShip">{{ number_format($tongTienShip, 0, ',', '.') }}
                                                            VND</strong></td>
                                                    <input type="hidden" name="tongTienShip"
                                                        value="{{ $tongTienShip }}"> <!-- Phí vận chuyển -->

                                                    <!-- Lưu tổng tiền -->

                                                </tr>

                                                <!-- Các phần tử JavaScript -->
                                                <script>
                                                    $(document).ready(function() {
                                                        // Khi thay đổi phương thức vận chuyển hoặc áp dụng mã giảm giá
                                                        $("select[name='phuongthucvanchuyen'], .nutxacnhan").on("change click", function() {
                                                            var voucherCode = $("#maVoucher").val(); // Lấy mã giảm giá
                                                            var phuongthucvanchuyen = $("select[name='phuongthucvanchuyen']")
                                                                .val(); // Lấy phương thức vận chuyển

                                                            $.ajax({
                                                                url: "{{ route('thanhtoansanphamnotlogin') }}",
                                                                type: "GET",
                                                                data: {
                                                                    voucherCode: voucherCode,
                                                                    phuongthucvanchuyen: phuongthucvanchuyen,
                                                                },
                                                                success: function(response) {
                                                                    if (response.tongTienShip) {
                                                                        $("#tongTienShip").html(response.tongTienShip + " VND");
                                                                    } else {
                                                                        $("#tongTienShip").html("Lỗi tính toán giá");
                                                                    }
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.error("Có lỗi xảy ra: " + error);
                                                                    $("#tongTienShip").html("Có lỗi xảy ra khi tính giá.");
                                                                },
                                                            });
                                                        });
                                                    });
                                                </script>



                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="payment_method">
                                        @foreach ($phuongthucthanhtoan as $pttt)
                                            @if ($pttt->idpttt != 1)
                                                <div class="panel-default">
                                                    <input id="idpttt-{{ $pttt->idpttt }}" name="idpttt" type="radio"
                                                        value="{{ $pttt->idpttt }}"
                                                        {{ $pttt->idpttt == 2 ? 'checked' : '' }}>
                                                    <label for="IDPTTT-{{ $pttt->idpttt }}"> {{ $pttt->ten }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="order_button">
                                            <button name="redirect" type="submit">Hoàn tất đơn hàng</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <!--Checkout page section end-->

            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <!--pos page end-->


@endsection
