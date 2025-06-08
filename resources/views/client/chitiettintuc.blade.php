@extends('client.layout.master')

@section('title', $tintuc->tieude) <!-- Hiển thị tên sản phẩm trên title -->
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
                                        {{ $tintuc->tieude }}
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="main_blog_area blog_details">
                    <div class="row">
                        <div class="col-lg-12 col-md-14">
                            <div class="blog_details_left">
                                <div class="blog_gallery">
                                    <div class="blog_header">

                                        <h2><a href="#">{{ $tintuc->tieude }}</a></h2>
                                        <div class="blog__post">
                                            <ul>
                                                <li class="post_author">Đăng bởi : Nhân viên</li>
                                                <li class="post_date">
                                                    {{ \Carbon\Carbon::parse($tintuc->ngaydang)->format('d \T\h\á\n\g m, Y') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="blog_active1 ">

                                        <div class="blog_thumb">
                                            <img src="{{ asset('uploads/tintuc/' . $tintuc->hinhanh) }}"
                                                alt="{{ $tintuc->tieude }}" style="max-width: 100%; height: auto;">
                                        </div>

                                    </div>

                                    <div class="" style="text-align: justify;">
                                        <p>{!! $tintuc->noidung !!}</p>
                                    </div>
                                    <div class="blog_entry_meta">
                                        <ul>
                                            
                                        </ul>
                                    </div>
                                    <div class="wishlist-share">
                                        <h4>Trang xã hội:</h4>
                                        <ul>
                                            <li><a href="https://www.youtube.com/"><i class="fa-brands fa-youtube"></i></a></li>
                                            <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a></li>
                                            <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!--services img area-->
                                <div class="srrvices_img_area">
                                    <div class="row">
                                        @foreach ($tinTucLienQuan as $ttlq)
                                            <div class="col-lg-4">
                                                <div class="single_img_services mb-20">
                                                    <div class="services_thumb">
                                                        <a href="{{ route('chitiettintuc', ['ten' => Str::slug($ttlq->loaitintuc->ten, '-'), 'tieude' => Str::slug($ttlq->tieude, '-')]) }}">
                                                            <!-- Thay đổi link đến chi tiết tin tức -->
                                                            <img src="{{ asset('uploads/tintuc/' . $ttlq->hinhanh) }}"
                                                                 alt="{{ $ttlq->tieude }} " style="max-width: 80%;">
                                                            <!-- Giả sử bạn có trường image -->
                                                        </a>
                                                    </div>
                                                    <div class="services_content">
                                                        <h3>
                                                            <a href="{{ route('chitiettintuc', ['ten' => Str::slug($ttlq->loaitintuc->ten, '-'), 'tieude' => Str::slug($ttlq->tieude, '-')]) }}">
                                                                {{ $ttlq->tieude }}
                                                            </a>
                                                        </h3> <!-- Hiển thị tiêu đề tin tức -->
                                                        <div class="tweetlink favorite">
                                                            <a href="#">
                                                                {{ \Carbon\Carbon::parse($ttlq->ngaydang)->format('d \T\h\á\n\g m, Y') }}
                                                            </a>
                                                            <!-- Ngày đăng -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                

                                <!--services img end-->

                                

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <!--pos page end-->
@endsection
