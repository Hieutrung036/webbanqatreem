@extends('admin.layout.indexmain')
@section('title', 'Lập hóa đơn')

@section('body')
    <h1 style="font-size: 20px">LẬP HÓA ĐƠN</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý hóa đơn</li>
            <li class="breadcrumb-item active">Lập hóa đơn</li>
        </ol>
    </nav>
    <a href="{{ route('admin.hoadon') }}" class="btn btn-success">
        🡠 Quay lại
    </a>
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
    @if (session('error'))
        <div id="error-alert" class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('error') }}
        </div>
    @endif


    <form action="{{ route('admin.lapdonhang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="product-details">

            <table class="table table-form" id="dataTable" width="100%" cellspacing="0" style="">
                <tr>
                    <td width="200px">Tên khách hàng:</td>
                    <td><input type="text" style="border:none; width: 900px" name="example"
                            placeholder="Nhập tên khách hàng" required></td>

                </tr>
                <tr>
                    <td width="200px">Số điện thoại:</td>
                    <td><input type="text" style="border:none; width: 900px" name="sdt"
                            placeholder="Nhập số điện thoại" required></td>
                </tr>
                <tr>
                    <td>Địa chỉ giao hàng :</td>
                    <td>
                        <input type="text" style="border:none; width: 900px" name="diachi" placeholder="Nhập địa chỉ" required>
                    </td>
                </tr>
                <tr>
                    <td>Phường / Quận / Thành Phố </td>
                    <td>
                        <input type="text" style="border:none; width: 280px; margin-right: 10px;" name="phuongxa" placeholder="Nhập phường / xã" required>
                        <input type="text" style="border:none; width: 280px; margin-right: 10px;" name="quanhuyen" placeholder="Nhập quận / huyện" required>
                        <input type="text" style="border:none; width: 280px;" name="tinhthanhpho" placeholder="Nhập tỉnh / thành phố" required>
                    </td>
                </tr>
                

                {{-- <tr>
                    <td>Ngày lập:</td>
                    <td><input type="date" name="ngaylap" class="form-control" required></td>
                </tr> --}}
                
               
                
                
                <tr>
                    <td>Tổng số lượng sản phẩm :</td>
                    <td>{{ $totalQuantity }}</td>
                </tr>
                <tr>
                    <td>Tổng tiền :</td>
                    <td>{{ number_format($totalAmount, 0, ',', ',') }} VND</td>
                </tr>
                

                





            </table>
            <div style="text-align: right; margin-bottom: 20px">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="tongtien" value="">
                    <button type="submit" class="btn btn-warning">
                        Lập hóa đơn
                    </button>
                </form>
            </div>
            <div style="text-align: right; margin-bottom: 20px">

                <button type="button" class="btn btn-primary">
                    <a href="{{ route('admin.themspdonhang') }}" style="color: #1b1e21"><b>Thêm sản phẩm</b></a>
                </button>
            </div>
        </div>
        <div class="product-details">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $totalQuantity = 0;
                    @endphp
                    @foreach (session('cart', []) as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td style="display: flex; align-items: center;">
                                <!-- Hình ảnh sản phẩm -->
                                @if (isset($product['hinhphu']) && $product['hinhphu'])
                                    <img src="{{ asset('uploads/sanpham/' . $product['hinhphu']) }}"
                                        alt="Hình ảnh sản phẩm" style="width: 80px; height: auto; margin-right: 15px;">
                                @else
                                    <span>Không có hình ảnh</span>
                                @endif

                                <!-- Thông tin sản phẩm -->
                                <div>
                                    <b>Tên sản phẩm: </b> {{ $product['ten'] }}
                                    <br>
                                    <b>Màu: </b> {{ $product['mau'] }}
                                    <br>
                                    <b>Size: </b> {{ $product['kichthuoc'] }}
                                </div>
                            </td>

                            <td>{{ $product['soluong'] }}</td>
                            <td>{{ number_format($product['gia'], 0, ',', ',') }} VND</td>
                            <td>{{ number_format($product['total'], 0, ',', ',') }} VND</td>
                            <td>
                                <!-- Nút Sửa -->
                                <button class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#edit-modal-{{ $product['idctsp'] }}">Sửa</button>

                                <!-- Modal Cập nhật số lượng -->
                                <div class="modal fade" id="edit-modal-{{ $product['idctsp'] }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cập nhật số lượng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.lapdonhang.update', $product['idctsp']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3 row">
                                                        <label for="soluong" class="col-sm-3 col-form-label">Số
                                                            lượng</label>
                                                        <div class="col-sm-9">
                                                            <input id="soluong" type="number" class="form-control"
                                                                name="soluong" value="{{ $product['soluong'] }}" required
                                                                min="1" placeholder="Nhập số lượng">
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



                                <form action="{{ route('admin.lapdonhang.destroy', ['index' => $key]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Nút Xóa -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal-{{ $key }}">
                                        Xóa
                                    </button>

                                    <!-- Modal Xác nhận xóa cho từng sản phẩm -->
                                    <div class="modal fade" id="delete-modal-{{ $key }}" tabindex="-1"
                                        aria-labelledby="delete-modal-label-{{ $key }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete-modal-label-{{ $key }}">
                                                        Xác
                                                        nhận xóa sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn bỏ sản phẩm "{{ $product['ten'] }}" không?
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
                            </td>

                        </tr>
                        @php
                            $totalAmount += $product['total'];
                            $totalQuantity += $product['soluong'];
                        @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-6">
                    <strong>Tổng số lượng: {{ $totalQuantity }}</strong>
                </div>
                <div class="col-6 text-right">
                    <strong>Tổng tiền: {{ number_format($totalAmount, 0, ',', ',') }} VND</strong>
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
