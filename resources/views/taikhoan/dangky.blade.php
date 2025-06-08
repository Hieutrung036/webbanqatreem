@extends('client.layout.master')

@section('title', 'Đăng ký')
@section('body')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
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
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>Đăng ký</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="customer_login">
        <div class="row">
            <!--login area start-->

            <!--login area start-->

            <!--register area start-->
            <div class="col-lg-6 col-md-6">
                <div class="account_form register">
                    <h2>Tạo tài khoản</h2>
                    <form action="{{ route('dangky.submit') }}" method="POST">
                        @csrf <!-- Thêm CSRF token để bảo vệ form -->
                        <!-- Hiển thị lỗi nếu có -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <p>
                            <label>Tên người dùng <span>*</span></label>
                            <input type="text" name="ten" value="{{ old('ten') }}" required>
                        </p>
                        <p>
                            <label>Số điện thoại <span>*</span></label>
                            <input type="tel" name="sdt" value="{{ old('sdt') }}" required>
                        </p>
                        <p>
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required>
                        </p>
                        <p>
                            <label>Mật khẩu <span>*</span></label>
                            <input type="password" name="matkhau" required>
                        </p>
                        <p>
                            <label>Xác nhận lại mật khẩu <span>*</span></label>
                            <input type="password" name="matkhau_confirmation" required>
                        </p>
                        <div class="login_submit">
                            <button type="submit">Đăng ký</button>
                            <a href="{{ route('dangnhap') }}">Đã có tài khoản</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--register area end-->
        </div>
    </div>
    <!-- customer login end -->

    </div>
    <!--pos page inner end-->
    </div>
    </div>
    <!--pos page end-->
@endsection
