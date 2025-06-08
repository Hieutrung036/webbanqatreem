@extends('admin.layout.indexmain')
@section('title', 'Đánh giá')

@section('body')
    <h1 style="font-size: 20px">DANH SÁCH ĐÁNH GIÁ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý người dùng</li>
            <li class="breadcrumb-item active">Đánh giá</li>
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


    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Số sao</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($danhgia as $dg)
                    <tr>
                        <td>{{ $loop->iteration + ($danhgia->currentPage() - 1) * $danhgia->perPage() }}</td>
                        <td>{{ $dg->khachhang->ten }}</td>
                        <td>{{ $dg->sosao }}</td>
                        <td>{{ $dg->noidung }}</td>

                        <td>
                            @if ($dg->phanhoi->isNotEmpty()) <!-- Kiểm tra nếu có ít nhất 1 phản hồi -->
                                <b>Đã phản hồi</b>
                            @else
                                Chưa phản hồi
                            @endif
                        </td>
                        


                        <td>
                            <!-- Nút Sửa -->
                            <form action="{{ route('admin.danhgia.destroy', $dg->iddg) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $dg->iddg }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $dg->iddg }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa?
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
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $dg->iddg }}">Phản hồi</button>

                            <!-- Modal Phản hồi -->
                            <div class="modal fade" id="edit-modal-{{ $dg->iddg }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Phản hồi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.danhgia.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="iddg" value="{{ $dg->iddg }}">

                                                <div class="mb-3">
                                                    <label for="noidung" class="form-label">Nội dung phản hồi</label>
                                                    <textarea id="noidung" class="form-control" name="noidung" rows="6" required></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Phản hồi</button>
                                                </div>
                                            </form>
                                        </div>
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
                {{ $danhgia->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>


@endsection


@section('search')

    <form action="{{ route('admin.danhgia.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm đánh giá..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
