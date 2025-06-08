@extends('client.layout.master')

@section('title', $sanpham->ten)
@section('body')
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
                                    <li><a href="">Sản phẩm</a></li>
                                    <li><i class="fa fa-angle-right"></i></li>
                                    <li>{{ $danhmuc }}</li>
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

                <!--product wrapper start-->
                <div class="product_details">
                    <div class="row">
                        {{-- Hình ảnh --}}
                        <div class="col-lg-5 col-md-6">
                            <div class="product_tab fix">
                                <div class="product_tab_button">
                                    <ul class="nav" role="tablist">
                                        @foreach ($sanpham->hinhanh as $hinhanh)
                                            <li>
                                                <a class="active" data-toggle="tab" href="#p_tab1" role="tab"
                                                    aria-controls="p_tab1" aria-selected="false">
                                                    <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                        alt="khong co hinh anh" class="thumbnail-image"
                                                        data-large="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}" />
                                                </a>
                                            </li>
                                        @endforeach
                                        @php
                                            $shownColors = []; // Mảng lưu các idm đã hiển thị
                                        @endphp

                                        @foreach ($chitietsanpham as $chitiet)
                                            @foreach ($chitiet->hinhanh as $index => $hinhanh)
                                                @if (!in_array($chitiet->idm, $shownColors))
                                                    <!-- Kiểm tra nếu idm chưa được hiển thị -->
                                                    <li>
                                                        <a class="{{ $loop->parent->first && $loop->first ? 'active' : '' }}"
                                                            data-toggle="tab"
                                                            href="#p_tab{{ $chitiet->idctsp }}_{{ $index }}"
                                                            role="tab"
                                                            aria-controls="p_tab{{ $chitiet->idctsp }}_{{ $index }}"
                                                            aria-selected="{{ $loop->parent->first && $loop->first ? 'true' : 'false' }}">

                                                            <!-- Hiển thị hình ảnh của chi tiết sản phẩm -->
                                                            <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                alt="không có hình ảnh" class="thumbnail-image"
                                                                data-large="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}" />
                                                        </a>
                                                    </li>

                                                    @php
                                                        $shownColors[] = $chitiet->idm; // Thêm idm đã hiển thị vào mảng
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </ul>
                                </div>

                                <div class="tab-content produc_tab_c">
                                    <div class="tab-pane fade show active" id="p_tab1" role="tabpanel">
                                        <div class="modal_img">
                                            <a href="#">
                                                <img id="main-image"
                                                    src="{{ asset('uploads/sanpham/' . $sanpham->hinhanh->first()->duongdan) }}"
                                                    alt="không có hình ảnh" />
                                            </a>
                                            <div class="view_img">
                                                <a class="large_view"
                                                    href="{{ asset('uploads/sanpham/' . $sanpham->hinhanh->first()->duongdan) }}">
                                                    <i class="fa fa-search-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-share">
                                <h4>Chia sẻ:</h4>
                                <ul class="social-icons">
                                    <li><a href="https://www.facebook.com" target="_blank" title="Facebook"><i
                                                class="fab fa-facebook"></i></a></li>
                                    <li><a href="https://www.messenger.com" target="_blank" title="Messenger"><i
                                                class="fab fa-facebook-messenger"></i></a></li>
                                    <li><a href="#" target="_blank" title="Zalo"><i class="fab fa-viber"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('.thumbnail-image').click(function() {
                                    var newImage = $(this).attr('src');
                                    $('#main-image').attr('src', newImage);
                                    $('.large_view').attr('href', newImage);
                                });
                            });
                        </script>
                        {{-- Hình ảnh --}}

                        {{-- Thông tin sản phẩm --}}

                        <div class="col-lg-7 col-md-6">
                            <div class="product_d_right">
                                <form id="cartForm" method="POST">

                                    @csrf
                                    <h1> {{ $sanpham->ten }}</h1>
                                    <input type="hidden" name="idsp" value="{{ $sanpham->idsp }}">

                                    <div class="product_ratting mb-10">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li><a href="#"><i class="fa fa-star"></i></a></li>

                                        </ul>
                                        @php
                                            $idsp = $sanpham->idsp; // Thay $sanpham bằng biến thực tế của View

                                            // Lấy danh sách idctsp liên quan đến idsp
                                            $danhgia = DB::table('danhgia')
                                                ->join('chitietsanpham', 'danhgia.idctsp', '=', 'chitietsanpham.idctsp')
                                                ->where('chitietsanpham.idsp', $idsp)
                                                ->selectRaw(
                                                    'COUNT(*) as total_reviews, AVG(danhgia.sosao) as average_rating',
                                                )
                                                ->first();
                                        @endphp
                                        @php
                                            // Lấy idctsp của sản phẩm đang xem
                                            $idctsp = $sanpham->chitietsanpham->pluck('idctsp'); // Lấy tất cả idctsp của sản phẩm

                                            // Tính tổng số lượng sản phẩm đã bán cho tất cả idctsp
                                            $daBan = DB::table('hoadon')
                                                ->join('chitiethoadon', 'hoadon.idhd', '=', 'chitiethoadon.idhd')
                                                ->where('hoadon.idttdh', 9) // Trạng thái "Giao hàng thành công"
                                                ->whereIn('chitiethoadon.idctsp', $idctsp) // Lọc theo nhiều idctsp
                                                ->selectRaw('SUM(chitiethoadon.soluong) AS total_soluong') // Tính tổng số lượng
                                                ->first();
                                        @endphp

                                        <p id="productStatus">{{ $danhgia->total_reviews ?? 0 }} đánh giá |
                                            {{ $daBan->total_soluong ?? 0 }} đã bán | Tình trạng: <span id="stockStatus"
                                                style="color: red; font-size: 18px">...</span></p>

                                    </div>
                                    <div class="content_price mb-15">
                                        @if ($sanpham->giamgia->phantram > 0)
                                            <h4>
                                                {{ number_format($sanpham->gia - ($sanpham->gia * $sanpham->giamgia->phantram) / 100) }}
                                                vnđ
                                                <span class="old-price">{{ number_format($sanpham->gia) }} vnđ</span>
                                            </h4>
                                        @else
                                            <h4>{{ number_format($sanpham->gia) }} vnđ</h4>
                                        @endif
                                    </div>
                                    <style>
                                        .old-price {
                                            text-decoration: line-through;
                                            color: #888;
                                            margin-left: 10px;
                                        }
                                    </style>
                                    <div class="product_d_size mb-20">
                                        <label>Màu</label>
                                        <div class="size-options" id="colorOptions">
                                            @php
                                                $displayedColors = []; // Mảng để theo dõi các màu đã hiển thị
                                            @endphp

                                            @foreach ($chitietsanpham as $chitiet)
                                                @foreach ($mau as $m)
                                                    @if ($chitiet->idm == $m->idm && !in_array($m->idm, $displayedColors))
                                                        <button type="button" class="size-box color-option"
                                                            data-color="{{ $m->idm }}"
                                                            data-image="{{ asset('uploads/sanpham/' . $chitiet->hinhanh->first()->duongdan) }}">
                                                            {{ $m->ten }}
                                                        </button>

                                                        @php
                                                            $displayedColors[] = $m->idm; // Thêm màu vào mảng đã hiển thị
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach


                                        </div>
                                        <input type="hidden" name="mau" id="selectedColor" value="">
                                    </div>

                                    <div class="product_d_size mb-20">
                                        <label>Kích thước</label>
                                        <div class="size-options" id="sizeOptions">
                                            @foreach ($kichthuoc as $kt)
                                                <button type="button" class="size-box size-option"
                                                    data-size="{{ $kt->idkt }}">
                                                    {{ $kt->ten }}: {{ $kt->mota }}
                                                </button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="kichthuoc" id="selectedSize" value="">
                                    </div>

                                    <div class="stock-info">
                                        Trong kho: {{ $chitiet->soluong }} sản phẩm
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            let selectedColor = null;
                                            let selectedSize = null;
                                            let productId = {{ $sanpham->idsp }}; // Lấy ID sản phẩm hiện tại từ Laravel

                                            // Khi người dùng chọn màu
                                            $(".color-option").click(function() {
                                                selectedColor = $(this).data("color");
                                                $("#selectedColor").val(selectedColor);
                                                checkStock();
                                            });

                                            // Khi người dùng chọn kích thước
                                            $(".size-option").click(function() {
                                                selectedSize = $(this).data("size");
                                                $("#selectedSize").val(selectedSize);
                                                checkStock();
                                            });

                                            // Kiểm tra số lượng tồn kho và cập nhật trạng thái sản phẩm
                                            function checkStock() {
                                                if (selectedColor && selectedSize) {
                                                    // Kiểm tra tồn kho theo sản phẩm, màu và kích thước đã chọn
                                                    $.ajax({
                                                        url: '/check-stock',
                                                        method: 'GET',
                                                        data: {
                                                            product_id: productId,
                                                            color: selectedColor,
                                                            size: selectedSize
                                                        },
                                                        success: function(response) {
                                                            let statusText = response.stock > 0 ? "Còn hàng" : "Hết hàng";
                                                            $("#stockStatus").text(statusText); // Cập nhật tình trạng sản phẩm
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    </script>

                                    <script>
                                        $(document).ready(function() {
                                            // Khi người dùng chọn màu
                                            $('.color-option').click(function() {
                                                var selectedImage = $(this).data('image'); // Lấy đường dẫn ảnh của màu được chọn

                                                // Cập nhật hình ảnh chính
                                                $('#main-image').attr('src', selectedImage);

                                                // Cập nhật hình ảnh phóng to
                                                $('.large_view').attr('href', selectedImage);
                                            });
                                        });
                                    </script>

                                    <script>
                                        $(document).ready(function() {
                                            var availableSizes = {};
                                            var stockData = {};

                                            @foreach ($chitietsanpham as $chitiet)
                                                if (!availableSizes[{{ $chitiet->idm }}]) {
                                                    availableSizes[{{ $chitiet->idm }}] = [];
                                                }
                                                availableSizes[{{ $chitiet->idm }}].push({{ $chitiet->idkt }});

                                                stockData[{{ $chitiet->idm }}] = stockData[{{ $chitiet->idm }}] || {};
                                                stockData[{{ $chitiet->idm }}][{{ $chitiet->idkt }}] = {{ $chitiet->soluong }};
                                            @endforeach

                                            $('.color-option').click(function() {
                                                var selectedColor = $(this).data('color');
                                                $('#selectedColor').val(selectedColor);

                                                $('.size-option').show();

                                                $('.size-option').each(function() {
                                                    var size = $(this).data('size');
                                                    var available = availableSizes[selectedColor] && availableSizes[selectedColor]
                                                        .includes(size);

                                                    if (!available) {
                                                        $(this).hide();
                                                    }
                                                });

                                                $('.stock-info').text('');
                                            });

                                            $('.size-option').click(function() {
                                                var selectedColor = $('#selectedColor').val();
                                                var selectedSize = $(this).data('size');
                                                $('#selectedSize').val(selectedSize);

                                                if (stockData[selectedColor] && stockData[selectedColor][selectedSize] !== undefined) {
                                                    var stock = stockData[selectedColor][selectedSize];
                                                    $('.stock-info').text('Trong kho: ' + stock + ' sản phẩm');
                                                } else {
                                                    $('.stock-info').text('Không có sẵn.');
                                                }
                                            });
                                        });
                                    </script>


                                    <style>
                                        .size-option.disabled {
                                            background-color: #ccc;
                                            color: #888;
                                            pointer-events: none;
                                            /* Ngừng sự kiện click */
                                        }
                                    </style>

                                    <div class="sidebar_widget color">
                                        <h6>Vận chuyển</h6>
                                        <i class="fas fa-truck" id="btnToggle" style="color: #0a53be"></i>

                                        @foreach ($phuongthucgiaohang as $phuongthuc)
                                            @if ($phuongthuc->phigiaohang > 0)
                                                <div class="pd-color-choose square-box">
                                                    {{ $phuongthuc->ten }},
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="info-popup1" id="infoContainer">
                                            @foreach ($phuongthucgiaohang as $phuongthuc)
                                                @if ($phuongthuc->phigiaohang > 0)
                                                    <table style="width: 100%; border-collapse: collapse;">
                                                        <tr>
                                                            <td style="width: 70%;">
                                                                <b>{{ $phuongthuc->ten }}</b> <br>
                                                                {{ $phuongthuc->mota }}
                                                            </td>
                                                            <td style="text-align: right; width: 30%;">
                                                                {{ number_format($phuongthuc->phigiaohang) }} vnđ</td>
                                                        </tr>
                                                    </table>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="sidebar_widget color">
                                        <h6 style="display: inline-block; margin-right: 10px;">Chính sách hoàn trả</h6>
                                        <div class="pd-color-choose square-box"
                                            style="display: inline-block; position: relative;">
                                            Hoàn trả miễn phí trong 7 ngày
                                            <i class="showphigiaohang-icon fas fa-info-circle"
                                                style="color: #6c757d; margin-left: 5px;"></i>
                                            <div class="info-popup">
                                                Miễn phí trả hàng trong vòng 7 ngày. Nếu đổi ý(hàng phải còn nguyên seal,
                                                tem,
                                                hộp sản phẩm). Ngoài ra, tại thời diểm nhận hàng bạn đồng kiểm hàng và trả
                                                hàng
                                                miễn phí.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box_quantity mb-20">
                                        <label>Số lượng</label>
                                        <div class="quantity-wrapper" style="border: 1px solid #D4D4D4">
                                            <button type="button" class="quantity-btn1" id="decreaseBtn">-</button>
                                            <input min="1" max="100" value="1" type="number"
                                                id="quantityInput" name="quantity" readonly>
                                            <button type="button" class="quantity-btn1" id="increaseBtn">+</button>
                                        </div>
                                        <style>
                                            /* CSS */
                                            .quantity-wrapper {
                                                display: flex;
                                                align-items: center;
                                                margin-left: 20px
                                            }

                                            button#decreaseBtn {
                                                background: none;
                                                font-size: 15px;
                                                color: #686868;
                                                font-weight: normal;

                                            }

                                            button#increaseBtn {
                                                background: none;
                                                font-size: 15px;
                                                color: #686868;
                                                font-weight: normal;
                                            }

                                            .quantity-btn1 {
                                                width: 30px;
                                                height: 30px;
                                                font-size: 18px;
                                                cursor: pointer;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                            }

                                            input[type="number"] {
                                                width: 50px;
                                                text-align: center;
                                                margin: 0 10px;
                                                padding: 5px;
                                            }
                                        </style>


                                    </div>

                                    <div class="box_quantity mb-20">
                                        <button type="submit" class="btn btn-success"
                                            onclick="submitForm('giohang.store')">Thêm vào giỏ hàng</button>
                                        <button type="submit" class="btn btn-success"
                                            onclick="submitForm('dathang')">Mua ngay</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <script>
                            function submitForm(routeName) {
                                let form = document.getElementById('cartForm');

                                // Dùng Blade để lấy URL của từng route
                                let url = routeName === 'giohang.store' ?
                                    "{{ route('giohang.store') }}" :
                                    "{{ route('dathang') }}";

                                form.action = url;
                                form.submit();
                            }
                        </script>

                        <script>
                            
                        </script>


                        <script>
                            document.querySelectorAll('.color-option').forEach(function(button) {
                                button.addEventListener('click', function() {
                                    var colorId = this.getAttribute('data-color');
                                    document.getElementById('selectedColor').value = colorId;
                                });
                            });

                            document.querySelectorAll('.size-option').forEach(function(button) {
                                button.addEventListener('click', function() {
                                    var sizeId = this.getAttribute('data-size');
                                    document.getElementById('selectedSize').value = sizeId;
                                });
                            });
                        </script>
                        <style>
                            .selected {
                                border: 2px solid #007bff;
                                color: #007bff;
                            }
                        </style>


                        {{-- Thông tin sản phẩm --}}
                    </div>
                </div>
                <!--product details end-->
                <script>
                    document.querySelectorAll('.color-option').forEach(button => {
                        button.addEventListener('click', () => {
                            document.getElementById('selectedColor').value = button.getAttribute('data-color');
                        });
                    });

                    document.querySelectorAll('.size-option').forEach(button => {
                        button.addEventListener('click', () => {
                            document.getElementById('selectedSize').value = button.getAttribute('data-size');
                        });
                    });
                </script>

                <!--mô tả sản phẩm-->
                <div class="product_d_info">
                    <div class="row">
                        <div class="col-12">
                            <div class="product_d_inner">
                                <div class="product_info_button">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#info" role="tab"
                                                aria-controls="info" aria-selected="false">Mô tả sản phẩm</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet"
                                                aria-selected="false">Chi tiết sản phẩm</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                                aria-selected="false">Đánh giá</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                                        <div class="product_info_content">
                                            <p>{{ $sanpham->mota }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="sheet" role="tabpanel">
                                        <div class="product_d_table">
                                            <form action="#">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="first_child">Chất liệu</td>
                                                            <td>{{ $sanpham->chatlieu }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="first_child">Thương hiệu</td>
                                                            <td>{{ $sanpham->thuonghieu->ten }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="first_child">Dòng sản phẩm</td>
                                                            <td>{{ $sanpham->loaisanpham->ten }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">

                                        @if ($sanpham->chitietsanpham->isEmpty() || $sanpham->chitietsanpham->first()->danhgia->isEmpty())
                                            <p>Không có đánh giá nào cho sản phẩm này.</p>
                                        @else
                                            @foreach ($sanpham->chitietsanpham as $ctsp)
                                                @foreach ($ctsp->danhgia as $dg)
                                                    <div class="product_info_inner">
                                                        <div class="product_ratting mb-10">
                                                            <ul>
                                                                @for ($i = 0; $i < $dg->sosao; $i++)
                                                                    <li><i class="fa fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                            <strong>Màu: {{ $dg->chitietsanpham->mau->ten }}</strong>
                                                            <br>
                                                            <strong>Size: {{ $dg->chitietsanpham->kichthuoc->ten }}:
                                                                {{ $dg->chitietsanpham->kichthuoc->mota }}</strong>
                                                            <p>{{ \Carbon\Carbon::parse($dg->thoigian)->translatedFormat('d \\T\\há\\n\\g m, Y') }}
                                                            </p>
                                                        </div>
                                                        <div class="product_demo">
                                                            <strong>Tên: {{ $dg->khachhang->ten }}</strong>
                                                            <p>{{ $dg->noidung }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="product_info_inner mt-3">
                                                        <div class="product_ratting mb-10">
                                                            @foreach ($dg->phanhoi as $phanhoi)
                                                                <div class="product_info_inner mt-3">
                                                                    <div class="product_ratting mb-10">
                                                                        <strong>Phản hồi từ Nhân viên</strong>
                                                                        <p>{{ $phanhoi->noidung }}</p>
                                                                        <p><i>Thời gian phản hồi:
                                                                                {{ \Carbon\Carbon::parse($phanhoi->thoigian)->translatedFormat('d \\T\\há\\n\\g m, Y') }}</i>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <!-- Đường gạch ngang giữa các đánh giá -->
                                                    <hr class="my-4" style="border: 1px solid #ddd;">
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--mô tả sản phẩm-->


                <!--Sản phảm liên quan-->
                <div class="new_product_area product_page">
                    <div class="row">
                        <div class="col-12">
                            <div class="block_title">
                                <h3>⚡ Các sản phẩm liên quan:</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="single_p_active owl-carousel">
                            @foreach ($sanphamlienquan as $sanpham)
                                <div class="col-lg-3">
                                    <div class="single_product">
                                        <div class="product_thumb">
                                            <a
                                                href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten, '-') . '-' . $sanpham->idsp]) }}">
                                                @foreach ($sanpham->hinhanh as $hinhanh)
                                                    <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                        alt="khong co hinh anh" />
                                                @endforeach
                                            </a>
                                            <div class="img_icone">
                                                @if ($sanpham->moi)
                                                    <img src="{{ asset('client/img/cart/span-new.png') }}"
                                                        alt="Mới">
                                                @endif
                                            </div>

                                        </div>
                                        <div class="product_content">
                                            <span class="product_price">{{ number_format($sanpham->gia) }} VND</span>
                                            <h3 class="product_title"><a
                                                    href=" {{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten, '-') . '-' . $sanpham->idsp]) }}">{{ $sanpham->ten }}</a>
                                            </h3>
                                        </div>
                                        <div class="product_info">
                                            <ul>
                                                <li><a href="#" title=" Add to Wishlist ">Mua ngay</a>
                                                </li>
                                                <li><a href="#" data-toggle="modal" data-target="#modal_box"
                                                        title="Quick view">Xem nhanh</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--Sản phảm liên quan-->

                <!--Sản phảm đã xem-->
                <div class="new_product_area product_page">
                    <div class="row">
                        <div class="col-12">
                            <div class="block_title">
                                <h3>⚡ Sản phẩm đã xem</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="single_p_active owl-carousel">
                            @foreach ($sanphamdaxem as $sanpham)
                                <div class="col-lg-3">
                                    <div class="single_product">
                                        <div class="product_thumb">
                                            <a
                                                href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten, '-') . '-' . $sanpham->idsp]) }}">


                                                @foreach ($sanpham->hinhanh as $hinhanh)
                                                    <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                        alt="khong co hinh anh" />
                                                @endforeach
                                            </a>
                                            <div class="img_icone">
                                                @if ($sanpham->moi)
                                                    <img src="{{ asset('client/img/cart/span-new.png') }}"
                                                        alt="Mới">
                                                @endif
                                            </div>

                                        </div>
                                        <div class="product_content">
                                            <span class="product_price">{{ number_format($sanpham->gia) }} VND</span>
                                            <h3 class="product_title">
                                                <a
                                                    href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten, '-') . '-' . $sanpham->idsp]) }}">
                                                    {{ $sanpham->ten }}
                                                </a>


                                            </h3>
                                        </div>
                                        <div class="product_info">
                                            <ul>
                                                <li><a href="#" title=" Add to Wishlist ">Mua ngay</a>
                                                </li>
                                                <li><a href="#" data-toggle="modal" data-target="#modal_box"
                                                        title="Quick view">Xem nhanh</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
                <!--Sản phảm đã xem-->

            </div>
            <!--pos page inner end-->
        </div>
    </div>
@endsection
