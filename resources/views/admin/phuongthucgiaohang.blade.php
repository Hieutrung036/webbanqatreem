@extends('admin.layout.indexmain')
@section('title', 'Phương thức giao hàng')

@section('body')
    <h1 style="font-size: 20px">PHƯƠNG THỨC GIAO HÀNG</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý đơn hàng</li>
            <li class="breadcrumb-item active">Phương thức giao hàng</li>
        </ol>
    </nav>
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
    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm phương thức giao hàng
    </button>

    <!-- popup thêm người dùng -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm phương thức giao hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.phuongthucgiaohang.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Phương thức giao hàng</label>
                            <div class="col-sm-9">
                                <input id="ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập phương thức" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phigiaohang" class="col-sm-3 col-form-label">Phí giao hàng</label>
                            <div class="col-sm-9">

                                <input id="phigiaohang" type="number" class="form-control" name="phigiaohang" required
                                    placeholder="Nhập phí giao hàng" min="0" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ngaydukien" class="col-sm-3 col-form-label">Ngày nhận hàng dự kiến</label>
                            <div class="col-sm-9">

                                <input id="ngaydukien" type="number" class="form-control" name="ngaydukien" required
                                    placeholder="Nhập ngày nhận hàng" min="0" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea id="mota" class="form-control" name="mota" rows="4" required placeholder="Nhập mô tả"></textarea>
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
                    <th>Tên</th>
                    <th>Phí giao hàng</th>
                    <th>Ngày nhận dự kiến</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($phuongthucgiaohang as $ptgh)
                    <tr>
                        <td>{{ $loop->iteration + ($phuongthucgiaohang->currentPage() - 1) * $phuongthucgiaohang->perPage() }}
                        </td>
                        <td>{{ $ptgh->ten }}</td>

                        <td>{{ $ptgh->phigiaohang }}</td>
                        <td>{{ $ptgh->ngaydukien }}</td>
                        <td>{{ $ptgh->mota }}</td>
                        <td>
                            <!-- Nút Sửa -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $ptgh->idptgh }}">Sửa</button>
                            <!-- Popup sửa màu -->
                            <div class="modal fade" id="edit-modal-{{ $ptgh->idptgh }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa phương thức</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.phuongthucgiaohang.update', $ptgh->idptgh) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3 row">
                                                    <label for="ten" class="col-sm-3 col-form-label">Tên phương
                                                        thức</label>
                                                    <div class="col-sm-9">
                                                        <input id="ten" type="text" class="form-control"
                                                            name="ten" value="{{ $ptgh->ten }}" required
                                                            placeholder="Nhập phương thức" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="phigiaohang" class="col-sm-3 col-form-label">Phí giao
                                                        hàng</label>
                                                    <div class="col-sm-9">

                                                        <input id="phigiaohang" type="number"
                                                            value="{{ $ptgh->phigiaohang }}" class="form-control"
                                                            name="phigiaohang" required placeholder="Nhập phí giao hàng"
                                                            min="0" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="ngaydukien" class="col-sm-3 col-form-label">Ngày nhận hàng
                                                        dự kiến</label>
                                                    <div class="col-sm-9">

                                                        <input id="ngaydukien" type="number" class="form-control"
                                                            value="{{ $ptgh->ngaydukien }}" name="ngaydukien" required
                                                            placeholder="Nhập ngày nhận hàng" min="0" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                                                    <div class="col-sm-9">
                                                        <textarea id="mota" class="form-control" name="mota" rows="4" required placeholder="Nhập mô tả">{{ $ptgh->mota }}</textarea>
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

                            <!-- Nút Xóa -->
                            <form action="{{ route('admin.phuongthucgiaohang.destroy', $ptgh->idptgh) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $ptgh->idptgh }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $ptgh->idptgh }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa phương thức này không?
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
                @endforeach

            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $phuongthucgiaohang->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')

    <form action="{{ route('admin.phuongthucgiaohang.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm phương thức giao hàng..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
