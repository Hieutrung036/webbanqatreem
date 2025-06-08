@extends('client.layout.master')

@section('title', 'Liên hệ')
@section('body')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('trangchu') }}">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>Liên hệ</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--contact area start-->
    <div class="contact_area">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="contact_message">
                    <h3>LIÊN HỆ CHÚNG TÔI</h3>
                    <form id="contact-form" method="POST" action="assets/mail.php">
                        <div class="row">
                            <div class="col-lg-4">
                                <input name="name" placeholder="Họ và tên *" type="text">
                            </div>
                            <div class="col-lg-4">
                                <input name="email" placeholder="Email *" type="email">
                            </div>

                            <div class="col-lg-4">
                                <input name="phone" placeholder="Số điện thoại *" type="text">
                            </div>

                            <div class="col-12">
                                <div class="contact_textarea">
                                    <textarea placeholder="Nội dung *" name="message" class="form-control2"></textarea>
                                </div>
                                <button type="submit"> Gửi </button>
                            </div>
                            <div class="col-12">
                                <p class="form-messege">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="contact_message contact_info">
                    <h3>THÔNG TIN LIÊN LẠC</h3>

                    <ul>
                        <li><i class="fa fa-fax"></i> Địa chỉ : 180 Cao Lỗ, Phường 8, Quận 8</li>
                        <li><i class="fa fa-phone"></i> <a href="tel:013193819">(099) 313 222 4444</a></li>
                        <li><i class="fa fa-envelope-o"></i> DH51903588@stu.edu.vn</li>
                    </ul>
                    <h3><strong>GIỜ LÀM VIỆC</strong></h3>
                    <p><strong>Thứ 2 – Thứ 7</strong>: 08 giờ sáng – 22 giờ tối</p>
                </div>
            </div>
        </div>
    </div>

    <!--contact area end-->

    <!--contact map start-->
    <div class="contact_map">
        <div class="row">
            <div class="col-12">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62719.27112751139!2d106.63663223024187!3d10.737994488420979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f62a90e5dbd%3A0x674d5126513db295!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgU8OgaSBHw7Ju!5e0!3m2!1svi!2s!4v1729010824852!5m2!1svi!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <!--contact map end-->
@endsection
