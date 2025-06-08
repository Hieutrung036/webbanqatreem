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
                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="user-actions mb-20">
                                <h3>
                                    <i class="fa fa-file-o" aria-hidden="true"></i>
                                    Đã có tài khoản?
                                    <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_login"
                                        aria-expanded="true">Đăng nhập</a>

                                </h3>
                                <div id="checkout_login" class="collapse" data-parent="#accordion">
                                    <div class="checkout_info">

                                        <form action="#">
                                            <div class="form_group mb-20">
                                                <label>Email <span>*</span></label>
                                                <input type="text">
                                            </div>
                                            <div class="form_group mb-25">
                                                <label>Mật khẩu <span>*</span></label>
                                                <input type="text">
                                            </div>
                                            <div class="form_group group_3 ">
                                                <input value="Đăng nhập" type="submit">
                                                <label for="remember_box">
                                                    <input id="remember_box" type="checkbox">
                                                    <span> Nhớ mật khẩu </span>
                                                </label>
                                            </div>
                                            <a href="#">Quên mật khẩu?</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <form action="{{ route('xulythanhtoan') }}" method="POST">
                        @csrf
                        <input type="hidden" id="iddc" name="iddc" value="">

                        <div class="checkout_form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <h3>Thông tin giao hàng</h3>
                                    <div class="row">
                                        <div class="col-12 mb-20">
                                            <label for="">Chọn địa chỉ</label>

                                            <select id="selectDiaChi">
                                                <option>Chọn địa chỉ</option>
                                                @foreach ($diachi as $dc)
                                                    <option value="{{ $dc->iddc }}"
                                                        data-tennguoinhan="{{ $dc->tennguoinhan }}"
                                                        data-sdt="{{ $dc->sdt ?? '' }}"
                                                        data-diachi="{{ $dc->diachi ?? '' }}"
                                                        data-phuongxa="{{ $dc->phuongxa ?? '' }}"
                                                        data-quanhuyen="{{ $dc->quanhuyen ?? '' }}"
                                                        data-tinhthanhpho="{{ $dc->tinhthanhpho ?? '' }}">
                                                        {{ $dc->tennguoinhan }}, {{ $dc->diachi }},
                                                        0{{ $dc->sdt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Các trường nhập liệu -->
                                        <div class="col-12 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="tennguoinhan" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Họ và tên</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="email" class="form-control floating-input"
                                                    placeholder=" " value="{{ $user ? $user->email : '' }}"
                                                    style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="sdt" class="form-control floating-input"
                                                    placeholder=" " value=""style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Số điện thoại</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="diachi" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Địa chỉ</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="phuongxa" class="form-control floating-input"
                                                    placeholder=" " value="" style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Phường / Xã</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="quanhuyen" class="form-control floating-input"
                                                    placeholder=" " value=""style="font-size: 15px">
                                                <label for="tennguoinhan" class="floating-label">Quận / Huyện</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 mb-10">
                                            <div class="form-group">
                                                <input type="text" id="tinhthanhpho"
                                                    class="form-control floating-input" placeholder=" "
                                                    value=""style="font-size: 15px">
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

                                <script>
                                    // Khi người dùng chọn một địa chỉ
                                    $('#selectDiaChi').change(function() {
                                        // Lấy iddc của địa chỉ được chọn
                                        var iddc = $(this).val();

                                        // Gửi iddc đến backend nếu cần (ví dụ qua AJAX hoặc ẩn trong form)
                                        $('#iddc').val(iddc); // Cập nhật giá trị iddc trong hidden input
                                    });
                                </script>


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
                                                @foreach ($chitietgiohang as $ctgh)
                                                    <tr>
                                                        <td><strong>
                                                                @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                    {{ $ctsp->sanpham->ten }} <!-- Tên sản phẩm -->
                                                                @endforeach
                                                            </strong>
                                                            <p>Màu: @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                    {{ $ctsp->mau->ten }} <!-- Tên sản phẩm -->
                                                                    @endforeach, Kích thước: @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                        {{ $ctsp->kichthuoc->ten }}
                                                                        <!-- Tên sản phẩm -->
                                                                    @endforeach
                                                            </p>
                                                        </td>
                                                        <td>{{ $ctgh->soluong }}</td>
                                                        <td>
                                                            @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                {{-- Kiểm tra xem sản phẩm có giảm giá không, nếu có thì tính giá sau giảm giá --}}
                                                                @if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0)
                                                                    {{-- Tính tổng tiền nếu có giảm giá --}}
                                                                    {{ number_format(($ctsp->sanpham->gia - ($ctsp->sanpham->gia * $ctsp->sanpham->giamgia->phantram) / 100) * $ctgh->soluong, 0, ',', ',') }}
                                                                    VND
                                                                @else
                                                                    {{-- Nếu không có giảm giá, tính theo giá gốc --}}
                                                                    {{ number_format($ctsp->sanpham->gia * $ctgh->soluong, 0, ',', ',') }}
                                                                    VND
                                                                @endif
                                                            @endforeach
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
                                                                url: "{{ route('thanhtoansanpham') }}",
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
