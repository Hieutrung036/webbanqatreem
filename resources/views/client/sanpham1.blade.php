@extends('client.layout.master')

@section('title', $title)
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
                                    <li>{{ $danhMuc }}</li> <!-- Sử dụng biến danhMuc -->
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs area end-->

                <!--pos home section-->
                <div class=" pos_home_section">
                    <div class="row pos_home">
                        <div class="col-lg-3 col-md-12">
                            <!--layere categorie"-->
                            <div class="sidebar_widget shop_c">
                                <div class="categorie__titile">
                                    <h4>Danh mục sản phẩm</h4>
                                </div>
                                <div class="layere_categorie">
                                    <ul>
                                        @foreach ($loaisanphamgt as $lsp)
                                            <li>
                                                <!-- Sửa id của input để đảm bảo nó duy nhất -->
                                                <input type="checkbox" class="filter-checkbox"
                                                    data-idlsp="{{ $lsp->idlsp }}" id="acces-lsp-{{ $lsp->idlsp }}">
                                                <!-- Sửa for của label để trỏ đúng vào id của input -->
                                                <label for="acces-lsp-{{ $lsp->idlsp }}">{{ $lsp->ten }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>

                            <div class="sidebar_widget shop_c">
                                <div class="categorie__titile">
                                    <h4>Thương hiệu</h4>
                                </div>
                                <div class="layere_categorie">
                                    <ul>
                                        @foreach ($thuonghieu as $th)
                                            <li>
                                                <!-- Sửa id của input để đảm bảo nó duy nhất -->
                                                <input type="checkbox" class="filter-checkbox"
                                                    data-idth="{{ $th->idth }}" id="acces-th-{{ $th->idth }}">

                                                <!-- Sửa for của label để trỏ đúng vào id của input -->
                                                <label for="acces-th-{{ $th->idth }}">{{ $th->ten }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="sidebar_widget shop_c">
                                <div class="categorie__titile">
                                    <h4>Kích thước</h4>
                                </div>
                                <div class="layere_categorie">
                                    <ul>
                                        @foreach ($kichthuoc as $kt)
                                            <li>
                                                <!-- Sửa id của input để đảm bảo nó duy nhất -->
                                                <input type="checkbox" class="filter-checkbox"
                                                    data-idkt="{{ $kt->idkt }}" id="acces-kt-{{ $kt->idkt }}">

                                                <!-- Sửa for của label để trỏ đúng vào id của input -->
                                                <label for="acces-kt-{{ $kt->idkt }}">{{ $kt->ten }}
                                                    ({{ $kt->mota }})
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="sidebar_widget shop_c">
                                <div class="categorie__titile">
                                    <h4>Màu</h4>
                                </div>
                                <div class="layere_categorie">
                                    <ul>
                                        @foreach ($mau as $m)
                                            <li>
                                                <!-- Sửa id của input để đảm bảo nó duy nhất -->
                                                <input type="checkbox" class="filter-checkbox"
                                                    data-idm="{{ $m->idm }}" id="acces-m-{{ $m->idm }}">
                                                <!-- Sửa for của label để trỏ đúng vào id của input -->
                                                <label for="acces-m-{{ $m->idm }}">{{ $m->ten }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!--color area end-->

                             <!--price slider start-->
                             <div class="sidebar_widget shop_c">
                                <div class="categorie__titile">
                                    <h4>Mức giá</h4>
                                </div>
                                <div class="layere_categorie">
                                    <ul>
                                        <li>
                                            <!-- Checkbox cho giá dưới 100,000₫ -->
                                            <input type="checkbox" class="filter-checkbox" data-price-range="0,100000">
                                            <label>Giá dưới 100,000đ</label>
                                        </li>
                                        <li>
                                            <!-- Checkbox cho giá từ 100,000₫ - 200,000₫ -->
                                            <input type="checkbox" class="filter-checkbox" data-price-range="100000,200000">
                                            <label>100,000₫ - 200,000₫</label>
                                        </li>
                                        <li>
                                            <!-- Checkbox cho giá từ 300,000₫ - 400,000₫ -->
                                            <input type="checkbox" class="filter-checkbox" data-price-range="300000,400000">
                                            <label>300,000₫ - 400,000₫</label>
                                        </li>
                                        <li>
                                            <!-- Checkbox cho giá trên 500,000₫ -->
                                            <input type="checkbox" class="filter-checkbox" data-price-range="500000,999999999">
                                            <label>Giá trên 500,000₫</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!--price slider end-->
                        </div>


                        <div class="col-lg-9 col-md-12">
                            <!--banner slider start-->
                            <div class="banner_slider mb-35">
                                <img src="{{ $hinhbanner }}" alt="Banner">
                            </div>
                            <!--banner slider start-->

                            <!--shop toolbar start-->
                            <div class="shop_toolbar mb-35">

                                <div class="list_button">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#large" role="tab"
                                                aria-controls="large" aria-selected="true"><i
                                                    class="fa fa-th-large"></i></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#list" role="tab" aria-controls="list"
                                                aria-selected="false"><i class="fa fa-th-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                {{-- <div class="page_amount">
                                    <p>Hiển thị từ {{ $sanpham->firstItem() }}–{{ $sanpham->lastItem() }} của
                                        {{ $sanpham->total() }} kết quả</p>
                                </div> --}}


                                <div class="select_option">
                                    <label>Sắp xếp</label>
                                    <select name="orderby" id="short">
                                        <option value="newest">Mới nhất</option>
                                        <option value="oldest">Cũ nhất</option>
                                        <option value="price_asc">Giá: Thấp nhất</option>
                                        <option value="price_desc">Giá: Cao nhất</option>
                                        <option value="name_asc">Tên: A-Z</option>
                                        <option value="name_desc">Tên: Z-A</option>
                                    </select>
                                </div>
                            </div>
                            <!--shop toolbar end-->

                            <!--shop tab product-->
                            <div class="shop_tab_product">
                                <div class="tab-content" id="myTabContent">
                                    <!-- Grid View -->
                                    <div class="tab-pane fade show active" id="large" role="tabpanel">
                                        <div class="row" id="product-list-grid">
                                            @foreach ($sanpham as $sp)
                                                <div class="col-lg-4 col-md-6 product-item"
                                                    data-idlsp="{{ $sp->idlsp }}" data-idth="{{ $sp->idth }}"
                                                    data-idkt="{{ $sp->chitietsanpham->pluck('idkt')->implode(',') }}"
                                                    data-idm="{{ $sp->chitietsanpham->pluck('idm')->implode(',') }}" 
                                                    data-price="{{ $sp->gia }}">
                                                    <div class="single_product">
                                                        <div class="product_thumb">
                                                            <a
                                                                href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">
                                                                @foreach ($sp->hinhanh as $hinhanh)
                                                                    <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                        alt="không có hình ảnh" />
                                                                @endforeach
                                                            </a>
                                                            <div class="img_icone">
                                                                <!-- Nếu là trang "Sản phẩm nổi bật" -->
                                                                @if ($title == 'Sản phẩm nổi bật' && $sp->noibat == 1)
                                                                    <div class="img_icone">
                                                                        <img src="assets\img\cart\span-new.png"
                                                                            alt="">
                                                                    </div>
                                                                    <img src="{{ asset('client/img/cart/span-hot1.png') }}"
                                                                        alt="featured" />
                                                                    <!-- Nếu là trang "Sản phẩm mới" -->
                                                                @elseif ($title == 'Sản phẩm mới' && $sp->moi == 1)
                                                                    <img src="{{ asset('client/img/cart/span-new.png') }}"
                                                                        alt="new" />
                                                                @endif
                                                            </div>



                                                            
                                                        </div>

                                                        <div class="product_content">
                                                            <span style="display: flex; align-items: center;">
                                                                @if ($sp->giamgia->phantram > 0)
                                                                <span class="price-new" style="color: red; font-size: 20px; font-weight: bold; margin-right: 10px; padding-left: 50px">
                                                                    {{ number_format($sp->gia - ($sp->gia * $sp->giamgia->phantram) / 100) }} đ
                                                                </span>
                                                                    <span class="price-old" style="text-decoration: line-through; color: gray; font-size: 16px; margin-right: 10px;">
                                                                        {{ number_format($sp->gia) }} đ
                                                                    </span>
                                                                    
                                                                    
                                                                @else
                                                                    <span class="price-new" style="font-size: 20px; padding-left: 80px">
                                                                        {{ number_format($sp->gia) }} đ
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <h3 class="product_title">
                                                                <a
                                                                    href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">
                                                                    {{ $sp->ten }}
                                                                </a>
                                                            </h3>
                                                        </div>
                                                        <div class="product_info">
                                                            <ul>
                                                                <li><a href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}" title=" Mua ngay ">Mua ngay</a>
                                                                </li>
                                                                <li><a href="#" class="quick-view-btn" data-id="{{ $sp->idsp }}"
                                                                    data-toggle="modal" data-target="#quickViewModal">Xem nhanh</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- List View -->
                                    <div class="tab-pane fade" id="list" role="tabpanel">
                                        <div class="row" id="product-list-list">
                                            @foreach ($sanpham as $sp)
                                                <div class="product_list_item mb-35 product-item"
                                                    data-idlsp="{{ $sp->idlsp }}" data-id="{{ $sp->idsp }}"
                                                    data-idth="{{ $sp->idth }}"
                                                    data-idkt="{{ $sp->chitietsanpham->pluck('idkt')->implode(',') }}"
                                                    data-idm="{{ $sp->chitietsanpham->pluck('idm')->implode(',') }}"
                                                    data-price="{{ $sp->gia }}">

                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="product_thumb">
                                                                <a
                                                                    href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">
                                                                    @foreach ($sp->hinhanh as $hinhanh)
                                                                        <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}"
                                                                            alt="không có hình ảnh" />
                                                                    @endforeach
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-6 col-sm-6">
                                                            <div class="list_product_content">
                                                                <div class="product_ratting">
                                                                    <ul>
                                                                        <li><a href=""><i
                                                                                    class="fa fa-star"></i></a></li>
                                                                        <li><a href=""><i
                                                                                    class="fa fa-star"></i></a></li>
                                                                        <li><a href="#"><i
                                                                                    class="fa fa-star"></i></a></li>
                                                                        <li><a href="#"><i
                                                                                    class="fa fa-star"></i></a></li>
                                                                        <li><a href="#"><i
                                                                                    class="fa fa-star"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="list_title">
                                                                    <h3><a
                                                                            href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">{{ $sp->ten }}</a>
                                                                    </h3>
                                                                </div>
                                                                <p class="design">
                                                                    {{ \Illuminate\Support\Str::limit($sp->mota, 150, '...') }}
                                                                </p>
                                                                <p class="compare">
                                                                </p>
                                                                <div class="content_price">
                                                                    <span>
                                                                        @if ($sp->giamgia->phantram > 0)
                                                                        <span class="price-new" style="color: red; font-size: 20px; font-weight: bold; ">
                                                                            {{ number_format($sp->gia - ($sp->gia * $sp->giamgia->phantram) / 100) }} đ
                                                                        </span>
                                                                            <span class="price-old" style="text-decoration: line-through; color: gray; font-size: 16px; ">
                                                                                {{ number_format($sp->gia) }} đ
                                                                            </span>
                                                                            
                                                                            
                                                                        @else
                                                                            <span class="price-new" style="font-size: 20px;">
                                                                                {{ number_format($sp->gia) }} đ
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="add_links">
                                                                    <ul>
                                                                        <li><a href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}" title="Mua ngay"><i
                                                                                    class="fa fa-shopping-cart"
                                                                                    aria-hidden="true"></i></a></li>
                                                                        
                                                                       
                                                                                    <li><a href="#" class="quick-view-btn" data-id="{{ $sp->idsp }}"
                                                                                        data-toggle="modal" data-target="#quickViewModal"> <i class="fa fa-eye"
                                                                                        aria-hidden="true"></i></a></li>
                                                                                   
                                                                    </ul>
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


                            <!--shop tab product end-->

                            <!--pagination style start-->
                            <div class="pagination_style">
                                {{-- <div class="item_page">
                                    <form action="{{ request()->url() }}" method="GET"> <!-- Sử dụng URL hiện tại -->
                                        <label for="page_select">Hiển thị</label>
                                        <select id="page_select" name="per_page" onchange="this.form.submit()">
                                            <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6
                                            </option>
                                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12
                                            </option>
                                            <option value="18" {{ request('per_page') == 18 ? 'selected' : '' }}>18
                                            </option>
                                        </select>
                                        <span>kết quả trên trang</span>
                                    </form>
                                </div> --}}
                                <div class="page_number">
                                    <span>Trang: </span>
                                    <ul>
                                        <!-- Hiển thị nút quay lại -->
                                        <li>
                                            @if ($sanpham->onFirstPage())
                                                <span class="disabled">«</span>
                                            @else
                                                <a href="{{ $sanpham->previousPageUrl() }}">«</a>
                                            @endif
                                        </li>

                                        <!-- Hiển thị tất cả các số trang -->
                                        @for ($i = 1; $i <= $sanpham->lastPage(); $i++)
                                            <li>
                                                @if ($i == $sanpham->currentPage())
                                                    <span class="current_page">{{ $i }}</span>
                                                @else
                                                    <a href="{{ $sanpham->url($i) }}">{{ $i }}</a>
                                                @endif
                                            </li>
                                        @endfor

                                        <!-- Hiển thị nút tiếp theo -->
                                        <li>
                                            @if ($sanpham->hasMorePages())
                                                <a href="{{ $sanpham->nextPageUrl() }}">»</a>
                                            @else
                                                <span class="disabled">»</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>


                            </div>


                            <!--pagination style end-->
                        </div>
                    </div>
                </div>
                <!--pos home section end-->
            </div>
            <!--pos page inner end-->
        </div>
    </div>
@endsection
