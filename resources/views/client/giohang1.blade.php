@extends('client.layout.master')

@section('title', 'Giỏ hàng')

@section('body')
    @if (count($chitietgiohang) < 1)
        <!-- Kiểm tra nếu giỏ hàng không tồn tại -->
        <div class="empty-cart-container" style="display: flex; justify-content: center; align-items: center; padding: 20px;">
            <div class="empty-cart-message" style="text-align: left; max-width: 600px;">
                <h2 style="font-size: 24px; color: #333; font-weight: bold;">Bạn chưa lựa chọn được sản phẩm nào?</h2>
                <p style="font-size: 16px; color: #555; margin-bottom: 20px;">
                    Tìm kiếm ngay sản phẩm mà bạn mong muốn với bộ sưu tập rộng lớn của chúng tôi!
                </p>
                <div class="search-container" style="display: flex; align-items: center; padding: 20px 0px;">
                    <form action="/tim-kiem" method="GET" style="display: flex; width: 100%; max-width: 400px;">
                        <input type="text" name="query" placeholder="Tìm kiếm sản phẩm..."
                            style="width: 100%; padding: 8px 10px; border: 1px solid #ddd; font-size: 14px;">
                        <button type="submit"
                            style="background-color: #007bff; color: white; border: none; padding: 8px 15px; font-size: 14px; cursor: pointer;">
                            <i class="fa fa-search"></i> <!-- Biểu tượng kính lúp từ Font Awesome -->
                        </button>
                    </form>
                </div>
            </div>
            <div class="empty-cart-image" style="margin-left: 30px;">
                <img src="{{ asset('client/img/giohang.png') }}" alt="No Products"
                    style="width: 500px; height: auto; border-radius: 8px;">
            </div>
        </div>
    @else
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
                                        <li>Giỏ hàng</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs area end-->
                    <!--shopping cart area start -->
                    <div class="shopping_cart_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="table_desc">
                                    <div class="cart_page table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Chọn</th>
                                                    <th>Hình Ảnh</th>
                                                    <th>Tên Sản Phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số Lượng</th>
                                                    <th>Tổng</th>
                                                    <th><button type="button" id="delete-selected"
                                                            style="background: none; border:none ; font-size:20px "><i
                                                                class="fa fa-times" aria-hidden="true"></i></button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chitietgiohang as $ctgh)
                                                    <tr>
                                                        <td class="product_remove">
                                                            <input type="checkbox" name="selected_items[]"
                                                                value="{{ isset($ctgh['idctgh']) ? $ctgh['idctgh'] : $ctgh['sanpham']->idsp }}"
                                                                class="remove-checkbox1">
                                                        </td>

                                                        <script>
                                                            $('#delete-selected').on('click', function() {
                                                                var selectedItems = [];

                                                                // Lấy tất cả các checkbox đã chọn
                                                                $('.remove-checkbox1:checked').each(function() {
                                                                    selectedItems.push($(this).val()); // Lấy giá trị ID của các sản phẩm đã chọn
                                                                });

                                                                // Kiểm tra nếu có sản phẩm được chọn
                                                                if (selectedItems.length > 0) {
                                                                    $.ajax({
                                                                        url: "{{ route('giohang.deleteSelected') }}", // Đảm bảo route này tồn tại
                                                                        method: "POST",
                                                                        data: {
                                                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                                                            selected_items: selectedItems
                                                                        },
                                                                        success: function(response) {
                                                                            location.reload(); // Làm mới trang sau khi xóa thành công
                                                                        },
                                                                    });
                                                                } else {
                                                                    showNotification('Vui lòng chọn ít nhất một sản phẩm.', 'orange');
                                                                }
                                                            });
                                                        </script>

                                                        <td class="product_thumb">
                                                            <a href="#" style="width:150px">
                                                                @if (isset($ctgh['sanpham']))
                                                                    @foreach ($ctgh['sanpham']->hinhanh as $hinhanh)
                                                                        <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                            alt="không có hình ảnh" />
                                                                    @endforeach
                                                                @endif
                                                            </a>
                                                        </td>

                                                        <td class="product_name">
                                                            <a
                                                                href="{{ route('chitietsanpham', ['slug' => Str::slug($ctgh['sanpham']->sanpham->ten, '-') . '-' . $ctgh['sanpham']->sanpham->idsp]) }}">
                                                                {{ isset($ctgh['sanpham']->sanpham) ? $ctgh['sanpham']->sanpham->ten : 'Sản phẩm không tồn tại' }}
                                                            </a>
                                                            <br>
                                                            <p>
                                                                Màu:
                                                                {{ isset($ctgh['sanpham']->mau) ? $ctgh['sanpham']->mau->ten : 'Không có' }}
                                                                / Size:
                                                                {{ isset($ctgh['sanpham']->kichthuoc) ? $ctgh['sanpham']->kichthuoc->ten : 'Không có' }}
                                                            </p>
                                                        </td>


                                                        <td class="product-price">
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
                                                                @endphp
                                                                {{ number_format($giaSanPham, 0, ',', '.') }} VND
                                                            @else
                                                                Sản phẩm không tồn tại
                                                            @endif
                                                        </td>



                                                        <td class="product_quantity"
                                                            data-idctsp="{{ $ctgh['idctsp'] ?? '' }}">
                                                            <div class="quantity_controls"
                                                                style="display: flex; align-items: center;">
                                                                <button type="button"
                                                                    class="quantity_btn decrease">-</button>
                                                                <input name="soluong" min="1" max="100"
                                                                    value="{{ $ctgh['soluong'] ?? 1 }}" type="number"
                                                                    style="width: 50px; text-align: center; border:none"
                                                                    readonly>
                                                                <button type="button"
                                                                    class="quantity_btn increase">+</button>
                                                            </div>
                                                        </td>


                                                        <td class="product-price">
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

                                                        <script>
                                                            $(document).ready(function() {
                                                                // Lắng nghe sự kiện khi nhấn nút giảm
                                                                $('.decrease').on('click', function() {
                                                                    var $input = $(this).siblings('input');
                                                                    var currentQuantity = parseInt($input.val());
                                                                    if (currentQuantity > 1) {
                                                                        // Chỉ giảm sau khi nhận phản hồi từ server
                                                                        updateCart($input, currentQuantity - 1);
                                                                    }
                                                                });

                                                                // Lắng nghe sự kiện khi nhấn nút tăng
                                                                $('.increase').on('click', function() {
                                                                    var $input = $(this).siblings('input');
                                                                    var currentQuantity = parseInt($input.val());
                                                                    // Chỉ tăng sau khi nhận phản hồi từ server
                                                                    updateCart($input, currentQuantity + 1);
                                                                });

                                                                // Hàm cập nhật giỏ hàng
                                                                function updateCart($input, newQuantity) {
                                                                    var idctsp = $input.closest('td').data('idctsp'); // Lấy idctsp từ data-idctsp
                                                                    var soluong = newQuantity;

                                                                    $.ajax({
                                                                        url: '{{ route('giohang.updatesession') }}',
                                                                        method: 'POST',
                                                                        data: {
                                                                            _token: '{{ csrf_token() }}',
                                                                            idctsp: idctsp, // Gửi idctsp vào yêu cầu
                                                                            soluong: soluong
                                                                        },
                                                                        success: function(response) {
                                                                            
                                                                            if (response.status === 'success') {
                                                                                // Cập nhật lại số lượng trong giao diện sau khi nhận được phản hồi thành công
                                                                                $input.val(response.soluong);

                                                                                // Cập nhật lại giá sản phẩm
                                                                                // Cập nhật lại giá sản phẩm khi số lượng thay đổi
                                                                                $input.closest('tr').find('.tong-tien').text(response.tongtien + ' VND');


                                                                                // Cập nhật tổng tiền của tất cả các sản phẩm
                                                                                updateTotalPrice();
                                                                                location.reload(); // Điều này sẽ reload lại toàn bộ trang

                                                                            } else {
                                                                                alert(response.message);
                                                                            }
                                                                        },
                                                                        error: function() {
                                                                            alert('Không thể cập nhật giỏ hàng.');
                                                                        }
                                                                    });
                                                                }

                                                                // Cập nhật tổng tiền của tất cả các sản phẩm
                                                                function updateTotalPrice() {
                                                                    var totalPrice = 0;
                                                                    $('.product-price').each(function() {
                                                                        var productPrice = $(this).find('.tong-tien').data('tongtien');
                                                                        totalPrice += parseInt(productPrice);
                                                                    });

                                                                    // Cập nhật tổng tiền trên giao diện
                                                                    $('#total-price').text(number_format(totalPrice, 0, ',', '.') + ' VND');
                                                                }

                                                                // Hàm định dạng số
                                                                function number_format(number, decimals, dec_point, thousands_sep) {
                                                                    number = (number + '').replace(',', '').replace(' ', '');
                                                                    var n = !isFinite(+number) ? 0 : +number,
                                                                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                                                                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                                                                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                                                                        s = '',
                                                                        toFixedFix = function(n, prec) {
                                                                            var k = Math.pow(10, prec);
                                                                            return '' + Math.round(n * k) / k;
                                                                        };
                                                                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                                                                    if (s[0].length > 3) {
                                                                        s[0] = s[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
                                                                    }
                                                                    if ((s[1] || '').length < prec) {
                                                                        s[1] = s[1] || '';
                                                                        s[1] += new Array(prec - s[1].length + 1).join('0');
                                                                    }
                                                                    return s.join(dec);
                                                                }
                                                            });
                                                        </script>


                                                        <td class="product_remove">
                                                            <form action="{{ route('giohang.destroy', $ctgh['idctsp']) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="button-xoa">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </form>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>


                                        </table>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--coupon code area start-->
                        <div class="coupon_area">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="coupon_code">
                                        <h3>Ghi chú đơn hàng</h3>
                                        <div class="coupon_inner">
                                            <textarea placeholder="Ghi chú đơn hàng" rows="5" style="width: 100%; padding: 10px; resize: vertical;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="coupon_code">
                                        <h3>Tổng tiền</h3>
                                        <div class="coupon_inner">
                                            <div class="cart_subtotal">
                                                <p>Tổng tiền</p>
                                                <p class="cart_amount">{{ number_format($tongTien, 0, ',', '.') }} VND</p>
                                            </div>


                                            <!-- Thêm ô nhập voucher -->
                                            <div class="cart_subtotal">
                                                <p>Mã voucher</p>
                                                <div class="voucher_code_container">
                                                    @foreach ($giamgia as $gg)
                                                        @if ($gg->phantram > 0)
                                                            <div>
                                                                <input type="text"
                                                                    id="voucherCode_{{ $loop->index }}"
                                                                    value="{{ $gg->code }}" readonly
                                                                    style="width: 200px; margin-right: 10px;">
                                                                <button
                                                                    onclick="copyVoucherCode(event, '{{ $loop->index }}')">Sao
                                                                    chép</button>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div id="copySuccessPopup" class="popup">
                                                    <p>Mã giảm giá đã được sao chép!</p>
                                                </div>

                                                <style>
                                                    .popup {
                                                        display: none;
                                                        position: fixed;
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(-50%, -50%);
                                                        background-color: #82e785;
                                                        padding: 15px 30px;
                                                        border-radius: 8px;
                                                        font-size: 16px;
                                                        z-index: 1000;

                                                    }
                                                </style>

                                                <script>
                                                    function copyVoucherCode(event, index) {
                                                        event.preventDefault();
                                                        const inputField = document.getElementById("voucherCode_" + index);
                                                        inputField.select();
                                                        inputField.setSelectionRange(0, 99999);

                                                        navigator.clipboard.writeText(inputField.value)
                                                            .then(() => {
                                                                showPopup();
                                                            })
                                                            .catch(err => {
                                                                console.error("Không thể sao chép mã giảm giá: ", err);
                                                                alert("Có lỗi khi sao chép mã giảm giá. Vui lòng thử lại.");
                                                            });
                                                    }

                                                    function showPopup() {
                                                        const popup = document.getElementById("copySuccessPopup");
                                                        popup.style.display = "block";
                                                        setTimeout(() => {
                                                            popup.style.display = "none";
                                                        }, 2000);
                                                    }
                                                </script>

                                            </div>




                                            <div class="cart_subtotal11">
                                                <p>Phí vận chuyển sẽ được tính ở trang thanh toán.</p>
                                                <p>Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.</p>
                                            </div>



                                            <div class="checkout_btn">
                                                <a href="{{ route('thanhtoansanphamnotlogin') }}">Tiến hành thanh toán</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--coupon code area end-->
                    </div>
                    <!--shopping cart area end -->

                </div>
                <!--pos page inner end-->
            </div>
        </div>
    @endif
@endsection
