@extends('admin.layout.indexmain')
@section('title', 'Đơn hàng')

@section('body')
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
    <h1 style="font-size: 20px">DANH SÁCH HÓA ĐƠN</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý hóa đơn</li>
            <li class="breadcrumb-item active">Danh sách hóa đơn</li>
        </ol>
    </nav>

    <a href="{{ route('admin.lapdonhang') }}" class="btn btn-primary">Lập hóa đơn</a>


    <!-- popup thêm sản phẩm -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lập hóa đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.hoadon.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên khách hàng</label>
                            <div class="col-sm-9">
                                <input id="ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên khách hàng" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ngaydathang" class="col-sm-3 col-form-label">Ngày đặt hàng</label>
                            <div class="col-sm-9">
                                <input id="ngaydathang" type="date" class="form-control" name="ngaydathang" required
                                    autocomplete="ngaydathang" placeholder="Ngày đặt hàng" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ngaynhanhang" class="col-sm-3 col-form-label">Ngày nhận hàng</label>

                            <div class="col-sm-9">
                                <input id="ngaynhanhang" type="date" class="form-control" name="ngaynhanhang" required
                                    autocomplete="ngaynhanhang" placeholder="Ngày nhận hàng" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idgg" class="col-sm-3 col-form-label">Giảm giá</label>
                            <div class="col-sm-9">
                                <select id="idgg" name="idgg" required class="form-control">
                                    <option value="">Chọn giảm giá</option>
                                    @foreach ($magiamgia as $mgg)
                                        <option value="{{ $mgg->idgg }}">{{ $mgg->code }} @if ($mgg->phantram > 0)
                                                {{ $mgg->phantram }}%
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idttdh" class="col-sm-3 col-form-label">Trạng thái</label>
                            <div class="col-sm-9">
                                <select id="idttdh" name="idttdh" required class="form-control">
                                    <option value="">Chọn trạng thái</option>
                                    @foreach ($trangthaidonhang as $ttdh)
                                        <option value="{{ $ttdh->idttdh }}">{{ $ttdh->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th style="width:10px">Số lượng</th>

                    <th>Tổng tiền</th>
                    <th>Ngày đặt hàng</th>
                    <th>Ngày nhận hàng</th>
                    <th>Trạng thái đơn hàng</th>

                    <th>Phương thức thanh toán</th>

                    <th style="width:300px">Thao tác</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($hoadon as $hd)
                    <tr>
                        <td>{{ $loop->iteration + ($hoadon->currentPage() - 1) * $hoadon->perPage() }}</td>
                        <td>{{ $hd->diachi->tennguoinhan }}</td>
                        {{-- <td>
                            @php
                                $tongslsp = 0;
                            @endphp
                            @foreach ($donhang->chitietdonhang as $chitietsanpham)
                                @php
                                    $tong = $chitietsanpham->Soluong;
                                    $tongslsp+=$tong;
                                @endphp
                            @endforeach
                            {{$tongslsp}}
                        </td> --}}
                        <td>
                            {{ $hd->chitiethoadon->sum('soluong') }}
                        </td>

                        <td> {{ number_format($hd->tongtien, 0, ',', '.') }} VND</td>
                        <td> {{ \Carbon\Carbon::parse($hd->ngaydathang)->format('d/m/Y') }}</td>
                        <td> {{ \Carbon\Carbon::parse($hd->ngaynhanhang)->format('d/m/Y') }}</td>
                        <td>{{ $hd->trangthaidonhang->ten }}</td>
                        <td>{{ $hd->phuongthucthanhtoan->ten }}</td>



                        <td>
                            <!-- Nút Sửa -->
                            <button
                                class="btn {{ $hd->trangthaidonhang->ten == 'Chờ xác nhận' ? 'btn-warning' : 'btn-secondary' }} "
                                {{ $hd->trangthaidonhang->ten != 'Chờ xác nhận' ? 'disabled' : '' }}>
                                <a href="{{ route('admin.update-order-status', $hd->idhd) }}"
                                    style="color: inherit; text-decoration: none;">
                                    Xác nhận
                                </a>
                            </button>






                            <style>
                                .btn[disabled] {
                                    pointer-events: none;
                                    /* Không cho phép nhấn */
                                    opacity: 0.65;
                                    /* Giảm độ mờ cho nút vô hiệu hóa */
                                }
                            </style>



                            @if ($hd->trangthaidonhang->ten === 'Chờ xác nhận')
                                <form action="{{ route('admin.hoadon.destroy', $hd->idhd) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Nút Xóa, dùng button để mở modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal-{{ $hd->idhd }}">
                                        Xóa
                                    </button>

                                    <!-- Modal xác nhận xóa -->
                                    <div class="modal fade" id="delete-modal-{{ $hd->idhd }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xác nhận xóa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa hóa đơn này không?
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
                            @endif





                         
                            <a href="{{ route('admin.chitiethoadon', ['id' => $hd->idhd]) }}" class="btn btn-primary">Chi
                                tiết</a>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $hoadon->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>
@endsection


@section('search')

    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm người dùng..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
