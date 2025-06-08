@extends('client.layout.master')

@section('title', 'Quên mật khẩu')
@section('body')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>Quên mật khẩu</li>
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
                    <h2>Quên mật khẩu</h2>
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form action="{{ route('xulyQuenMatKhau') }}" method="POST">
                        @csrf
                        <p>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        </p>
                        <p>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <div class="login_submit">
                            <button type="submit">Gửi</button>
                        </div>
                        <p class="create_account">Bạn đã có tài khoản? <a href="{{ route('dangnhap') }}">Đăng nhập</a></p>
                    </form>
                </div>
            </div>
            <!--login area start-->

            <!--register area start-->
            {{-- <div class="col-lg-6 col-md-6">
                <div class="account_form register">
                    <h2>Register</h2>
                    <form action="#">
                        <p>
                            <label>Email address <span>*</span></label>
                            <input type="text">
                        </p>
                        <p>
                            <label>Passwords <span>*</span></label>
                            <input type="password">
                        </p>
                        <div class="login_submit">
                            <button type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div> --}}
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
