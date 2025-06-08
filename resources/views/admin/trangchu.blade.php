@extends('admin.layout.indexmain')
@section('title', 'Trang chủ')

@section('body')
    <h1 style="font-size: 20px">TRANG CHỦ</h1>


    @if (Auth::guard('nhanvien')->check())
        @php
            $chucvu = Auth::guard('nhanvien')->user()->chucvu;
        @endphp

        <h4>XIN CHÀO:
            @if ($chucvu == 'Nhân viên kho')
                NHÂN VIÊN KHO
            @elseif($chucvu == 'Nhân viên bán hàng')
                NHÂN VIÊN BÁN HÀNG
            @endif
        </h4>
    @elseif (Auth::guard('admin')->check())
        <h4>XIN CHÀO: QUẢN TRỊ VIÊN </h4>
    @endif




@endsection


@section('search')
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
@endsection
