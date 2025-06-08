<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <title>Thông báo đơn hàng </title>
</head>

<body
    style="background-color: #e7eff8; font-family: trebuchet, sans-serif; margin-top: 0; box-sizing: border-box; line-height: 1.5; color: #000000 !important;">
    <div class="container-fluid">
        <div class="container" style="background-color: #e7eff8; width: 600px; margin: auto;">
            <div class="col-12 mx-auto" style="width: 580px; margin: 0 auto;">

                <div class="row">
                    <div class="container-fluid">
                        <div class="row" style="background-color: #e7eff8; height: 10px;">

                        </div>
                    </div>
                </div>

                <div class="row"
                    style="height: 100px; padding: 10px 20px; line-height: 90px; background-color: white; box-sizing: border-box;">
                    <h1 class="pl-3"
                        style="color: orange; line-height: 00px; float: left; padding-left: 20px; padding-top: 5px;">
                        <img src="http://localhost:8000/client/img/logo.png" height="40" alt="logo">
                    </h1>
                    <h1 class="pl-2"
                        style="color: orange; line-height: 30px; float: left; padding-left: 20px; font-size: 40px; font-weight: 500;">
                        NIZI SHOP
                    </h1>
                </div>

                <div class="row" style="background-color: #00509d; height: 200px; padding: 35px; color: white;">
                    <div class="container-fluid">
                        <h3 class="m-0 p-0 mt-4" style="margin-top: 0; font-size: 28px; font-weight: 500;">
                            <strong style="font-size: 32px; color: white;">Thông tin đơn hàng</strong>
                            <br>
                            <p style="color: white;">Cảm ơn quý khách</p>
                        </h3>
                        <div class="row mt-5" style="margin-top: 35px; display: flex;">
                            <div class="col-6"s
                                style="margin-bottom: 25px; flex: 0 0 50%; width: 50%; box-sizing: border-box;">
                                <b style="color: white;">Mã đơn hàng: DH00000{{ $hoadon->idhd }}</b>
                                <br>
                                <b style="color: white;">Họ Và Tên: {{ $hoadon->diachi->tennguoinhan }}</b>
                                <br>
                                <span>
                                    <a style="color: white !important;" href="mailto:{{ $hoadon->khachhang->email }}"
                                        target="_blank">Email: {{ $hoadon->khachhang->email }}</a>
                                </span>
                                <br>
                                <span style="color: white;">Số Điện thoại: 0{{ $hoadon->diachi->sdt }}</span>
                            </div>
                            <div class="col-6" style="flex: 0 0 50%; width: 50%; box-sizing: border-box;">
                                <b style="color: white;">Ngày đặt hàng:</b>
                                {{ \Carbon\Carbon::parse($hoadon->ngaydathang)->format('d/m/Y') }}
                                <br>
                                <b style="color: white;">Ngày nhận hàng dự kiến:</b>
                                {{ \Carbon\Carbon::parse($hoadon->ngaynhanhang)->format('d/m/Y') }}
                                <br>
                                <b style="color: white;">Địa chỉ:</b>
                                {{ $hoadon->diachi->diachi }}
                                <br>
                                <b style="color: white;">Phường: </b> {{ $hoadon->diachi->phuongxa }},
                                <b style="color: white;">Quận: </b>{{ $hoadon->diachi->quanhuyen }},
                                <b style="color: white;">Thành phố: </b> {{ $hoadon->diachi->tinhthanhpho }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 p-4" style="background-color: white; margin-top: 15px; padding: 20px;">
                    <table>
                        <tr>
                            <td>
                                <img src="https://ci6.googleusercontent.com/proxy/8eUxMUXMkvgUKX8veBCRQM5N7-jXP0Wx8KjQLaGDch2DnV_5HYw9PMgJXsoqgSR_jonTY9jAftWPKNsN5W9cUUneQ9hz7IhxH4rIXNzHMm0ijbsNjHB9m7g6XfJJ=s0-d-e1-ft#https://www.bambooairways.com/reservation/common/hosted-images/tickets.jpg"
                                    alt="">
                            </td>

                            @if ($hoadon->phuongthucthanhtoan->ten == 'Thanh toán COD')
                                <td class="pl-3" style=" padding-left:15px;">
                                    <span class="d-inline"
                                        style="color:#424853; font-family:trebuchet,sans-serif; font-size:16px; font-weight:normal; line-height:22px;">
                                        Vui lòng kiểm tra sản phẩm trước khi thanh toán.
                                    </span>
                                </td>
                            @elseif($hoadon->phuongthucthanhtoan->ten == 'VNPay')
                                <td class="pl-3" style=" padding-left:15px;">
                                    <span class="d-inline"
                                        style="color:#424853; font-family:trebuchet,sans-serif; font-size:16px; font-weight:normal; line-height:22px;">
                                        Thanh toán thành công, đơn hàng sẽ sớm được giao cho đơn vị vận chuyển.

                                    </span>
                                </td>
                                <td class="pl-3" style=" padding-left:10px;">
                                    <img src="https://vnpay.vn/wp-content/uploads/2020/07/Logo-VNPAYQR-update.png"
                                        width="130px" style="margin-top: 10px;" alt="">

                                </td>
                            @endif

                        </tr>
                    </table>
                </div>

                <div class="row mt-2" style="margin-top: 15px;">
                    <div class="container-fluid">
                        <div class="row pl-3 py-2" style="background-color: #f4f8fd; padding: 10px 0 10px 20px;">
                            <b style="color: #000000;">Chi tiết đơn hàng</b>
                        </div>
                        <div class="row pl-3 py-2" style="background-color: #fff; padding: 10px 20px 10px 20px;">
                            <table class="table table-sm table-hover"
                                style="text-align: left;  width: 100%; margin-bottom: 5px; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 0; color: #000000;">SẢN PHẨM</th>
                                        <th style="padding: 5px 20px 5px 0; text-align: right; color: #000000;">TỔNG
                                            CỘNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tong = 0;
                                    @endphp
                                    @foreach ($chitiethoadon->chitietsanpham as $ctsp)
                                        <tr>
                                            <td style="border-top: 1px solid #dee2e6; padding: 5px 0; color: #000000;">
                                                {{ $ctsp->sanpham->ten }}
                                                (Màu: {{ $ctsp->mau->ten }}, Size: {{ $ctsp->kichthuoc->ten }})
                                                x {{ $chitiethoadon->soluong }}
                                            </td>
                                            <td
                                                style="border-top: 1px solid #dee2e6; padding: 5px 20px 5px 0; text-align: right; color: #000000;">
                                                @php
                                                    $giagoc = $ctsp->sanpham->gia;
                                                    $phamtramgiam = $ctsp->sanpham->giamgia->phantram;
                                                    $tongtien = $giagoc - ($giagoc * $phamtramgiam) / 100;
                                                    $tong += $tongtien * $chitiethoadon->soluong;
                                                @endphp
                                                <b>{{ number_format($tongtien * $chitiethoadon->soluong) }}đ</b>
                                            </td>
                                        </tr>
                                    @endforeach


                                    

                                </tbody>
                            </table>
                            <div class="row pl-3 py-2" style="background-color: #f4f8fd; padding: 10px 0 10px 20px;">
                                <b style="color: #000000;">Tổng cộng đơn hàng:</b>
                                <b style="color: #000000; padding-left: 10px;">{{ number_format($tong) }}đ</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" style="margin-top: 15px;">
                    <div class="container-fluid">
                        <div class="row pl-3 py-2" style="background-color: #f4f8fd; padding: 10px 0 10px 20px;">
                            <b>Chi tiết thanh toán</b>
                        </div>
                        <div class="row pl-3 py-2"
                            style="background-color: #fff; font-size: 18px; padding: 2px 20px 10px 20px;">
                            <div class="col-12 p-0">
                                <hr style="border-top: 1px solid #0000001a;">
                                <table class="mt-2 w-100"
                                    style="font-size: 16px; width: 100%; text-align: left;  margin-bottom: 5px;">
                                    <tr>
                                        <td class="">Đơn giá</td>
                                        <td class="pr-3 text-right" style="text-align: right; padding-right: 20px;">
                                            {{ number_format($tong) }} vnđ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">Phí giao hàng</td>
                                        <td class="pr-3 text-right" style="text-align: right; padding-right: 20px;">
                                            {{-- Nếu bạn muốn lấy phí giao hàng từ phương thức giao hàng của đơn hàng --}}
                                            {{ number_format($hoadon->phuongthucgiaohang->phigiaohang) }} vnđ
                                        </td>
                                    </tr>

                                    <tr style="font-size: 18px;">
                                        <td><b>TỔNG CỘNG</b></td>
                                        <td class="pr-3 text-right" style="text-align: right; padding-right: 20px;">
                                            <b>{{ number_format($tong + $hoadon->phuongthucgiaohang->phigiaohang) }}
                                                vnđ</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 mb-4" style="margin-top: 15px; margin-bottom: 25px;">
                    <div class="container-fluid">
                        <div class="row pl-3 py-2" style="background-color: #f4f8fd; padding: 10px 0 10px 20px;">
                            <b style="color: #00509d; font-size: 18px;">Thông tin</b>
                        </div>
                        <div class="row pl-3 py-2" style="background-color: #fff; padding: 10px 20px;">
                            <p>Bạn có thể kiểm tra ngoại hình của sản phẩm (thương hiệu, màu sắc, số lượng,...) trước
                                khi thanh toán và có quyền từ chối nhận hàng nếu không hài lòng. Vui lòng không thử sản
                                phẩm..</p>

                            <p>Nếu sản phẩm có dấu hiệu hư hỏng/ghi nát hoặc không khớp với thông tin trên website, vui
                                lòng liên hệ cửa hàng trong vòng 48 giờ kể từ thời điểm nhận hàng để được hỗ trợ.</p>

                            <p>Vui lòng giữ hóa đơn, hộp sản phẩm và thẻ bảo hành (nếu có) để đổi trả hoặc bảo hành khi
                                cần thiết.</p>

                            <p>Bạn có thể tham khảo trang Trung tâm Trợ giúp hoặc liên hệ cửa hàng bằng cách để lại tin
                                nhắn tại trang Liên hệ hoặc gửi email tại đây. Đường dây nóng 0866622409 (8:00 - 21:00
                                cả thứ bảy và chủ nhật).</p>

                            <b>NIZI cảm ơn bạn.</b>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row" style="margin-top: 25px; height: 50px; background-color: #002f6c;">
                        <div class="col-md-12"
                            style="text-align: center; font-size: 14px; line-height: 50px; color: #ffffff; font-weight: 400;">
                            <b>Copyright © 2024, NIZI SHOP.</b>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
