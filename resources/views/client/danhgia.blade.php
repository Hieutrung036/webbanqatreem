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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <div class="leave-comment">
                            <h4>ĐÁNH GIÁ SẢN PHẨM</h4>
                            <form action="{{route('danhgia.them')}}" class="comment-form" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="idctsp">Chọn chi tiết đơn hàng:</label>
                                        @if ($chitiethoadon && $chitiethoadon->isNotEmpty())
                                            <select class="form-control" name="idctsp" id="idctsp">
                                                @foreach ($chitiethoadon as $cthd)
                                                    @foreach ($cthd->chitietsanpham as $chitietsanpham)
                                                        <option value="{{ $chitietsanpham->idctsp }}">
                                                            {{ $chitietsanpham->sanpham->ten }} -
                                                            (Màu: {{ $chitietsanpham->mau->ten }}, Size:
                                                            {{ $chitietsanpham->kichthuoc->ten }})
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        @else
                                            <p>Không có chi tiết đơn hàng.</p>
                                        @endif
                                    </div>
        
                                    <div class="col-md-6">
                                        <label for="rating">Chọn số sao:</label>
                                        <select class="form-control" name="sosao" id="sosao">
                                            <option value="">-- Chọn số sao --</option>
                                            <option value="5">5 sao</option>
                                            <option value="4">4 sao</option>
                                            <option value="3">3 sao</option>
                                            <option value="2">2 sao</option>
                                            <option value="1">1 sao</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-lg-12">
                                        <textarea name="Noidung" placeholder="Nội dung"></textarea>
                                        <button type="submit" class="site-btn">Gửi</button>
                                    </div>
                                    <div>&nbsp;</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

@endsection
