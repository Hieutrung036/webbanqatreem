@extends('admin.layout.indexmain')
@section('title', 'Chi tiết đơn hàng')

@section('body')
    <h1 style="font-size: 20px">CHI TIẾT ĐƠN HÀNG</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý đơn hàng</li>
            <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
        </ol>
    </nav>
    <a href="{{ route('admin.donhang') }}" class="btn btn-success">
        🡠 Quay lại
    </a>
    @if ($donhang->phuongthucthanhtoan->ten != 'Tại cửa hàng')
        @if ($donhang->trangthaidonhang->ten != 'Chờ xác nhận' && $donhang->trangthaidonhang->ten != 'Đã hủy') <!-- Kiểm tra trạng thái -->

            @if (!isset($donhang->phieugiaohang))
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
                    Lập phiếu giao hàng
                </button>
                <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Phiếu giao hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.chitietdonhang.lapphieugiaohanng') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="iddh" value="{{ $donhang->iddh }}">
                                    <input type="hidden" name="iddc" value="{{ $donhang->diachi->iddc }}">

                                    <div class="mb-3 row">
                                        <label for="ten" class="col-sm-3 col-form-label">Tên người nhận</label>
                                        <div class="col-sm-9">
                                            <input id="ten" type="text" class="form-control"
                                                value="{{ $donhang->diachi->tennguoinhan }}" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="iddvvc" class="col-sm-3 col-form-label">Đơn vị vận chuyển</label>
                                        <div class="col-sm-9">
                                            <select id="iddvvc" name="iddvvc" class="form-control" required>
                                                <option value="">Chọn đơn vị vận chuyển</option>
                                                @foreach ($donvivanchuyen as $dvvc)
                                                    <option value="{{ $dvvc->iddvvc }}">{{ $dvvc->ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                                        <div class="col-sm-9">
                                            <input id="sdt" type="text" class="form-control"
                                                value="0{{ $donhang->diachi->sdt }}" required />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="diachi" class="col-sm-3 col-form-label">Địa chỉ</label>
                                        <div class="col-sm-9">
                                            <input id="diachi" type="text" class="form-control"
                                                value="{{ $donhang->diachi->diachi }}" required />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-4">
                                            <label for="phuongxa" class="col-form-label">Phường / xã</label>
                                            <input id="phuongxa" type="text" class="form-control"
                                                value="{{ $donhang->diachi->phuongxa }}" required placeholder="Phường/Xã" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="quanhuyen" class="col-form-label">Quận / Huyện</label>
                                            <input id="quanhuyen" type="text" class="form-control"
                                                value="{{ $donhang->diachi->quanhuyen }}" required
                                                placeholder="Quận/Huyện" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="tinhthanhpho" class="col-form-label">Tỉnh / Thành phố</label>
                                            <input id="tinhthanhpho" type="text" class="form-control"
                                                value="{{ $donhang->diachi->tinhthanhpho }}" required
                                                placeholder="Tỉnh/Thành phố" />
                                        </div>
                                    </div>



                                    <div class="mb-3 row">
                                        <label for="ghichu" class="col-sm-3 col-form-label">Ghi chú</label>
                                        <div class="col-sm-9">
                                            <textarea id="ghichu" name="ghichu" class="form-control" rows="3" placeholder="Nhập ghi chú"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
                    Xem phiếu giao hàng
                </button>
                <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Phiếu giao hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <table class="table">
                                <tr>
                                    <td><b>Mã đơn hàng: </b>DH00{{ $donhang->iddh }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tên người nhận: </b>{{ $donhang->diachi->tennguoinhan }}</td>
                                </tr>
                                <tr>
                                    <td><b>Số điện thoại: </b> 0{{ $donhang->diachi->sdt }}</td>
                                </tr>
                                <tr>
                                    <td><b>Ghi chú: </b> {{ $donhang->phieugiaohang->ghichu }}</td>
                                </tr>
                                <tr>
                                    <td><b>Địa chỉ:</b>
                                        {{ $donhang->diachi->diachi }}, {{ $donhang->diachi->phuongxa }},
                                        {{ $donhang->diachi->quanhuyen }}, {{ $donhang->diachi->tinhthanhpho }}

                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Phương thức giao hàng:</b> {{ $donhang->phuongthucgiaohang->ten }}</td>
                                </tr>
                                <tr>
                                    <td><b>Đơn vị vận chuyển:</b> {{ $donhang->phieugiaohang->donvivanchuyen->ten }}</td>
                                </tr>
                                <tr>
                                    <td><b>Sản phẩm:</b>
                                        <br>
                                        @foreach ($chitietdonhang as $chitietdonhangItem)
                                            @foreach ($chitietdonhangItem->chitietsanpham as $chitietsanpham)
                                                {{ $chitietsanpham->sanpham->ten }} -
                                                (Màu: {{ $chitietsanpham->mau->ten }},
                                                Size: {{ $chitietsanpham->kichthuoc->ten }})
                                                x {{ $chitietdonhangItem->soluong }}
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                {{ number_format($chitietsanpham->sanpham->gia) }} VND
                                                <br>
                                            @endforeach
                                        @endforeach

                                    </td>

                                </tr>



                                <tr>
                                    <td>
                                        <b>Giá tiền:</b>
                                        @php
                                            $total = 0; // Khởi tạo biến tổng
                                        @endphp

                                        @foreach ($chitietdonhang as $chitietdonhangItem)
                                            @foreach ($chitietdonhangItem->chitietsanpham as $chitietsanpham)
                                                @php
                                                    $total +=
                                                        $chitietsanpham->sanpham->gia * $chitietdonhangItem->soluong; // Tính tổng giá
                                                @endphp
                                            @endforeach
                                        @endforeach

                                        {{ number_format($total) }} VND


                                        <br>
                                        <b style="font-size: 15px">Phí ship:</b>
                                        {{ number_format($donhang->phuongthucgiaohang->phigiaohang) }} VND
                                        <br>
                                        <b >Tổng tiền:</b>
                                        {{ number_format($donhang->tongtien) }}VND
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Phương thức thanh toán:</b> {{ $donhang->phuongthucthanhtoan->ten }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <p>Không thể lập phiếu giao hàng.</p>
        @endif
    @endif


    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3"
            role="alert" style="z-index: 1055;">
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


    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($donhang && $donhang->diachi)
            <div class="product-details">
                <table class="table table-form" id="dataTable" width="100%" cellspacing="0" style="">
                    <tr>
                        <td width="200px">Tên khách hàng</td>
                        <td><input type="text" style="border:none; width: 900px"
                                value="{{ $donhang->diachi->tennguoinhan }}" name="example" readonly
                                placeholder="Nhập tên khách hàng" required></td>
                    </tr>
                    <tr>
                        <td width="200px">Số điện thoại</td>
                        <td><input type="text" style="border:none; width: 900px" value="0{{ $donhang->diachi->sdt }}"
                                name="sdt" readonly placeholder="Nhập số điện thoại" required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td><input type="text" style="border:none; width: 900px" name="diachi"
                                value="{{ $donhang->diachi->diachi }}, {{ $donhang->diachi->phuongxa }}, {{ $donhang->diachi->quanhuyen }}, {{ $donhang->diachi->tinhthanhpho }}"
                                placeholder="Nhập địa chỉ" readonly required>

                        </td>
                    </tr>

                    <tr>
                        <td>Ngày đặt hàng</td>
                        <td><input type="date" name="ngaydathang" class="form-control"
                                value="{{ $donhang->ngaydathang }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Ngày nhận hàng</td>
                        <td><input type="date" name="ngaynhanhang" class="form-control"
                                value="{{ $donhang->ngaynhanhang }}" readonly></td>
                    </tr>

                    <tr>
                        <td>Tổng số lượng sản phẩm </td>
                        <td>{{ $donhang->chitietdonhang->sum('soluong') }}</td>
                    </tr>
                    <tr>
                        <td>Tổng tiền </td>
                        <td> {{ number_format($donhang->tongtien, 0, ',', '.') }} VND</td>
                    </tr>
                    <tr>
                        <td>Thông tin thanh toán</td>
                        <td>{{ $donhang->phuongthucthanhtoan->ten }}</td>
                    </tr>

                    <tr>
                        <td>Phương thức vận chuyển </td>
                        <td>{{ $donhang->phuongthucgiaohang->ten }}
                            @if($donhang->phuongthucgiaohang->ten != 'Tại cửa hàng')
                            (Phí giao hàng: {{ number_format($donhang->phuongthucgiaohang->phigiaohang) }} VND ,
                            {{ $donhang->phuongthucgiaohang->mota }})</td>
                            @endif
                    </tr>

                    <tr>
                        <td>Trạng thái đơn hàng</td>
                        <td>{{ $donhang->trangthaidonhang->ten }}</td>
                    </tr>





                </table>

                @if ($donhang->phuongthucthanhtoan->ten == 'Tại cửa hàng')
                    <div style="text-align: right; margin-bottom: 20px">
                        <a href="{{ route('admin.chitietdonhang.hoadon', $donhang->iddh) }}" class="btn btn-warning">
                            Xuất hóa đơn
                        </a>
                    </div>
                @endif


                {{-- <div style="text-align: right; margin-bottom: 20px">

                    <button type="button" class="btn btn-primary">
                        <a href="{{ route('admin.themspdonhang') }}" style="color: #1b1e21"><b>Thêm sản phẩm</b></a>
                    </button>
                </div> --}}
            </div>
        @endif

        <div class="product-details">

            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng tiền</th>
                        {{-- <th>Thao tác</th> --}}
                    </tr>
                </thead>

                <tbody>

                    @foreach ($chitietdonhang as $ctdh)
                        <tr>
                            <td>{{ $loop->iteration + ($chitietdonhang->currentPage() - 1) * $chitietdonhang->perPage() }}
                            </td>

                            <td style="display: flex; align-items: center;">
                                <!-- Hình ảnh sản phẩm -->
                                @foreach ($ctdh->chitietsanpham as $ctsp)
                                    @foreach ($ctsp->hinhanh as $hinhphu)
                                        <img src="{{ asset('uploads/sanpham/' . $hinhphu->duongdan) }}"
                                            alt="Hình ảnh sản phẩm"
                                            style="width: 80px; height: auto; margin-right: 15px;">
                                    @endforeach
                                @endforeach




                                <div>
                                    <b>Tên sản phẩm: </b>
                                    @foreach ($ctdh->chitietsanpham as $ctsp)
                                        {{ $ctsp->sanpham->ten }}
                                    @endforeach
                                    <br>
                                    <b>Màu: </b>
                                    @foreach ($ctdh->chitietsanpham as $ctsp)
                                        {{ $ctsp->mau->ten }}
                                    @endforeach
                                    <br>
                                    <b>Size: </b>
                                    @foreach ($ctdh->chitietsanpham as $ctsp)
                                        {{ $ctsp->kichthuoc->ten }}
                                    @endforeach
                                </div>
                            </td>

                            <td> {{ $ctdh->soluong }}</td>
                            <td>
                                @foreach ($ctdh->chitietsanpham as $ctsp)
                                    @php
                                        $gia = $ctsp->sanpham->gia;
                                        if ($ctsp->sanpham->giamgia) {
                                            $gia =
                                                $ctsp->sanpham->gia -
                                                ($ctsp->sanpham->gia * $ctsp->sanpham->giamgia->phantram) / 100;
                                        }
                                    @endphp

                                    {{ number_format($gia, 0, ',', '.') }} VND
                                @endforeach

                            </td>
                            <td>
                                @foreach ($ctdh->chitietsanpham as $ctsp)
                                    @php
                                        $gia = $ctsp->sanpham->gia; // Giá gốc
                                        // Kiểm tra xem sản phẩm có giảm giá không
                                        if ($ctsp->sanpham->giamgia) {
                                            // Tính giá sau khi giảm giá
                                            $gia = $gia - ($gia * $ctsp->sanpham->giamgia->phantram) / 100;
                                        }

                                        // Tính tổng tiền của sản phẩm (giá sau giảm nhân với số lượng)
                                        $tongTien = $gia * $ctdh->soluong;
                                    @endphp

                                    {{ number_format($tongTien, 0, ',', '.') }} VND
                                @endforeach
                            </td>

                            {{-- <td>
                                <!-- Nút Sửa -->
                                <button class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#edit-modal">Sửa</button>

                                <!-- Modal Cập nhật số lượng -->
                                <div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cập nhật số lượng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3 row">
                                                        <label for="soluong" class="col-sm-3 col-form-label">Số
                                                            lượng</label>
                                                        <div class="col-sm-9">
                                                            <input id="soluong" type="number" class="form-control"
                                                                name="soluong" value="" required min="1"
                                                                placeholder="Nhập số lượng">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form xóa sản phẩm -->
                                <form action="" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="">
                                        Xóa
                                    </button>

                                    <!-- Modal Xác nhận xóa cho từng sản phẩm -->
                                    <div class="modal fade" id="" tabindex="-1" aria-labelledby=""
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">
                                                        Xác nhận xóa sản phẩm
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn bỏ sản phẩm "1" không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td> --}}

                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="row">
                <div class="col-6">
                    <strong>
                        Tổng số lượng: {{ $chitietdonhang->sum('soluong') }}
                    </strong>
                </div>

                <div class="col-6 text-right">
                    <strong>Tổng tiền:


                        {{ number_format($donhang->tongtien, 0, ',', '.') }} VND
                    </strong>
                </div>
            </div>

        </div>

    </form>


@endsection

@section('search')
    <form action="" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>
@endsection


{{-- bỏ cái này --}}