@extends('client.layout.master')

@section('title', 'Kiểm tra đơn hàng')
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
                                    <li>
                                        Kiểm tra đơn hàng
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <h2 class="text-center mb-4">Kiểm Tra Đơn Hàng</h2>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form id="order-check-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Mã hóa đơn</label>
                                    <input type="text" class="form-control" id="idhd" name="idhd"
                                        placeholder="Nhập mã đơn hàng" required>
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="sdt" name="sdt"
                                        placeholder="Nhập số điện thoại của bạn" required>
                                    <div id="phone-error" class="text-danger mt-2 d-none">Không tìm thấy đơn hàng với số
                                        điện thoại này.</div>

                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kiểm tra</button>



                                <style>
                                    /* Tăng khoảng cách giữa các nhóm label và input */
                                    .form-label {
                                        margin-bottom: 10px;
                                        /* Khoảng cách dưới nhãn */
                                        display: block;
                                        /* Đảm bảo nhãn hiển thị thành dòng riêng */
                                    }

                                    .form-control {
                                        margin-bottom: 20px;
                                        /* Khoảng cách dưới input */
                                        padding: 10px;
                                        /* Tăng khoảng cách bên trong input */
                                        border-radius: 8px;
                                        /* Bo góc nhẹ */
                                        border: 1px solid #ced4da;
                                        /* Viền nhẹ */
                                    }

                                    /* Tăng khoảng cách chung giữa các nhóm */
                                    .mb-3 {
                                        margin-bottom: 30px;
                                        /* Khoảng cách lớn hơn giữa các nhóm */
                                    }

                                    .btn {
                                        background-color: #007bff;
                                        color: #fff;
                                        padding: 10px 20px;
                                        border: none;
                                        border-radius: 4px;
                                        cursor: pointer;

                                    }

                                    .btn {
                                        border-radius: 0px;
                                        font-size: 14px;
                                        padding: 0px 15px;
                                        height: 30px;
                                        line-height: 30px;
                                    }

                                    #phone-error {
                                        color: #dc3545;
                                        font-size: 14px;
                                    }
                                </style>


                            </form>
                        </div>
                    </div>
                    <div id="order-result" class="mt-5 d-none"></div>
                </div>


                {{-- <script>
                    $(document).ready(function() {
                        $('#order-check-form').on('submit', function(e) {
                            e.preventDefault();

                            const sdt = $('#sdt').val();

                            // Ẩn thông báo lỗi và kết quả đơn hàng trước khi gửi yêu cầu
                            $('#phone-error').addClass('d-none');
                            $('#order-result').addClass('d-none').html('');

                            $.ajax({
                                url: '{{ route('hoadon.kiemtra') }}',
                                method: 'POST',
                                data: {
                                    sdt: sdt,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        const orders = response.data;

                                        if (orders.length > 0) {
                                            let resultHtml =
                                                `<h3 class="text-center">Danh Sách Đơn Hàng</h3>`;
                                            orders.forEach(order => {
                                                resultHtml += `
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <p><strong>Mã đơn hàng:</strong> DH00000${order.ma_don_hang}</p>
                                                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tongtien)}</p>
                                                        <p><strong>Ngày đặt hàng:</strong> ${order.ngaydathang}</p>
                                                        <p><strong>Ngày nhận hàng:</strong> ${order.ngaynhanhang}</p>
                                                        <p><strong>Trạng thái:</strong> ${order.trang_thai}</p>
                                                        <button class="btn btn-primary view-details-btn" data-order='${JSON.stringify(order)}'>Xem chi tiết</button>
                                                    </div>
                                                </div>
                                            `;
                                            });
                                            $('#order-result').removeClass('d-none').html(resultHtml);
                                        } else {
                                            // Không có đơn hàng, ẩn phần kết quả
                                            $('#order-result').addClass('d-none').html('');
                                            $('#phone-error').removeClass('d-none').html(
                                                'Không tìm thấy đơn hàng với số điện thoại này.');
                                        }
                                    }
                                },
                                error: function(xhr) {
                                    if (xhr.status === 404) {
                                        // Hiển thị thông báo lỗi nếu không tìm thấy đơn hàng
                                        $('#phone-error').removeClass('d-none').html(
                                            'Không tìm thấy đơn hàng với số điện thoại này.');
                                    } else {
                                        $('#phone-error').removeClass('d-none').html(
                                            'Số điện thoại không hợp lệ.');
                                    }
                                }
                            });
                        });

                        // Hiển thị popup chi tiết đơn hàng
                        $(document).on('click', '.view-details-btn', function() {
                            const order = $(this).data('order');
                            const popupHtml = `
                                <div class="popup-overlay">
                                    <div class="popup-content">
                                        <h4>Chi tiết đơn hàng</h4>
                                        <p><strong>Mã đơn hàng:</strong> DH00000${order.ma_don_hang}</p>
                                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tongtien)}</p>
                                        <p><strong>Ngày đặt hàng:</strong> ${order.ngaydathang}</p>
                                        <p><strong>Ngày nhận hàng:</strong> ${order.ngaynhanhang}</p>
                                        <p><strong>Trạng thái:</strong> ${order.trang_thai}</p>
                                        <button class="btn btn-secondary close-popup">Đóng</button>
                                    </div>
                                </div>
                            `;
                            $('body').append(popupHtml);
                            $('body').css('overflow', 'hidden'); // Ngăn cuộn trang khi popup mở
                        });

                        // Đóng popup
                        $(document).on('click', '.close-popup', function() {
                            $('.popup-overlay').remove();
                            $('body').css('overflow', 'auto'); // Cho phép cuộn lại khi đóng popup
                        });
                    });
                </script> --}}
                <script>
                    $(document).ready(function() {
                        $('#order-check-form').on('submit', function(e) {
                            e.preventDefault();

                            const idhd = $('#idhd').val();
                            const sdt = $('#sdt').val();

                            // Kiểm tra định dạng mã đơn hàng
                            if (idhd && !/^DH00000\d+$/.test(idhd)) {
                                $('#phone-error').removeClass('d-none').html('Mã đơn hàng không tồn tại.');
                                return;
                            }

                            $('#phone-error').addClass('d-none');
                            $('#order-result').addClass('d-none').html('');

                            $.ajax({
                                url: '{{ route('hoadon.kiemtra') }}',
                                method: 'POST',
                                data: {
                                    idhd: idhd,
                                    sdt: sdt,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        const orders = response.data;

                                        if (orders.length > 0) {
                                            let resultHtml =
                                                `<h3 class="text-center">Danh Sách Đơn Hàng</h3>`;
                                            orders.forEach(order => {
                                                resultHtml += `
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <p><strong>Mã đơn hàng:</strong> DH00000${order.ma_don_hang}</p>
                                                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tongtien)}</p>
                                                        <p><strong>Ngày đặt hàng:</strong> ${order.ngaydathang}</p>
                                                        <p><strong>Ngày nhận hàng:</strong> ${order.ngaynhanhang}</p>
                                                        <p><strong>Trạng thái:</strong> ${order.trang_thai}</p>
                                                        <button class="btn btn-primary view-details-btn" data-order='${JSON.stringify(order)}'>Xem chi tiết</button>
                                                    </div>
                                                </div>`;
                                            });
                                            $('#order-result').removeClass('d-none').html(resultHtml);
                                        } else {
                                            $('#phone-error').removeClass('d-none').html(
                                                'Không tìm thấy đơn hàng.');
                                        }
                                    }
                                },
                                error: function(xhr) {
                                    if (xhr.status === 404) {
                                        $('#phone-error').removeClass('d-none').html(
                                            'Không tìm thấy đơn hàng.');
                                    } else {
                                        $('#phone-error').removeClass('d-none').html(
                                            'Số điện thoại hoặc mã đơn hàng không hợp lệ.');
                                    }
                                }
                            });
                            
                        });
                        $(document).on('click', '.view-details-btn', function() {
                            const order = $(this).data('order');

                            const popupHtml = `
                                <div class="popup-overlay">
                                    <div class="popup-content">
                                        <h4>Thông tin đơn hàng</h4>
                                        <p><strong>Mã đơn hàng:</strong> DH00000${order.ma_don_hang}</p>
                                        <p><strong>Ngày đặt hàng :</strong> ${order.ngaydathang}</p>
                                        <p><strong>Ngày nhận hàng dự kiến:</strong> ${order.ngaynhanhang}</p>
                                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tongtien)}</p>
                                        <p><strong>Trạng thái:</strong> ${order.trang_thai}</p>
                                        <p><strong>Người nhận:</strong> ${order.ten}</p>
                                        <p><strong>Địa chỉ nhận hàng:</strong> ${order.diachi}, ${order.phuongxa}, ${order.quanhuyen}, ${order.tinhthanhpho}</p>
                                        <p><strong>Sản phẩm:</strong> ${order.ten_sp}, ${order.mau_san_pham}, ${order.kich_thuoc}(${order.kich_thuoc_mota}) x ${order.soluong}</p>



                                        <button class="btn btn-secondary close-popup">Đóng</button>
                                    </div>
                                </div>
                            `;
                            $('body').append(popupHtml);
                            $('body').css('overflow', 'hidden'); // Ngăn cuộn trang khi popup mở
                        });

                        // Đóng popup
                        $(document).on('click', '.close-popup', function() {
                            $('.popup-overlay').remove();
                            $('body').css('overflow', 'auto'); // Cho phép cuộn lại khi đóng popup
                        });
                    });
                </script>



                <style>
                    /* Overlay nền */
                    .popup-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.6);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 1000;
                        overflow: hidden;
                        /* Ngăn cuộn bên ngoài */
                    }

                    /* Nội dung popup */
                    .popup-content {
                        background: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        max-width: 500px;
                        width: 90%;
                        max-height: 80%;
                        /* Đảm bảo nội dung không tràn quá màn hình */
                        overflow-y: auto;
                        /* Thêm cuộn bên trong nếu nội dung dài */
                        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
                        text-align: left;
                    }

                    .popup-content h4 {
                        margin-bottom: 20px;
                    }

                    .popup-content button {
                        margin-top: 20px;
                    }
                </style>

                <!-- Modal -->
                
                



            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <!--pos page end-->
@endsection
