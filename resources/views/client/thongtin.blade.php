@extends('client.layout.master')
@section('title', 'Thông tin')
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
                                        Thông tin tài khoản
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div id="success-alert" class="alert alert-success"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div id="error-popup" class="alert alert-danger"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ rtrim($error, '.') }}</li> <!-- Xóa dấu chấm ở cuối -->
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div id="error-alert" class="alert alert-danger"
                        style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
                        {{ session('error') }}
                    </div>
                @endif

                <section class="main_content_area">
                    <div class="account_dashboard">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <!-- Nav tabs -->
                                <div class="dashboard_tab_button">
                                    <ul role="tablist" class="nav flex-column dashboard-list">
                                        <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Thông tin cá
                                                nhân</a></li>
                                        <li> <a href="#orders" data-toggle="tab" class="nav-link">Lịch sử mua hàng</a></li>
                                        <li><a href="#address" data-toggle="tab" class="nav-link">Danh sách địa chỉ</a></li>

                                        <li><a href="{{ route('dangxuat') }}" class="nav-link">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-9 col-lg-9">
                                <!-- Tab panes -->
                                <div class="tab-content dashboard_content">
                                    <div class="tab-pane fade show active" id="dashboard">
                                        <h3>Thông tin cá nhân</h3>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="font-size: 1.2em;">Tên khách hàng</th>
                                                    <td style="font-size: 1.2em;">
                                                        {{ $khachhang->ten }}
                                                        <a href="#" class="text-primary ml-2" data-toggle="modal"
                                                            data-target="#updateNameModal"
                                                            style="cursor: pointer; text-decoration: none; font-weight: bold;">Thay
                                                            đổi</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 1.2em;">Email</th>
                                                    <td style="font-size: 1.2em;">
                                                        {{ $khachhang->email }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 1.2em;">Số điện thoại</th>
                                                    <td style="font-size: 1.2em;">
                                                        0{{ $khachhang->sdt }}
                                                        <a href="#" class="text-primary ml-2" data-toggle="modal"
                                                            data-target="#updatePhoneModal"
                                                            style="cursor: pointer; text-decoration: none; font-weight: bold;">Thay
                                                            đổi</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 1.2em;">Mật khẩu</th>
                                                    <td style="font-size: 1.2em;">
                                                        **********
                                                        <a href="#" class="text-primary ml-2" data-toggle="modal"
                                                            data-target="#updatePasswordModal"
                                                            style="cursor: pointer; text-decoration: none; font-weight: bold;">Thay
                                                            đổi</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Modal cập nhật tên -->
                                        <div class="modal fade" id="updateNameModal" tabindex="-1" role="dialog"
                                            aria-labelledby="updateNameModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateNameModalLabel">Cập nhật tên</h5>
                                                    </div>
                                                    <form action="{{ route('capnhat.ten', ['idkh' => $khachhang->idkh]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group row align-items-center">
                                                                <label for="ten"
                                                                    class="col-sm-3 col-form-label">Tên</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="ten" name="ten"
                                                                        value="{{ $khachhang->ten }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="nutdong"
                                                                data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="nutthaydoi">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal cập nhật số điện thoại -->
                                        <div class="modal fade" id="updatePhoneModal" tabindex="-1" role="dialog"
                                            aria-labelledby="updatePhoneModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updatePhoneModalLabel">Cập nhật số
                                                            điện thoại</h5>
                                                    </div>
                                                    <form
                                                        action="{{ route('capnhat.sdt', ['idkh' => $khachhang->idkh]) }}"
                                                        method="POST">

                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group row align-items-center">
                                                                <label for="sdt" class="col-sm-3 col-form-label">Số
                                                                    điện thoại</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="sdt" name="sdt"
                                                                        value="0{{ $khachhang->sdt }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="nutdong"
                                                                data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="nutthaydoi">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal cập nhật mật khẩu -->
                                        <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog"
                                            aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updatePasswordModalLabel">Cập nhật mật
                                                            khẩu</h5>
                                                    </div>
                                                    <form
                                                        action="{{ route('capnhat.matkhau', ['idkh' => $khachhang->idkh]) }}"
                                                        method="POST">

                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group row align-items-center">
                                                                <label for="matkhau_cu"
                                                                    class="col-sm-3 col-form-label">Mật khẩu cũ</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"
                                                                        id="matkhau_cu" name="matkhau_cu" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label for="matkhau_moi"
                                                                    class="col-sm-3 col-form-label">Mật khẩu mới</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"
                                                                        id="matkhau_moi" name="matkhau_moi" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label for="matkhau_moi_confirmation"
                                                                    class="col-sm-3 col-form-label">Nhập lại</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"
                                                                        id="matkhau_moi_confirmation"
                                                                        name="matkhau_moi_confirmation" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="nutdong"
                                                                data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="nutthaydoi">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="orders">
                                        <h3>Lịch sử mua hàng</h3>
                                        @if ($hoadon->isEmpty())
                                            <p>Không có đơn hàng nào.</p>
                                        @else
                                            <div class="coron_table table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ngày đặt</th>
                                                            <th>Ngày nhận</th>
                                                            <th>Thanh toán</th>
                                                            <th>Trạng thái</th>
                                                            <th>Tổng tiền</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($hoadon as $hd)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <!-- Dữ liệu ngày bạn có thể thay đổi nếu cần -->
                                                                <td>{{ \Carbon\Carbon::parse($hd->ngaydathang)->format('d-m-Y') }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($hd->ngaynhanhang)->format('d-m-Y') }}
                                                                </td>
                                                                <td>{{ $hd->phuongthucthanhtoan->ten }} </td>
                                                                <td>{{ $hd->trangthaidonhang->ten }}</td>

                                                                <td>{{ number_format($hd->tongtien, 0, ',', ',') }}
                                                                    ₫</td>


                                                                <!-- Nút Xem để mở Modal -->
                                                                <td> <button type="button" class="nutthaydoi"
                                                                        data-toggle="modal"
                                                                        data-target="#show-{{ $hd->idhd }}">Xem</button>
                                                                </td>

                                                                <div class="modal fade" id="show-{{ $hd->idhd }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="editAddressModalLabel">
                                                                                    Thông tin đơn hàng</h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    action="{{ route('hoadon.huy', ['idhd' => $hd->idhd]) }}"
                                                                                    method="POST">
                                                                                    @csrf

                                                                                    <div class="modal-body">
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Mã
                                                                                                đơn hàng:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>DH00{{ $hd->idhd }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Ngày
                                                                                                đặt hàng:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ \Carbon\Carbon::parse($hd->ngaydathang)->format('d-m-Y') }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Ngày
                                                                                                nhận hàng dự kiến:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ \Carbon\Carbon::parse($hd->ngaynhanhang)->format('d-m-Y') }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Tổng
                                                                                                tiền:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ number_format($hd->tongtien, 0, ',', ',') }}
                                                                                                    ₫
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Trạng
                                                                                                thái:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ $hd->trangthaidonhang->ten }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Người
                                                                                                nhận:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ $hd->diachi->tennguoinhan }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Địa
                                                                                                chỉ nhận hàng:</label>

                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                <p>{{ $hd->diachi->diachi }},{{ $hd->diachi->phuongxa }},{{ $hd->diachi->quanhuyen }},{{ $hd->diachi->tinhthanhpho }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Hiển thị các sản phẩm trong đơn hàng -->

                                                                                        <div class="form-group row">
                                                                                            <label
                                                                                                class="col-form-label col-sm-4">Sản
                                                                                                phẩm:</label>
                                                                                            <div
                                                                                                class="col-form-label col-sm-8">
                                                                                                @foreach ($hd->chitiethoadon as $cthd)
                                                                                                    @foreach ($cthd->chitietsanpham as $ctsp)
                                                                                                        <p>{{ $ctsp->sanpham->ten }}<br>
                                                                                                            (Màu:
                                                                                                            {{ $ctsp->mau->ten }},
                                                                                                            Size:
                                                                                                            {{ $ctsp->kichthuoc->ten }})
                                                                                                            x
                                                                                                            {{ $cthd->soluong }}
                                                                                                        </p>
                                                                                                    @endforeach
                                                                                                @endforeach
                                                                                            </div>

                                                                                        </div>


                                                                                        <!-- Nút hủy đơn hàng -->
                                                                                        <div class="modal-footer">
                                                                                            @if ($cthd->hoadon->trangthaidonhang->ten == 'Đã hủy')
                                                                                                <span
                                                                                                    style="font-size: 15px">Đơn
                                                                                                    hàng đã hủy</span>
                                                                                            @elseif(
                                                                                                $cthd->hoadon->trangthaidonhang->ten == 'Đã xác nhận' ||
                                                                                                    $cthd->hoadon->trangthaidonhang->ten == 'Đã bàn giao cho đơn vị vận chuyển')
                                                                                                <span
                                                                                                    style="font-size: 15px; color: red;">Không
                                                                                                    thể hủy đơn hàng vì đơn
                                                                                                    hàng đã xác nhận</span>
                                                                                            @elseif($cthd->hoadon->trangthaidonhang->ten == 'Đang vận chuyển')
                                                                                                <span
                                                                                                    style="font-size: 15px; color: red;">Đơn
                                                                                                    hàng đang vận chuyển và
                                                                                                    không thể hủy. Vui lòng
                                                                                                    theo dõi đơn hàng</span>
                                                                                            @elseif($cthd->hoadon->trangthaidonhang->ten == 'Giao hàng thành công')
                                                                                                @php
                                                                                                    // Kiểm tra xem khách hàng hiện tại đã đánh giá sản phẩm này chưa
                                                                                                    $daDanhGia = \App\Models\DanhGia::where(
                                                                                                        'idkh',
                                                                                                        $cthd->hoadon
                                                                                                            ->idkh,
                                                                                                    ) // ID khách hàng lấy từ hóa đơn
                                                                                                        ->where(
                                                                                                            'idctsp',
                                                                                                            $cthd->idctsp,
                                                                                                        ) // ID chi tiết sản phẩm từ chi tiết hóa đơn
                                                                                                        ->exists();
                                                                                                @endphp

                                                                                                @if ($daDanhGia)
                                                                                                    <!-- Nếu đã đánh giá -->
                                                                                                    <span
                                                                                                        class="nutthaydoi disabled"
                                                                                                        style="cursor: not-allowed; opacity: 0.6;">Đã
                                                                                                        đánh giá</span>
                                                                                                @elseif($cthd->hoadon->trangthaidonhang->ten == 'Giao hàng thành công')
                                                                                                    <!-- Nếu chưa đánh giá và đơn hàng đã giao -->
                                                                                                    <a href="{{ route('danhgia.create', ['idhd' => $cthd->hoadon->idhd]) }}"
                                                                                                        class="nutthaydoi"
                                                                                                        style="color: white">Đánh
                                                                                                        giá</a>

                                                                                                    <!-- Nút Hoàn tiền -->
                                                                                                    
                                                                                                    

                                                                                                    <!-- Popup yêu cầu hoàn tiền -->
                                                                                                @endif
                                                                                                <style>
                                                                                                    .disabled {
                                                                                                        pointer-events: none;
                                                                                                        /* Vô hiệu hóa tất cả sự kiện chuột */
                                                                                                        color: #666;
                                                                                                        background-color: #ccc;
                                                                                                        cursor: not-allowed;
                                                                                                    }
                                                                                                </style>
                                                                                                <!-- Popup Đánh Giá -->
                                                                                            @else
                                                                                                <form
                                                                                                    action="{{ route('hoadon.huy', ['idhd' => $cthd->hoadon->idhd]) }}"
                                                                                                    method="POST">
                                                                                                    @csrf
                                                                                                    <button type="submit"
                                                                                                        class="nutthaydoi">Hủy
                                                                                                        đơn hàng</button>
                                                                                                </form>
                                                                                            @endif
                                                                                        </div>

                                                                                    </div>

                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tab-pane" id="address">
                                        <h3 class="billing-address">Thông tin địa chỉ</h3>
                                        <p>Thông tin chi tiết về địa chỉ người dùng sẽ được hiển thị ở đây.</p>
                                        <a href="#" class="view" data-toggle="modal"
                                            data-target="#addAddressModal">Thêm địa
                                            chỉ</a>
                                        <div class="address-container">
                                            @if ($diachi->isEmpty())
                                                <p>Không có địa chỉ nào được tìm thấy.</p>
                                            @else
                                                <table class="table table-bordered">

                                                    <tbody>
                                                        @foreach ($diachi as $dc)
                                                            <tr>
                                                                <td style="font-size: 15px">
                                                                    <strong> {{ $dc->tennguoinhan }} | +84
                                                                        0{{ $dc->sdt }}</strong><br>
                                                                    {{ $dc->diachi }}<br>
                                                                    {{ $dc->phuongxa }}, {{ $dc->quanhuyen }},
                                                                    {{ $dc->tinhthanhpho }}
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="nutthaydoi"
                                                                        data-toggle="modal"
                                                                        data-target="#editAddressModal{{ $dc->iddc }}">Cập
                                                                        nhật</button>
                                                                    <button type="button" class="nutdong"
                                                                        data-toggle="modal"
                                                                        data-target="#delete-modal-{{ $dc->iddc }}">Xóa</button>

                                                                    <!-- Popup xác nhận xóa -->
                                                                    <div class="modal fade"
                                                                        id="delete-modal-{{ $dc->iddc }}"
                                                                        tabindex="-1" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Xác nhận xóa
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="modal-body"
                                                                                    style="font-size: 15px">
                                                                                    Bạn có chắc chắn muốn xóa địa chỉ này
                                                                                    không?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="nutthaydoi"
                                                                                        data-dismiss="modal">Hủy</button>
                                                                                    <form
                                                                                        action="{{ route('diachi.destroy', $dc->iddc) }}"
                                                                                        method="POST"
                                                                                        style="display:inline;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="nutdong">Xóa</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade"
                                                                        id="editAddressModal{{ $dc->iddc }}"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="editAddressModalLabel{{ $dc->id }}"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="editAddressModalLabel{{ $dc->id }}">
                                                                                        Sửa Địa Chỉ</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form
                                                                                        action="{{ route('diachi.update', $dc->iddc) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        @method('PUT')

                                                                                        <div class="form-group row">
                                                                                            <label for="tennguoinhan"
                                                                                                class="col-form-label col-sm-3">Tên
                                                                                                người nhận:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="tennguoinhan"
                                                                                                    name="tennguoinhan"
                                                                                                    value="{{ $dc->tennguoinhan }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label for="diachi"
                                                                                                class="col-form-label col-sm-3">Địa
                                                                                                chỉ:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="diachi"
                                                                                                    name="diachi"
                                                                                                    value="{{ $dc->diachi }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label for="phuongxa"
                                                                                                class="col-form-label col-sm-3">Phường
                                                                                                / xã:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="phuongxa"
                                                                                                    name="phuongxa"
                                                                                                    value="{{ $dc->phuongxa }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label for="quanhuyen"
                                                                                                class="col-form-label col-sm-3">Quận
                                                                                                / huyện:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="quanhuyen"
                                                                                                    name="quanhuyen"
                                                                                                    value="{{ $dc->quanhuyen }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label for="tinhthanhpho"
                                                                                                class="col-form-label col-sm-3">Tỉnh
                                                                                                / Thành phố:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="tinhthanhpho"
                                                                                                    name="tinhthanhpho"
                                                                                                    value="{{ $dc->tinhthanhpho }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group row">
                                                                                            <label for="sdt"
                                                                                                class="col-form-label col-sm-3">Số
                                                                                                điện thoại:</label>
                                                                                            <div class="col-sm-9">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="sdt"
                                                                                                    name="sdt"
                                                                                                    value="0{{ $dc->sdt }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="nutthaydoi">Lưu thay
                                                                                        đổi</button>
                                                                                    <button type="button" class="nutdong"
                                                                                        data-dismiss="modal">Đóng</button>
                                                                                </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- Modal for editing address -->
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        <!-- Modal for adding address -->
                                        <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog"
                                            aria-labelledby="addAddressModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addAddressModalLabel">Thêm Địa Chỉ Mới
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="addAddressForm"
                                                            action="{{ route('diachi.store', $khachhang->idkh) }}"
                                                            method="POST">
                                                            @csrf

                                                            <div class="form-group row">
                                                                <label for="tennguoinhan"
                                                                    class="col-form-label col-sm-3">Tên người
                                                                    nhận:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="tennguoinhan" name="tennguoinhan" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="diachi" class="col-form-label col-sm-3">Địa
                                                                    chỉ:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="diachi" name="diachi" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="phuongxa"
                                                                    class="col-form-label col-sm-3">Phường /
                                                                    xã:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="phuongxa" name="phuongxa" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="quanhuyen"
                                                                    class="col-form-label col-sm-3">Quận /
                                                                    huyện:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="quanhuyen" name="quanhuyen" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tinhthanhpho"
                                                                    class="col-form-label col-sm-3">Tỉnh / Thành
                                                                    phố:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="tinhthanhpho" name="tinhthanhpho" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="sdt" class="col-form-label col-sm-3">Số
                                                                    điện thoại:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        id="sdt" name="sdt" required>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="nutthaydoi"
                                                            form="addAddressForm">Thêm</button>
                                                        <button type="button" class="nutdong"
                                                            data-dismiss="modal">Đóng</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </section>



            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <!--pos page end-->
@endsection
