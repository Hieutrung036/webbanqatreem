@extends('client.layout.master')

@section('title', 'Giới thiệu')
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
                                        Giới thiệu
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs area end-->
                <!--about section area -->
                <div class="about_section">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="about_thumb">
                                <img src="client\img\gioithieu.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="about_content">
                                <h1>NIZI SHOP <br>CỬA HÀNG QUẦN ÁO TRẺ EM</h1>
                                <p>Tại NIZI SHOP, chúng tôi cung cấp một bộ sưu tập đa dạng các mẫu quần áo trẻ em, từ những bộ đồ chơi đến trang phục đi học, tất cả đều được thiết kế với sự chú ý đến chất liệu và kiểu dáng. Sản phẩm của chúng tôi không chỉ đẹp mắt mà còn thoải mái và an toàn cho làn da nhạy cảm của trẻ nhỏ.. </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!--about section end-->


                <!--counterup area -->
                <div class="counterup_section">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single_counterup">
                                <div class="counter_img">
                                    <img src="client\img\cart\count.png" alt="">
                                </div>
                                <div class="counter_info">
                                    <h2 class="counter_number">100</h2>
                                    <p>Khách hàng hài lòng</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single_counterup count-two">
                                <div class="counter_img">
                                    <img src="client\img\cart\count2.png" alt="">
                                </div>
                                <div class="counter_info">
                                    <h2 class="counter_number">15</h2>
                                    <p>Sản phẩm đã được bán</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single_counterup">
                                <div class="counter_img">
                                    <img src="client\img\cart\count3.png" alt="">
                                </div>
                                <div class="counter_info">
                                    <h2 class="counter_number">200</h2>
                                    <p>Giờ chăm sóc khách hàng</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single_counterup count-two">
                                <div class="counter_img">
                                    <img src="client\img\cart\cart5.png" alt="">
                                </div>
                                <div class="counter_info">
                                    <h2 class="counter_number">500</h2>
                                    <p>Đơn hàng đã hoàn tất</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--counterup end-->

              

              
            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <!--pos page end-->
@endsection
