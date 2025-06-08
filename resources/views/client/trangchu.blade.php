@extends('client.layout.master')

@section('title', 'Trang chủ')
@section('body')

    <div class="pos_home_section">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success"
                style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div id="error-popup" class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ rtrim($error, '.') }}</li> <!-- Xóa dấu chấm ở cuối -->
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div id="error-alert" class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <!--banner slider start-->
            <div class="col-12">
                <div class="banner_slider slider_two">
                    <div class="slider_active owl-carousel">
                        <div class="single_slider" style="background-image: url(client/img/slider/slider_2.png)">
                            <div class="slider_content">
                                <div class="slider_content_inner">
                                    <h1>THỜI TRANG TRẺ EM ĐA DẠNG</h1>
                                    <p>Có rất nhiều loại quần áo phù hợp với từng trẻ em từ nam tới nữ.</p>
                                    <a href="">Mua Ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="single_slider" style="background-image: url(client/img/slider/slide_4.png)">
                            <div class="slider_content">
                                <div class="slider_content_inner">
                                    <h1>THỜI TRANG TRẺ EM ĐA DẠNG</h1>
                                    <p>Có rất nhiều loại quần áo phù hợp với từng trẻ em từ nam tới nữ.</p>
                                    <a href="#">Mua Ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="single_slider" style="background-image: url(client/img/slider/slider_3.png)">
                            <div class="slider_content">
                                <div class="slider_content_inner">
                                    <h1>THỜI TRANG TRẺ EM ĐA DẠNG</h1>
                                    <p>Có rất nhiều loại quần áo phù hợp với từng trẻ em từ nam tới nữ.</p>
                                    <a href="#">Mua Ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--banner slider start-->
            </div>
        </div>

        <!--brand logo strat-->
        {{-- <div class="brand_logo brand_two">
            <div class="block_title">
                <h3>Bé gái</h3>
            </div>
            <div class="row">
                <div class="brand_active owl-carousel">
                    @foreach ($loaisanpham as $lsp)
                        @if ($lsp->gioitinh == 1 && $lsp->ten != 'Đồ bơi bé gái')
                            <!-- Điều kiện lọc giới tính -->
                            <div class="col-lg-2">
                                <div class="single_brand">
                                    <a href="{{ route('sanpham.be_gai.loai', $lsp->idlsp) }}"><img style="width:85px"
                                            class="img-hinh" src="{{ asset('uploads/loaisanpham/' . $lsp->hinhanh) }}"
                                            alt="Không có hình ảnh"></a>
                                </div>
                                <div class="title-brand"
                                    style="display:block; text-align: center; font-size: 15px; font-weight: bold">
                                    <a href="{{ route('sanpham.be_gai.loai', $lsp->idlsp) }}">{{ $lsp->ten }}</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <style>
                    img.img-hinh {
                        width: 85px;
                        height: 85px;
                        border-radius: 50%;
                        /* Tạo vòng tròn */
                        background-color: #CBEAFF;
                        /* Màu nền xanh */
                        object-fit: cover;
                        /* Giữ tỷ lệ ảnh khi cắt */
                    }
                </style>
            </div>
        </div>  --}}
        <!--brand logo end-->

        <!--brand logo strat-->
        {{-- <div class="brand_logo brand_two">
            <div class="block_title">
                <h3>Bé trai</h3>
            </div>
            <div class="row">
                <div class="brand_active owl-carousel">
                    @foreach ($loaisanpham as $lsp)
                        @if ($lsp->gioitinh == 0 && $lsp->ten != 'Đồ bơi bé trai')
                            <!-- Điều kiện lọc giới tính -->
                            <div class="col-lg-2">
                                <div class="single_brand">
                                    <a href="{{ route('sanpham.be_trai.loai', $lsp->ten) }}"><img style="width:85px"
                                            class="img-hinh" src="{{ asset('uploads/loaisanpham/' . $lsp->hinhanh) }}"
                                            alt="Không có hình ảnh"></a>
                                </div>
                                <div class="title-brand"
                                    style="display:block; text-align: center; font-size: 15px; font-weight: bold">
                                    <a href="{{ route('sanpham.be_trai.loai', $lsp->ten) }}">{{ $lsp->ten }}</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <style>
                    img.img-hinh {
                        width: 85px;
                        height: 85px;
                        border-radius: 50%;
                        /* Tạo vòng tròn */
                        background-color: #CBEAFF;
                        /* Màu nền xanh */
                        object-fit: cover;
                        /* Giữ tỷ lệ ảnh khi cắt */
                    }
                </style>
            </div>
        </div> --}}
        <!--brand logo end-->

        <!--new product area start-->
        <div class="new_product_area product_two">
            <div class="row">
                <div class="col-12">
                    <div class="block_title">
                        <h3> sản phẩm mới</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="single_p_active owl-carousel">
                    @foreach ($sanphamMoi as $sanpham)
                        <div class="col-lg-3">
                            <div class="single_product">
                                <div class="product_thumb">
                                    @foreach ($sanpham->hinhanh as $hinhanh)
                                        <a
                                            href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten) . '-' . $sanpham->idsp]) }}">
                                            <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                alt="khong co hinh anh" width="200px" />
                                        </a>
                                    @endforeach
                                    @if ($sanpham->moi)
                                        <div class="img_icone">
                                            <img src="client/img/cart/span-new.png" alt="Mới">
                                        </div>
                                    @endif
                                    
                                </div>
                                <div class="product_content">
                                    <span style="display: flex; align-items: center;">
                                        @if ($sanpham->giamgia->phantram > 0)
                                            <span class="price-new"
                                                style="color: red; font-size: 20px; font-weight: bold; margin-right: 10px; padding-left: 40px">
                                                {{ number_format($sanpham->gia - ($sanpham->gia * $sanpham->giamgia->phantram) / 100) }}
                                                đ
                                            </span>
                                            <span class="price-old"
                                                style="text-decoration: line-through; color: gray; font-size: 16px; margin-right: 10px;">
                                                {{ number_format($sanpham->gia) }} đ
                                            </span>
                                        @else
                                            <span class="price-new" style="font-size: 20px; padding-left: 80px">
                                                {{ number_format($sanpham->gia) }} đ
                                            </span>
                                        @endif
                                    </span>



                                    <h3 class="product_title">
                                        <a
                                            href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten) . '-' . $sanpham->idsp]) }}">
                                            {{ $sanpham->ten }}
                                        </a>
                                    </h3>
                                </div>
                                <div class="product_info">
                                    <ul>
                                        <li><a href="" title="Yêu thích">Yêu thích</a></li>

                                        <li>
                                            <a href="#" class="quick-view-btn" data-id="{{ $sanpham->idsp }}"
                                                data-toggle="modal" data-target="#quickViewModal">Xem nhanh</a>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
        <!--new product area start-->

        <!--banner area start-->
        <div class="banner_area banner_two">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_banner">
                        <a href="#"><img src="{{ asset('client/img/banner/banner1.png') }}" alt=""></a>
                        <div class="banner_title">
                            <p>Lên đến <span> 40%</span> off</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_banner">
                        <a href="#"><img src="{{ asset('client/img/banner/banner2.jpg') }}" alt=""></a>
                        <div class="banner_title title_2">
                            <p>Giảm tới <span> 30%</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_banner">
                        <a href="#"><img src="{{ asset('client/img/banner/banner3.jpg') }}" alt=""></a>
                        <div class="banner_title title_3">
                            <p>Giảm tới <span> 30%</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--banner area end-->

        <!--featured product area start-->
        <div class="new_product_area product_two">
            <div class="row">
                <div class="col-12">
                    <div class="block_title">
                        <h3> Sản phẩm nổi bật</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="single_p_active owl-carousel">
                    @foreach ($sanphamNoiBat as $sanpham)
                        <div class="col-lg-3">
                            <div class="single_product">
                                <div class="product_thumb">
                                    @foreach ($sanpham->hinhanh as $hinhanh)
                                        <a
                                            href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten) . '-' . $sanpham->idsp]) }}">
                                            <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                alt="khong co hinh anh" width="200px" />
                                        </a>
                                    @endforeach

                                    @if ($sanpham->noibat)
                                        <div class="hot_img">
                                            <img src="client/img/cart/span-hot.png" alt="Mới">
                                        </div>
                                    @endif
                                    
                                </div>
                                <div class="product_content">
                                    <span style="display: flex; align-items: center;">
                                        @if ($sanpham->giamgia->phantram > 0)
                                            <span class="price-new"
                                                style="color: red; font-size: 20px; font-weight: bold; margin-right: 10px; padding-left: 45px">
                                                {{ number_format($sanpham->gia - ($sanpham->gia * $sanpham->giamgia->phantram) / 100) }}
                                                đ
                                            </span>
                                            <span class="price-old"
                                                style="text-decoration: line-through; color: gray; font-size: 16px; margin-right: 10px;">
                                                {{ number_format($sanpham->gia) }} đ
                                            </span>
                                        @else
                                            <span class="price-new" style="font-size: 20px; padding-left: 80px">
                                                {{ number_format($sanpham->gia) }} đ
                                            </span>
                                        @endif
                                    </span>
                                    <h3 class="product_title">
                                        <a
                                            href="{{ route('chitietsanpham', ['slug' => Str::slug($sanpham->ten) . '-' . $sanpham->idsp]) }}">
                                            {{ $sanpham->ten }}
                                        </a>
                                    </h3>
                                </div>
                                <div class="product_info">
                                    <ul>
                                        <li><a href="" title="Yêu thích">Yêu thích</a></li>
                                        <li>
                                            <a href="#" class="quick-view-btn" data-id="{{ $sanpham->idsp }}"
                                                data-toggle="modal" data-target="#quickViewModal">Xem nhanh</a>

                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>


        <div class="benefit-items">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="client/img/icon-1.png" alt="khong co hinh anh" />
                        </div>
                        <div class="sb-text">
                            <h6>Miễn phí vận chuyển</h6>
                            <p>Đơn tối thiểu 500.000 vnđ</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="client/img/icon-2.png" alt="khong co hinh anh" />
                        </div>
                        <div class="sb-text">
                            <h6>Phân phối</h6>
                            <p>Toàn quốc</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="client/img/icon-3.png" alt="khong co hinh anh" />
                        </div>
                        <div class="sb-text">
                            <h6>Thanh toán an toàn</h6>
                            <p>Đa dạng hình thức thanh toán</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog_area blog_two">
            <div class="row">
                <div class="blog_active owl-carousel">
                    @foreach ($tintuc as $tt)
                        <div class="col-lg-4">
                            <div class="single_blog">
                                <div class="blog_thumb1">
                                    <a
                                        href="{{ route('chitiettintuc', ['ten' => Str::slug($tt->loaitintuc->ten, '-'), 'tieude' => Str::slug($tt->tieude, '-')]) }}">
                                        <img src="{{ asset('uploads/tintuc/' . $tt->hinhanh) }}"
                                            alt="{{ $tt->tieude }}">
                                    </a>
                                </div>
                                <div class="blog_content">
                                    <div class="blog_post">
                                        <ul>
                                            <li><a
                                                    href="{{ route('tintuc.type', ['ten' => Str::slug($tt->loaitintuc->ten, '-')]) }}">{{ $tt->loaitintuc->ten }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <h3>
                                        <a
                                            href="{{ route('chitiettintuc', ['ten' => Str::slug($tt->loaitintuc->ten, '-'), 'tieude' => Str::slug($tt->tieude, '-')]) }}">
                                            {{ $tt->tieude }}
                                        </a>
                                    </h3>
                                    <p>{{ Str::limit($tt->noidung, 100, '...') }}</p>
                                    <div class="post_footer">
                                        <div class="post_meta">
                                            <ul>
                                                <li>{{ \Carbon\Carbon::parse($tt->ngaydang)->translatedFormat('d \\T\\há\\n\\g m, Y') }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="Read_more">
                                            <a
                                                href="{{ route('chitiettintuc', ['ten' => Str::slug($tt->loaitintuc->ten, '-'), 'tieude' => Str::slug($tt->tieude, '-')]) }}">
                                                Xem thêm <i class="fa fa-angle-double-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>




       




    </div>

@endsection
