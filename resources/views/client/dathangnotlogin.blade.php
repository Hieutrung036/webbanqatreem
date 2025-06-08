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
                  
                    <form action="{{ route('xulydathangnotlogin') }}" method="POST">
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


                                                <tr>
                                                    <td>
                                                        <strong>{{ $productName }}</strong>
                                                        <p>Màu: {{ $colorName }}, Kích thước: {{ $sizeName }}</p>
                                                        <input type="hidden" name="idsp"
                                                            value="{{ $productId }}">
                                                        <input type="hidden" name="colorId"
                                                            value="{{ $colorId }}">
                                                        <input type="hidden" name="sizeId"
                                                            value="{{ $sizeId }}">


                                                    </td>


                                                    <td>{{ $quantity }}</td>
                                                    <input type="hidden" name="quantity" id="quantityInput"
                                                        value="{{ $quantity }}">
                                                    <td>

                                                        {{ number_format($productPrice * $quantity, 0, ',', ',') }} VND

                                                    </td>

                                                </tr>


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Tổng tiền</th>
                                                    <td></td>
                                                    <td>
                                                        <strong>

                                                            {{ number_format($tongTien1, 0, ',', ',') }} VND

                                                        </strong>
                                                        <input type="hidden" name="tongTien1"
                                                            value="{{ $tongTien1 }}">


                                                    </td>
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
                                                            id="tongCongSauGiamGia">{{ number_format($tongTien1, 0, ',', ',') }}
                                                            VND</strong></td>

                                                    <input type="hidden" name="tongCongSauGiamGia"
                                                        value="{{ $tongTien1 }}"> <!-- Phí vận chuyển -->

                                                    <!-- Lưu tổng tiền -->

                                                </tr>





                                                <script>
                                                    $(document).ready(function() {
                                                        // Khi thay đổi phương thức vận chuyển
                                                        $("#phuongthucvanchuyen").on("change", function() {
                                                            var phuongThucVanChuyenId = $(this).val(); // Lấy ID phương thức vận chuyển
                                                            var phuongThucGiaohang = $("#phuongthucvanchuyen option:selected").data(
                                                                "phuongthucgiaohang"); // Lấy phí vận chuyển

                                                            // Lấy giá tiền cơ bản
                                                            var tongTien1 = {{ $tongTien1 }};

                                                            // Tính tổng cộng (sau khi cộng phí vận chuyển)
                                                            var tongCong = tongTien1 + phuongThucGiaohang;

                                                            // Cập nhật lại tổng cộng sau khi cộng phí vận chuyển (trước khi áp dụng mã giảm giá)
                                                            $("#tongCongSauGiamGia").html(number_format(tongCong, 0, ',', ',') + " VND");

                                                            // Cập nhật lại giá trị phí vận chuyển để tránh bị trừ trong mã giảm giá
                                                            $("#phuongThucGiaohang").val(phuongThucGiaohang);
                                                        });

                                                        // Lắng nghe sự kiện bấm nút xác nhận mã giảm giá
                                                        $(".nutxacnhan").on("click", function() {
                                                            var voucherCode = $("#maVoucher").val(); // Lấy mã giảm giá từ ô nhập
                                                            var tongTien1 = {{ $tongTien1 }}; // Lấy giá trị tổng tiền ban đầu từ PHP
                                                            var phuongThucGiaohang = $("#phuongThucGiaohang").val(); // Lấy phí vận chuyển
                                                            var voucherDiscount = 0; // Giá trị giảm giá mặc định là 0

                                                            // Nếu có voucherCode thì gửi yêu cầu để lấy discount (ví dụ từ backend)
                                                            $.ajax({
                                                                url: "{{ route('getVoucherDiscount') }}", // Đổi route cho phù hợp với hệ thống của bạn
                                                                type: "GET",
                                                                data: {
                                                                    voucherCode: voucherCode
                                                                },
                                                                success: function(response) {
                                                                    if (response.success) {
                                                                        voucherDiscount = response.discount; // Lấy discount từ response
                                                                    } else {
                                                                        alert('Mã giảm giá không hợp lệ');
                                                                    }

                                                                    // Tính tổng tiền sau giảm giá (lưu ý không trừ phí vận chuyển)
                                                                    var tongCongSauGiamGia = tongTien1 - (tongTien1 * voucherDiscount /
                                                                        100) + parseFloat(phuongThucGiaohang);

                                                                    // Cập nhật lại tổng tiền sau giảm giá
                                                                    $("#tongCongSauGiamGia").text(number_format(tongCongSauGiamGia, 0, ',',
                                                                        ',') + " VND");
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.error("Có lỗi xảy ra: " + error);
                                                                }
                                                            });
                                                        });
                                                    });

                                                    // Hàm định dạng số theo kiểu Việt Nam
                                                    function number_format(number, decimals, dec_point, thousands_sep) {
                                                        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                                                        var n = !isFinite(+number) ? 0 : +number,
                                                            precision = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                                                            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                                                            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                                                            s = '',
                                                            toFixedFix = function(n, precision) {
                                                                var k = Math.pow(10, precision);
                                                                return '' + Math.round(n * k) / k;
                                                            };
                                                        s = (precision ? toFixedFix(n, precision) : '' + Math.round(n)).split('.');
                                                        if (s[0].length > 3) {
                                                            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                                                        }
                                                        if ((s[1] || '').length < precision) {
                                                            s[1] = s[1] || '';
                                                            s[1] += new Array(precision - s[1].length + 1).join('0');
                                                        }
                                                        return s.join(dec);
                                                    }
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
