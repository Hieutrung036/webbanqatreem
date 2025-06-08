@extends('client.layout.master')

@section('title', $title)

@section('body')
    <div class="pos_page">
        <div class="container">
            <div class="pos_page_inner">
                <div class="breadcrumbs_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="breadcrumb_content">
                                <ul>
                                    <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                                    <li><i class="fa fa-angle-right"></i></li>
                                    <li>{{ $danhmuc }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog_area">
                    <div class="row">
                        @if ($tintuc->isEmpty())
                            <div class="no-tin-tuc">
                                <p>Không có tin tức nào cho loại này.</p>
                            </div>
                        @else
                            @foreach ($tintuc as $tin)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single_blog">

                                        <div class="blog_thumb1">
                                            <a
                                                href="{{ route('chitiettintuc', ['ten' => Str::slug($tin->loaitintuc->ten, '-'), 'tieude' => Str::slug($tin->tieude, '-')]) }}"><img
                                                    src="{{ asset('uploads/tintuc/' . $tin->hinhanh) }}"
                                                    alt="Không có hình ảnh"></a>
                                        </div>
                                        <div class="blog_content">
                                            <div class="blog_post">
                                                <ul>
                                                    <li><a href="#">{{ $tin->loaitintuc->ten }}</a></li>
                                                </ul>
                                            </div>
                                            <h3>
                                                <a
                                                    href="{{ route('chitiettintuc', ['ten' => Str::slug($tin->loaitintuc->ten, '-'), 'tieude' => Str::slug($tin->tieude, '-')]) }}">
                                                    {{ $tin->tieude }}
                                                </a>
                                            </h3>

                                            <p>{{ Str::limit($tin->noidung, 100, '...') }}</p>
                                            <div class="post_footer">
                                                <div class="post_meta">
                                                    <ul>
                                                        <li>{{ \Carbon\Carbon::parse($tin->ngaydang)->format('d \T\h\á\n\g m, Y') }}
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="Read_more">
                                                    <a
                                                        href="{{ route('chitiettintuc', ['ten' => Str::slug($tin->loaitintuc->ten, '-'), 'tieude' => Str::slug($tin->tieude, '-')]) }}">Xem
                                                        thêm <i class="fa fa-angle-double-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="blog_pagination">
                    <div class="row">
                        <div class="col-12">
                            <div class="page_number">
                                <span>Trang: </span>
                                <ul>
                                    @if ($tintuc->currentPage() > 1)
                                        <li><a href="{{ $tintuc->previousPageUrl() }}">«</a></li>
                                    @endif
                                    <li class="current_number">{{ $tintuc->currentPage() }}</li>
                                    @if ($tintuc->hasMorePages())
                                        <li><a href="{{ $tintuc->nextPageUrl() }}">»</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
