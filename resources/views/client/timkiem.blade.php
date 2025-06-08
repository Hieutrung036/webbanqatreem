@extends('client.layout.master')

@section('title', 'Kết quả tìm kiếm') <!-- Hiển thị tên sản phẩm trên title -->

@section('body')
    <div class="pos_page">
        <div class="container">
            <div class="pos_page_inner">
                <!--breadcrumbs area start-->
                <div class="breadcrumbs_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb_content">
                                <ul>
                                    <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                                    <li><i class="fa fa-angle-right"></i></li>
                                    <li>Kết quả tìm kiếm</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs area end-->

                <!--search result section start-->
                <div class="pos_home_section">
                    <div class="row">
                        <!-- Kết quả tìm kiếm -->
                        <div class="col-12">
                            <h6 class="search_title">Kết quả tìm kiếm cho: "{{ $keyword }}"</h6>
                            @if ($sanpham->isEmpty())
                                <p class="no_result">Không tìm thấy sản phẩm nào khớp với từ khóa "{{ $keyword }}"</p>
                            @else
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
                                                                <a href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">
                                                                    @foreach ($sp->hinhanh as $hinhanh)
                                                                        <img src="{{ asset('uploads/sanpham/' . $hinhanh->duongdan) }}" alt="không có hình ảnh" />
                                                                    @endforeach
                                                                </a>
                                                                <div class="product_action">
                                                                    <a href="#"> <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                                                </div>
                                                            </div>
                                                            <div class="product_content">
                                                                <span>
                                                                    @if ($sp->giamgia->phantram > 0)
                                                                        {{ number_format($sp->gia - ($sp->gia * $sp->giamgia->phantram) / 100) }}
                                                                        đ
                                                                    @else
                                                                        {{ number_format($sp->gia) }} đ
                                                                    @endif
                                                                </span>
                                                                <h3 class="product_title">
                                                                    <a href="{{ route('chitietsanpham', ['slug' => Str::slug($sp->ten, '-') . '-' . $sp->idsp]) }}">
                                                                        {{ $sp->ten }}
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <div class="product_info">
                                                                <ul>
                                                                    <li><a href="#" title="Thêm yêu thích">Yêu thích</a></li>
                                                                    <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Xem nhanh">Xem nhanh</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Phân trang -->
                <div class="pagination_area">
                    {{ $sanpham->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
