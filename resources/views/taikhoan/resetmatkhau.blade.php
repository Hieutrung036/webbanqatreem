@extends('client.layout.master')

@section('title', 'Phục hồi mật khẩu')
@section('body')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>Phục hồi mật khẩu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="customer_login">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="account_form">
                    <h2>Phục hồi mật khẩu</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('resetPassword') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}"> <!-- Trường email ẩn -->
                        <p>
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" id="password" name="password" required>
                        </p>
                        <p>
                            <label for="password_confirmation">Nhập lại mật khẩu</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </p>
                        <div class="login_submit">
                            <button type="submit">Xác nhận</button>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
@endsection
