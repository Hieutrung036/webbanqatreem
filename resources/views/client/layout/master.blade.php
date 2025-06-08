<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | NIZI SHOP</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('client/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('client/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('client/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('client/img/favicon/site.webmanifest') }}">

    <!-- all css here -->
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/responsive.css') }}">
    <script src="{{ asset('client/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>



<body>
    <!-- Add your site or application content here -->

    <!--pos page start-->
    <div class="pos_page">
        <div class="container">
            <!--pos page inner-->
            <div class="pos_page_inner">
                <!--header area -->
                <div class="header_area">
                    <!--header top-->
                    <div class="header_top">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <div class="mail-service">
                                    <i class="fa fa-envelope"></i>
                                    DH51903588@stu.edu.vn &nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="fa fa-phone"></i>
                                    099 222 4444
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="header_links">
                                    <ul>
                                        @if (Session::has('userName'))
                                            <!-- Kiểm tra xem đã đăng nhập hay chưa -->
                                            <li class="dropdown"> <!-- Thêm lớp dropdown -->
                                                <a href="{{ route('thongtin') }}" class="dropbtn"
                                                    title="Xin chào, {{ Session::get('userName') }}">
                                                    {{ Session::get('userName') }} <i class="fa fa-caret-down"></i>
                                                </a>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('thongtin') }}">Thông tin cá nhân</a>
                                                    <a href="{{ route('client.chat') }}">Chat</a>
                                                    <a href="{{ route('dangxuat') }}">Đăng xuất</a>
                                                </div>
                                            </li>
                                        @else
                                            <li><a href="{{ route('dangnhap') }}" title="Đăng nhập">Đăng nhập</a></li>
                                        @endif
                                    </ul>



                                </div>
                            </div>

                        </div>
                    </div>
                    <!--header top end-->

                    <!--header middel-->
                    <div class="header_middel">
                        <div class="row align-items-center">
                            <!--logo start-->
                            <div class="col-lg-3 col-md-3">
                                <div class="logo">
                                    <a href="{{ route('trangchu') }}"><img src="{{ asset('client/img/logo.png') }}"
                                            alt=""></a>
                                </div>
                            </div>
                            <!--logo end-->
                            <div class="col-lg-9 col-md-9">
                                <div class="header_right_info">
                                    <div class="search_bar">
                                        <form action="{{ route('client.timkiem') }}" method="GET">
                                            <input placeholder="Tìm kiếm..." type="text" name="keyword" required>
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="shopping_cart1">
                                        <a href=""><i class="fa fa-heart" aria-hidden="true"></i> Yêu thích </a>
                                    </div>
                                    <div class="shopping_cart1">
                                        @if (!auth()->check())
                                            <a href="{{ route('kiemtradonhang') }}"><i class="fa fa-file-o"
                                                    aria-hidden="true"></i> Kiểm tra đơn hàng </a>
                                        @endif
                                    </div>

                                    <style>
                                        .shopping_cart1 {
                                            border: 1px solid #ddd;
                                            line-height: 38px;
                                            height: 38px;
                                            margin-left: 25px;
                                            position: relative;
                                        }

                                        .shopping_cart1>a {
                                            font-size: 13px;
                                            padding: 0 15px;
                                            display: block;
                                        }
                                    </style>
                                    <div class="shopping_cart" style="position: relative;">
                                        <a href="{{ route('giohang') }}">
                                            <i class="fa fa-shopping-cart"></i> Giỏ hàng
                                            @if ($soLuongSanPham > 0)
                                                <span> - {{ $soLuongSanPham }} sản phẩm</span>
                                            @else
                                                <span></span>
                                            @endif
                                            <i class="fa fa-angle-down"></i>
                                        </a>




                                        <!--mini cart-->
                                        <div class="mini_cart">
                                            @if (auth()->check())
                                                {{-- Trường hợp người dùng đã đăng nhập --}}
                                                @if (empty($chitietgiohang) || count($chitietgiohang) == 0)
                                                    <p>Giỏ hàng của bạn hiện tại chưa có sản phẩm.</p>
                                                @else
                                                    @foreach ($chitietgiohang as $ctgh)
                                                        <div class="cart_item">
                                                            <div class="cart_img">
                                                                <a href="">
                                                                    @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                        @foreach ($ctsp->hinhanh as $hinhanh)
                                                                            <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                                alt="không có hình ảnh" />
                                                                        @endforeach
                                                                    @endforeach
                                                                </a>
                                                            </div>
                                                            <div class="cart_info">
                                                                <a href="#">
                                                                    @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                        {{ $ctsp->sanpham->ten }} <!-- Tên sản phẩm -->
                                                                    @endforeach
                                                                </a>
                                                                <span class="cart_price">
                                                                    @foreach ($ctgh->chitietsanpham as $ctsp)
                                                                        @if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0)
                                                                            {{ number_format($ctsp->sanpham->gia - ($ctsp->sanpham->gia * $ctsp->sanpham->giamgia->phantram) / 100, 0, ',', '.') }}
                                                                            VND
                                                                        @else
                                                                            {{ number_format($ctsp->sanpham->gia, 0, ',', '.') }}
                                                                            VND
                                                                        @endif
                                                                    @endforeach
                                                                </span>
                                                                <span class="quantity">Số lượng:
                                                                    {{ $ctgh->soluong }}</span>
                                                            </div>
                                                            <div class="cart_remove">
                                                                <form
                                                                    action="{{ route('giohang.destroy', $ctgh->idctgh) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="total_price">
                                                        <span>Tổng tiền</span>
                                                        <span
                                                            class="prices">{{ number_format($tongTien, 0, ',', '.') }}
                                                            VND</span>
                                                    </div>
                                                    <div class="cart_button">
                                                        <a href="{{ route('thanhtoansanpham') }}">Tiến thành thanh
                                                            toán</a>
                                                    </div>
                                                @endif
                                            @else
                                                {{-- Trường hợp người dùng chưa đăng nhập --}}
                                                @php
                                                    $cartSession = session('giohang', []);
                                                @endphp
                                                @if (empty($cartSession) || count($cartSession) == 0)
                                                    <p>Giỏ hàng của bạn hiện tại chưa có sản phẩm.</p>
                                                @else
                                                    @foreach ($cartSession as $item)
                                                        <div class="cart_item">
                                                            <div class="cart_img">
                                                                <a href="">
                                                                    @foreach ($item['sanpham']->hinhanh as $hinhanh)
                                                                        <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                            alt="không có hình ảnh" />
                                                                    @endforeach
                                                                </a>
                                                            </div>
                                                            <div class="cart_info">
                                                                <a
                                                                    href="{{ route('chitietsanpham', ['slug' => Str::slug($item['sanpham']->sanpham->ten, '-') . '-' . $item['sanpham']->sanpham->idsp]) }}">
                                                                    {{ $item['sanpham']->sanpham->ten }}
                                                                    <!-- Tên sản phẩm -->
                                                                </a>
                                                                <span class="cart_price">
                                                                    @if ($item['sanpham']->sanpham->giamgia && $item['sanpham']->sanpham->giamgia->phantram > 0)
                                                                        {{ number_format($item['sanpham']->sanpham->gia - ($item['sanpham']->sanpham->gia * $item['sanpham']->sanpham->giamgia->phantram) / 100, 0, ',', '.') }}
                                                                        VND
                                                                    @else
                                                                        {{ number_format($item['sanpham']->sanpham->gia, 0, ',', '.') }}
                                                                        VND
                                                                    @endif
                                                                </span>
                                                                <span class="quantity">Số lượng:
                                                                    {{ $item['soluong'] }}</span>
                                                            </div>
                                                            <div class="cart_remove">
                                                                <form
                                                                    action="{{ route('giohang.destroy', $item['idctsp']) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="button-xoa">
                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                    <div class="total_price">
                                                        <span>Tổng tiền</span>
                                                        <span
                                                            class="prices">{{ number_format($tongTien, 0, ',', '.') }}
                                                            VND</span>
                                                    </div>
                                                    <div class="cart_button">
                                                        <a href="{{ route('thanhtoansanpham') }}">Tiến thành thanh
                                                            toán</a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>




                                        <!--mini cart end-->
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!--header middel end-->
                    <div class="header_bottom">
                        <div class="row">
                            <div class="col-12">
                                <div class="main_menu_inner">
                                    <div class="main_menu d-none d-lg-block">
                                        <nav>
                                            <ul>
                                                <li class="active"><a href="{{ route('trangchu') }}">Trang chủ</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('sanpham.be_gai') }}">Quần áo bé gái</a>
                                                    <div class="mega_menu">
                                                        <div class="mega_top fix">
                                                            <div class="mega_items">
                                                                <ul>
                                                                    @foreach ($danhmucsanpham as $dm)
                                                                        @if ($dm->gioitinh == 1)
                                                                            <!-- 1 cho bé gái -->
                                                                            <li>
                                                                                <a
                                                                                    href="{{ route('sanpham.be_gai.loai', ['ten' => Str::slug($dm->ten, '-')]) }}">{{ $dm->ten }}</a>
                                                                            </li>
                                                                            {{-- <li>
                                                                                <a
                                                                                    href="{{ route('sanpham.be_gai.loai', ['slug' => Str::slug($dm->ten, '-')]) }}">{{ $dm->ten }}</a>
                                                </li> --}}
                                                                        @endif
                                                                    @endforeach

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <a href="{{ route('sanpham.be_trai') }}">Quần áo bé trai</a>
                                                    <div class="mega_menu">
                                                        <div class="mega_top fix">
                                                            <div class="mega_items">
                                                                <ul>
                                                                    @foreach ($danhmucsanpham as $dm)
                                                                        @if ($dm->gioitinh == 0)
                                                                            <li>
                                                                                <!-- Sử dụng $dm->iddm thay vì $dm->ten -->
                                                                                <a
                                                                                    href="{{ route('sanpham.be_trai.loai', ['ten' => Str::slug($dm->ten, '-')]) }}">{{ $dm->ten }}</a>

                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>



                                                <li><a href="{{ route('tintuc') }}">Tin tức</a>
                                                    <div class="mega_menu jewelry">
                                                        <div class="mega_items jewelry">
                                                            <ul>
                                                                @foreach ($loaitintuc as $loai)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('tintuc.type', ['ten' => Str::slug($loai->ten, '-')]) }}">{{ $loai->ten }}</a>
                                                                    </li>
                                                                @endforeach


                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>

                                                {{-- <li><a href="{{ route('lienhe') }}">Liên hệ</a></li>
                            <li><a href="{{ route('gioithieu') }}">Giới thiệu </a></li> --}}

                                            </ul>
                                        </nav>
                                    </div>

                                    <div class="mobile-menu d-lg-none">
                                        <nav>
                                            <ul>
                                                <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                                                <li><a href="{{ route('sanpham.be_gai') }}">Thời trang bé gái</a>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <ul>
                                                                    @foreach ($danhmucsanpham as $dm)
                                                                        @if ($dm->gioitinh == 1)
                                                                            <li>
                                                                                <!-- Sử dụng $dm->iddm thay vì $dm->ten -->
                                                                                <a
                                                                                    href="{{ route('sanpham.be_gai.loai', ['ten' => Str::slug($dm->ten, '-')]) }}">{{ $dm->ten }}</a>

                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div>
                                                                <a href="#"><img
                                                                        src="client\img\banner\banner3.jpg"
                                                                        alt=""></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li><a href="{{ route('sanpham.be_trai') }}">Thời trang bé trai</a>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <ul>
                                                                    @foreach ($danhmucsanpham as $dm)
                                                                        @if ($dm->gioitinh == 0)
                                                                            <li>
                                                                                <!-- Sử dụng $dm->iddm thay vì $dm->ten -->
                                                                                <a
                                                                                    href="{{ route('sanpham.be_trai.loai', ['ten' => Str::slug($dm->ten, '-')]) }}">{{ $dm->ten }}</a>

                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                            <div>
                                                                <a href="#"><img
                                                                        src="client\img\banner\banner3.jpg"
                                                                        alt=""></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </li>



                                                <li><a href="{{ route('tintuc') }}">Tin tức</a>
                                                    <div>
                                                        <div>
                                                            <ul>
                                                                @foreach ($loaitintuc as $loai)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('tintuc.type', ['ten' => Str::slug($loai->ten, '-')]) }}">{{ $loai->ten }}</a>
                                                                    </li>
                                                                @endforeach


                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>


                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--header end -->


                @yield('body')


                <!--footer area start-->
                <div class="footer_area">
                    <div class="footer_top">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="footer_widget">
                                        <h3>Về chúng tôi</h3>
                                        <p>NIZI SHOP chuyên về các loại mặt hàng thời trang cho bé nhỏ.</p>
                                        <div class="footer_widget_contect">
                                            <p><i class="fa fa-map-marker" aria-hidden="true"></i> 180 Cao Lỗ, Phường
                                                8, Quận 8, TPHCM</p>

                                            <p><i class="fa fa-mobile" aria-hidden="true"></i> (099) 313 222 4444</p>
                                            <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                DH51903588@stu.edu.vn </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="footer_widget">
                                        <h3>Thông tin</h3>
                                        <ul>

                                            <li><a href="{{ route('gioithieu') }}">Về chúng tôi</a></li>
                                            <li><a href="#">Chính sách vận chuyển</a></li>
                                            <li><a href="#">Chính sách đổi trả</a></li>
                                            <li><a href="{{ route('lienhe') }}">Liên hệ</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="footer_widget">
                                        <h3>Sản phẩm</h3>
                                        <ul>
                                            <li><a href="#">Tất cả sản phẩm</a></li>
                                            <li><a href="{{ route('sanpham.noibat') }}">Sản phẩm nổi bật</a></li>
                                            <li><a href="{{ route('sanpham.moi') }}">Sản phẩm mới</a></li>
                                            <li><a href="#">Sản phẩm Sale</a></li>

                                        </ul>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="footer_widget">
                                        <h3>extras</h3>
                                        <ul>
                                            <li><a href="#"> Brands</a></li>
                                            <li><a href="#"> Gift Vouchers </a></li>
                                            <li><a href="#"> Affiliates </a></li>
                                            <li><a href="#"> Specials </a></li>
                                            <li><a href="#"> Privacy policy </a></li>
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="footer_bottom">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <div class="copyright_area">

                                        <p>Copyright &copy; 2024 <a href="#">NGUYỄN TRUNG HIẾU</a>. All rights
                                            reserved.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="footer_social text-right">
                                        <ul>
                                            <li><a href="#" style="background: blue"><i
                                                        class="fa-brands fa-facebook"></i></a></li>
                                            <li><a href="#" style="background: red"><i
                                                        class="fa-brands fa-youtube"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-google"
                                                        aria-hidden="true"></i></a>
                                            </li>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--footer area end-->
                <div class="floating-button">
                    <!-- Nút chính -->
                    <button id="main-button" class="circle-btn">Liên hệ</button>

                    <!-- Các nút menu -->
                    <div id="menu" class="menu hidden">
                        <button class="menu-item chat-btn">Chat với chúng tôi</button>
                        <button class="menu-item call-btn">Gọi ngay cho chúng tôi</button>
                        <button class="menu-item address-btn">Xem địa chỉ</button>
                        <button class="menu-item another-btn">Zalo</button>
                    </div>
                </div>
                <style>
                    @keyframes shake {
                        0% {
                            transform: translateX(0);
                        }

                        25% {
                            transform: translateX(-5px);
                        }

                        50% {
                            transform: translateX(5px);
                        }

                        75% {
                            transform: translateX(-5px);
                        }

                        100% {
                            transform: translateX(0);
                        }
                    }

                    /* Đặt vị trí cố định cho nút chính và các nút phụ */
                    .floating-button {
                        position: fixed;
                        bottom: 150px;
                        /* Điều chỉnh vị trí nút chính lên cao */
                        right: 20px;
                        z-index: 1000;
                        /* Đảm bảo nó ở trên các phần tử khác */
                    }

                    /* Định dạng cho nút chính */
                    .circle-btn {
                        width: 50px;
                        height: 50px;
                        background-color: #db78a3;
                        color: white;
                        border: none;
                        border-radius: 50%;
                        font-size: 10px;
                        cursor: pointer;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                        transition: transform 0.3s;
                        animation: shake 0.5s ease-in-out infinite;
                        /* Thêm hiệu ứng rung */

                    }

                    .circle-btn:hover {
                        transform: scale(1.1);
                    }

                    /* Ẩn menu mặc định */
                    #menu {
                        display: none;
                        flex-direction: column;
                        gap: 10px;
                        position: absolute;
                        bottom: 40px;
                        right: 0;
                    }

                    /* Định dạng cho các nút trong menu */
                    .menu-item {
                        width: 200px;
                        padding: 5px;
                        background-color: #db78a3;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                        transition: background-color 0.3s;
                    }

                    .menu-item:hover {
                        background-color: #c15a86;
                    }

                    /* Hiệu ứng cho việc hiện menu */
                    .hidden {
                        display: none;
                    }

                    .show {
                        display: flex;
                    }

                    /* Thay đổi tên class thành hidden1 và show1 */
                    /* Thay đổi class ẩn và hiển thị để tránh xung đột */
                    .hidden1 {
                        visibility: hidden;
                        /* Sử dụng visibility thay vì display */
                        opacity: 0;
                        /* Ẩn hoàn toàn phần tử */
                        transition: visibility 0s, opacity 0.5s ease;
                        /* Thêm hiệu ứng mượt mà */
                    }

                    .show1 {
                        visibility: visible;
                        /* Hiển thị phần tử */
                        opacity: 1;
                        /* Đảm bảo phần tử không bị mờ */
                        transition: visibility 0s, opacity 0.5s ease;
                        /* Thêm hiệu ứng mượt mà */
                    }




                    @media (max-width: 768px) {

                        /* Điều chỉnh nút chính và menu cho màn hình nhỏ */
                        .floating-button {
                            bottom: 150px;
                            /* Đưa nút lên cao hơn một chút */
                            right: 15px;
                            /* Điều chỉnh vị trí một chút */
                        }

                        .circle-btn {
                            width: 50px;
                            /* Kích thước nút nhỏ hơn */
                            height: 50px;
                            font-size: 12px;
                        }

                        .menu-item {
                            width: 180px;
                            /* Điều chỉnh chiều rộng của các nút menu */
                            font-size: 14px;
                            /* Font nhỏ hơn cho các nút */
                        }
                    }

                    /* Thêm media query cho các màn hình nhỏ hơn nữa (smartphone) */
                    @media (max-width: 480px) {
                        .circle-btn {
                            width: 50px;
                            /* Giảm kích thước nút hơn nữa trên màn hình nhỏ */
                            height: 50px;
                            font-size: 10px;
                        }

                        .menu-item {
                            width: 160px;
                            /* Thu nhỏ menu */
                            font-size: 12px;
                        }
                    }
                </style>
                <script>
                    $(document).ready(function() {
                        // Khi bấm vào nút dấu +
                        $("#main-button").click(function() {
                            // Toggle menu: Ẩn/hiện
                            $("#menu").toggleClass("hidden");
                        });

                        // Các hành động khi bấm vào các nút trong menu
                        $(".chat-btn").click(function() {
                            window.location.href = "{{ route('client.chat') }}";
                        });


                        // Khi bấm nút gửi chat
                        $("#send-chat").click(function() {
                            var message = $("#chat-input").val();
                            if (message.trim() !== "") {
                                $(".chat-body").append("<p><strong>Bạn:</strong> " + message + "</p>");
                                $("#chat-input").val(""); // Xóa input sau khi gửi
                                $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight); // Cuộn xuống dưới
                            }
                        });

                        $(".call-btn").click(function() {
                            window.location.href = "tel:0992224444"; // Số hotline
                        });

                        $(".address-btn").click(function() {
                            window.location.href = "{{ route('lienhe') }}";
                        });

                        $(".another-btn").click(function() {
                            window.location.href = "https://zalo.me/0363575163"; // Zalo của shop
                        });
                    });
                    document.getElementById("main-button").addEventListener("click", function() {
                        var menu = document.getElementById("menu");
                        if (menu.style.display === "none" || menu.style.display === "") {
                            menu.style.display = "flex"; // Hiển thị menu
                        } else {
                            menu.style.display = "none"; // Ẩn menu
                        }
                    });
                </script>

                <!-- Modal -->
                <div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog"
                    aria-labelledby="quickViewLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <div class="product-details">
                                    <div class="row">

                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <div class="modal_tab">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="tab1"
                                                        role="tabpanel">
                                                        <div class="modal_tab_img">
                                                            <a href="#"> <img id="productImage" src=""
                                                                    alt="Image"></a>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal_tab_button">
                                                    <ul class="nav product_navactive" role="tablist">

                                                        <li>
                                                            <a class="nav-link button_three" data-toggle="tab"
                                                                href="#tab3" role="tab" aria-controls="tab3"
                                                                aria-selected="false"><img id="productImage"
                                                                    src="" alt="Image"></a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h3><a href="" id="productName"></a></h3>
                                            <div class="product-info1">
                                                <p><span class="label">Thương hiệu:</span> <span id="productBrand"
                                                        class="value"></span></p>
                                                <p><span class="label">| Mã sản phẩm: </span><span
                                                        class="value">SP000</span><span id="productCode"
                                                        class="value"></span>
                                                </p>
                                                <p><span class="label">| Loại sản phẩm: </span><span
                                                        id="productCategory" class="value"></span>
                                                </p>
                                            </div>

                                            <p id="productPrice" class="price1">
                                                <span id="originalPrice"
                                                    style="text-decoration: line-through;"></span>
                                                <!-- Giá gốc, gạch ngang -->
                                                <span id="discountedPrice" class="discounted-price"></span>
                                                <!-- Giá giảm -->
                                                <span id="savings" class="savings"></span> <!-- Tiết kiệm -->
                                            </p>



                                            <div class="xemnhanh-mau">
                                                <label for="">Màu: <span
                                                        id="selectedColorName"></span></label>
                                                <div id="productColors"></div>

                                            </div>


                                            <div class="xemnhanh-kichthuoc">
                                                <label for="">Kích thước: <span
                                                        id="selectedSizeName"></span></label>
                                                <div id="productSizes"></div>
                                            </div>

                                            {{-- <script>
                                                const productColors = document.getElementById("productColors");
                                                colors.forEach(color => {
                                                    const button = document.createElement("button");
                                                    button.textContent = color.name;
                                                    button.classList.add("color-btn");
                                                    button.onclick = () => {
                                                        document.getElementById("selectedColorName").innerText = color.name;
                                                    };
                                                    productColors.appendChild(button);
                                                });

                                                // Hiển thị danh sách nút kích thước
                                                const productSizes = document.getElementById("productSizes");
                                                sizes.forEach(size => {
                                                    const button = document.createElement("button");
                                                    button.textContent = size.name;
                                                    button.classList.add("size-btn");
                                                    button.onclick = () => {
                                                        document.getElementById("selectedSizeName").innerText = size.name;
                                                    };
                                                    productSizes.appendChild(button);
                                                });
                                            </script> --}}

                                            <div class="box_quantity mb-20">
                                                <label>Số lượng</label>
                                                <div class="quantity-wrapper" style="border: 1px solid #D4D4D4">
                                                    <button type="button" class="quantity-btn1"
                                                        id="decreaseBtn">-</button>
                                                    <input min="1" max="100" value="1"
                                                        type="number" id="quantityInput" name="quantity" readonly>
                                                    <button type="button" class="quantity-btn1"
                                                        id="increaseBtn">+</button>
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

                                                    #originalPrice {
                                                        text-decoration: line-through;
                                                        /* Gạch ngang */
                                                        color: #888;
                                                        /* Màu xám cho giá gốc */
                                                        margin-right: 10px;
                                                        /* Khoảng cách giữa giá gốc và giá giảm */
                                                        font-size: 18px;
                                                        /* Kích thước chữ nhỏ hơn */
                                                    }

                                                    #discountedPrice {
                                                        color: #f54d4d;
                                                        /* Màu đỏ cho giá giảm */
                                                        font-size: 25px;
                                                        /* Kích thước chữ lớn hơn */
                                                        font-weight: bold;
                                                    }
                                                </style>
                                                <script>
                                                    // JavaScript
                                                    document.getElementById('increaseBtn').addEventListener('click', function() {
                                                        var quantityInput = document.getElementById('quantityInput');
                                                        var currentQuantity = parseInt(quantityInput.value);
                                                        var maxQuantity = parseInt(quantityInput.max);

                                                        if (currentQuantity < maxQuantity) {
                                                            quantityInput.value = currentQuantity + 1;
                                                        }
                                                    });

                                                    document.getElementById('decreaseBtn').addEventListener('click', function() {
                                                        var quantityInput = document.getElementById('quantityInput');
                                                        var currentQuantity = parseInt(quantityInput.value);
                                                        var minQuantity = parseInt(quantityInput.min);

                                                        if (currentQuantity > minQuantity) {
                                                            quantityInput.value = currentQuantity - 1;
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            <div class="button-container1">
                                                <button id="addToCart">THÊM VÀO GIỎ HÀNG</button>
                                                <a id="productDetailLink" class="xemchitiet">XEM CHI TIẾT SẢN PHẨM</a>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .product-info1 {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 10px;
                        margin-bottom: 20px;
                    }

                    .savings {
                        font-size: 14px;
                        color: green;
                        /* Màu cho chữ tiết kiệm */
                        margin-left: 10px;
                        font-weight: bold;
                    }

                    .product-info1 p {
                        margin: 0;
                    }

                    .product-info1 .label {
                        font-weight: bold;
                    }

                    .product-info1 .value {
                        color: #7aade4;
                    }

                    .xemchitiet {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        font-weight: bold;
                        color: #f3a30e;
                        border: 1px solid #f3a30e;
                        padding: 10px 0;
                        text-align: center;
                        text-decoration: none;
                        border-radius: 5px;
                        width: 50%;
                        margin: 0 auto;
                        transition: none;
                        /* Loại bỏ hiệu ứng chuyển động nếu có */
                    }

                    .xemchitiet:hover {
                        color: #f3a30e;
                        /* Giữ nguyên màu chữ khi hover */
                        background-color: transparent;
                        /* Giữ nguyên nền */
                        border-color: #f3a30e;
                        /* Giữ nguyên viền */
                    }



                    .price1 {
                        color: #f54d4d;
                        font-size: 25px;
                        font-weight: bold;
                    }

                    #productColors,
                    #productSizes {
                        margin-bottom: 10px;
                    }

                    #productName {
                        text-transform: uppercase;
                    }

                    #quantity {
                        width: 60px;
                        margin-right: 10px;
                    }

                    #addToCart,
                    #viewCart {
                        width: 50%;
                        font-weight: bold;
                        background-color: transparent;
                        color: black;
                    }

                    .modal-lg {
                        max-width: 75%;
                        /* Tăng chiều rộng modal */
                    }

                    .button-container1 {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                        margin-top: 15px;
                    }

                    .btn1 {
                        background-color: #007bff;
                        color: #fff;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        font-size: 14px;
                        padding: 0px 15px;
                        height: 30px;
                        line-height: 30px;
                        margin-bottom: 10px;
                        /* Thêm khoảng cách dưới mỗi nút */
                    }

                    #productColors,
                    #productSizes {
                        margin-bottom: 20px;
                        /* Thêm khoảng cách giữa nhóm các nút màu và kích thước */
                    }
                </style>

                <script>
                    // Hàm định dạng giá theo định dạng VND
                    function formatPrice(price) {
                        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '₫';
                    }

                    $(document).ready(function() {
                        var colorSizeData = {}; // Biến toàn cục để chứa dữ liệu màu sắc và kích thước

                        $('.quick-view-btn').on('click', function() {
                            var productId = $(this).data('id');

                            // Reset các lựa chọn (màu sắc, kích thước, số lượng) về mặc định
                            $('#selectedColorName').text('');
                            $('#selectedSizeName').text('');
                            $('#quantityInput').val(1);

                            $.ajax({
                                url: '/xemnhanh/' + productId,
                                method: 'GET',
                                success: function(response) {
                                    $('#productName').text(response.name);
                                    $('#productBrand').text(response.brand);
                                    $('#productCode').text(response.code);
                                    $('#productCategory').text(response.category);
                                    $('#productImage').attr('src', response.image);

                                    // Cập nhật giá
                                    if (response.price !== response.originalPrice) {
                                        $('#originalPrice').text(formatPrice(response
                                            .originalPrice)); // Giá gốc
                                        $('#discountedPrice').text(formatPrice(response.price)); // Giá giảm
                                        var savings = response.originalPrice - response
                                            .price; // Tiết kiệm được
                                        var discountPercentage = response.originalPrice > 0 ? Math.round((
                                            savings / response.originalPrice) * 100) : 0;
                                        $('#savings').text('Tiết kiệm ' + discountPercentage +
                                            '%'); // Hiển thị tiết kiệm
                                    } else {
                                        $('#originalPrice').text(
                                            ''); // Nếu không có giảm giá thì không hiển thị giá gốc
                                        $('#discountedPrice').text(formatPrice(response
                                            .price)); // Hiển thị giá giảm
                                        $('#savings').text(
                                            ''); // Không hiển thị tiết kiệm khi không có giảm giá
                                    }


                                    const productLink = `/san-pham/${response.slug}-${response.id}`;
                                    $('#productDetailLink').attr('href', productLink);
                                    $('#productName').attr('href',
                                        productLink); // Gán link cho href của thẻ <a>
                                    $('#productName').text(response
                                        .name); // Hiển thị tên sản phẩm trong thẻ <a>

                                    // Lưu dữ liệu màu sắc và kích thước vào biến toàn cục
                                    colorSizeData = response.colorSizeData;

                                    // Hiển thị các nút màu sắc
                                    var colorOptions = Object.keys(colorSizeData).map(function(color) {
                                        return '<button class="color-btn btn1 btn-outline-primary" data-color="' +
                                            color + '">' + color + '</button>';
                                    }).join(' ');
                                    $('#quickViewModal #productColors').html(colorOptions);

                                    // Hiển thị các nút kích thước cho màu đầu tiên
                                    var initialSizeOptions = colorSizeData[Object.keys(colorSizeData)[0]]
                                        .map(function(sizeData) {
                                            return '<button class="size-btn btn1 btn-outline-primary" data-size="' +
                                                sizeData.size + '">' + sizeData.size + ' (' + sizeData
                                                .description + ')</button>';
                                        }).join(' ');
                                    $('#quickViewModal #productSizes').html(initialSizeOptions);



                                },
                                error: function() {
                                    alert('Có lỗi xảy ra khi tải dữ liệu!');
                                }
                            });
                        });

                        $(document).on('click', '.color-btn', function() {
                            var colorName = $(this).data('color');
                            $('#selectedColorName').text(colorName);

                            // Cập nhật kích thước tương ứng với màu đã chọn
                            var sizeOptions = colorSizeData[colorName] ? colorSizeData[colorName].map(function(
                                sizeData) {
                                return '<button class="size-btn btn1 btn-outline-primary" data-size="' +
                                    sizeData.size + '">' + sizeData.size + ' (' + sizeData.description +
                                    ')</button>';
                            }).join(' ') : '';

                            $('#quickViewModal #productSizes').html(sizeOptions); // Cập nhật danh sách kích thước
                        });

                        $(document).on('click', '.size-btn', function() {
                            var sizeName = $(this).data('size');
                            $('#selectedSizeName').text(sizeName);
                        });
                    });
                </script>

                <script>
                    $(document).on('click', '#addToCart', function() {
                        const selectedColor = $('#selectedColorName').text();
                        const selectedSize = $('#selectedSizeName').text();
                        const quantity = parseInt($('#quantityInput').val());
                        const productId = $('#quickViewModal').data('product-id');

                        // Kiểm tra nếu người dùng chưa chọn màu sắc hoặc kích thước
                        if (!selectedColor || !selectedSize) {
                            alert('Vui lòng chọn màu sắc và kích thước.');
                            return;
                        }

                        // Kiểm tra số lượng sản phẩm
                        if (isNaN(quantity) || quantity < 1) {
                            alert('Vui lòng chọn số lượng hợp lệ.');
                            return;
                        }

                        // Gửi AJAX request tới controller
                        $.ajax({
                            url: '/them-vao-gio-hang',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                productId: productId,
                                color: selectedColor,
                                size: selectedSize,
                                quantity: quantity
                            },
                            success: function(res) {
                                alert(res.message);
                            },
                            error: function(xhr, status, error) {
                                console.log('Error Status: ' + status);
                                console.log('Error Message: ' + error);
                                console.log(xhr.responseText); // Để kiểm tra chi tiết lỗi
                                alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
                            }
                        });

                    });
                </script>


                <!-- all js here -->
                <script src="{{ asset('client/js/vendor/jquery-1.12.0.min.js') }}"></script>
                <script src="{{ asset('client/js/popper.js') }}"></script>
                <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>

                <script src="{{ asset('client/js/ajax-mail.js') }}"></script>
                <script src="{{ asset('client/js/plugins.js') }}"></script>

                <script src="{{ asset('client/js/main.js') }}"></script>
                <script src="{{ asset('client/js/main1.js') }}"></script>
            </div>
        </div>
    </div>
</body>

</html>
