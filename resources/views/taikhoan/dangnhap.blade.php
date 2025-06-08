@extends('client.layout.master')

@section('title', 'Đăng nhập')
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
                        <li>Đăng nhập</li>
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
            <div class="col-lg-6 col-md-6">
                <div class="account_form">
                    <h2>Đăng nhập</h2>
                    <form action="{{ route('dangnhap.submit') }}" method="POST">
                        @csrf <!-- Thêm CSRF token để bảo vệ form -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
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
                        <!-- Email -->
                        <p>
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required>

                        </p>
                        <!-- Mật khẩu -->
                        <p>
                            <label>Mật khẩu <span>*</span></label>
                            <input type="password" name="password" required>

                        </p>
                        <!-- Ghi nhớ tài khoản -->
                        <div class="login_submit">

                            <label for="remember">
                                <input id="remember" type="checkbox" name="remember">
                                Lưu mật khẩu
                            </label>
                            <a href="{{ route('quenmatkhau') }}">Quên mật khẩu?</a>
                        </div>
                        <div class="login_submit">
                            <button type="submit">Đăng nhập</button>

                        </div>
                        <p class="create_account">Bạn chưa có tài khoản? <a href="{{ route('dangky') }}">Tạo tài khoản</a>
                        </p>
                    </form>
                </div>
            </div>
            <!--login area start-->


        </div>
    </div>
    <!-- customer login end -->


@endsection
