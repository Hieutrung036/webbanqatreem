@extends('admin.layout.indexmain')
@section('title', 'Lập đơn hàng')

@section('body')
    <h1 style="font-size: 20px">LẬP ĐƠN HÀNG</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý đơn hàng</li>
            <li class="breadcrumb-item active">Lập đơn hàng</li>
            <li class="breadcrumb-item active">Thêm sản phẩm</li>

        </ol>
    </nav>
    <a href="{{ route('admin.lapdonhang') }}" class="btn btn-success">
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

    <div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Chất liệu</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sanpham as $sp)
                    <tr>
                        <td>{{ $loop->iteration + ($sanpham->currentPage() - 1) * $sanpham->perPage() }}</td>
                        <td>{{ $sp->ten }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($sp->mota, 50, '.......') }}</td>

                        <td>
                            @php
                                $gia = $sp->gia;
                                // Kiểm tra xem sản phẩm có mã giảm giá hay không
                                if ($sp->giamgia) {
                                    // Tính giá sau khi giảm giá nếu có
                                    $gia = $sp->gia - ($sp->gia * $sp->giamgia->phantram) / 100;
                                }
                            @endphp
                            {{ number_format($gia, 0, ',', ',') }} VND
                        </td>

                        <td>{{ $sp->chatlieu }}</td>

                        <td>
                            <!-- Nút Thêm -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#add-product-{{ $sp->idsp }}">
                                Chọn
                            </button>

                            <!-- Modal dành riêng cho sản phẩm -->
                            <div class="modal fade" id="add-product-{{ $sp->idsp }}" tabindex="-1"
                                aria-labelledby="modalLabel-{{ $sp->idsp }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.themspdonhang.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-{{ $sp->idsp }}">Thêm sản phẩm
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label">Chi tiết sản phẩm</label>
                                                    <div class="col-sm-9">
                                                        <select id="idctsp" name="idctsp" required
                                                            class="form-control chitietsanpham"
                                                            data-sanpham-id="{{ $sp->idsp }}">
                                                            <option value="">Chọn chi tiết sản phẩm</option>
                                                            @foreach ($sp->chitietsanpham as $ctsp)
                                                                <option value="{{ $ctsp->idctsp }}"
                                                                    data-solieu="{{ $ctsp->soluong }}">
                                                                    Màu: {{ $ctsp->mau->ten }} - Kích thước:
                                                                    {{ $ctsp->kichthuoc->ten }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label"></label>
                                                    <div class="col-sm-9">
                                                        <span class="soluongSP" id="soluongSP_{{ $sp->idsp }}">Còn 0
                                                            sản phẩm</span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="soluong" class="col-sm-3 col-form-label">Số lượng</label>
                                                    <div class="col-sm-9">
                                                        <input id="soluong" type="number" class="form-control"
                                                            name="soluong" required min="1"
                                                            placeholder="Nhập số lượng" />
                                                    </div>
                                                </div>
                                            </div>
                                            <style>
                                                .out-of-stock-message {
                                                    color: red;
                                                    font-weight: bold;
                                                }

                                                .out-of-stock {
                                                    background-color: #f1f1f1;
                                                    /* Màu nền xám */
                                                    color: #999;
                                                    /* Màu chữ xám */
                                                }
                                            </style>

                                            <script>
                                                $(document).ready(function() {
                                                    // Xử lý khi chọn thay đổi chi tiết sản phẩm
                                                    $('.chitietsanpham').on('change', function() {
                                                        // Lấy số lượng từ option được chọn
                                                        var soluong = $(this).find('option:selected').data('solieu');

                                                        // Xác định ID sản phẩm hiện tại
                                                        var sanphamId = $(this).data('sanpham-id');

                                                        // Tham chiếu đến phần tử hiển thị số lượng
                                                        var soluongSPElement = $('#soluongSP_' + sanphamId);
                                                        var inputSoluong = $('#soluong'); // Ô nhập số lượng

                                                        // Cập nhật hiển thị số lượng hoặc thông báo hết hàng
                                                        if (soluong !== undefined) {
                                                            if (soluong > 0) {
                                                                soluongSPElement
                                                                    .text('Còn ' + soluong + ' sản phẩm')
                                                                    .removeClass('out-of-stock-message');
                                                                inputSoluong.prop('disabled', false); // Cho phép nhập lại
                                                                inputSoluong.removeClass('out-of-stock'); // Gỡ bỏ màu xám
                                                            } else {
                                                                soluongSPElement
                                                                    .text('Sản phẩm hiện tại đã hết !!')
                                                                    .addClass('out-of-stock-message');
                                                                inputSoluong.prop('disabled', true); // Làm xám và không thể nhập
                                                                inputSoluong.addClass('out-of-stock'); // Thêm lớp CSS làm xám
                                                            }
                                                        } else {
                                                            soluongSPElement
                                                                .text('Còn 0 sản phẩm')
                                                                .removeClass('out-of-stock-message');
                                                            inputSoluong.prop('disabled', true); // Làm xám và không thể nhập
                                                            inputSoluong.addClass('out-of-stock'); // Thêm lớp CSS làm xám
                                                        }
                                                    });
                                                });
                                            </script>



                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary">Lưu</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $sanpham->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection

@section('search')
    <form action="" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>
@endsection
