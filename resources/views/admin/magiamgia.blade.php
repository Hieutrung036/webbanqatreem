@extends('admin.layout.indexmain')
@section('title', 'Giảm giá')

@section('body')
    <h1 style="font-size: 20px">MÃ GIẢM GIÁ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý mã giảm giá</li>
            <li class="breadcrumb-item active">Danh sách mã giảm giá</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm mã giảm giá
    </button>
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
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mã giảm giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.magiamgia.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label for="code" class="col-sm-3 col-form-label">Mã giảm giá</label>
                            <div class="col-sm-9">
                                <input id="code" type="text" class="form-control" name="code" required
                                    placeholder="Nhập mã giảm giá" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phantram" class="col-sm-3 col-form-label">Phần trăm (%)</label>
                            <div class="col-sm-9">
                                <input id="phantram" type="number" class="form-control" name="phantram" required
                                    placeholder="Nhập phần trăm" min="0" max="100" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <input id="mota" type="text" class="form-control" name="mota" required
                                    placeholder="Nhập mô tả" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="soluong" class="col-sm-3 col-form-label">Số lượng</label>
                            <div class="col-sm-9">
                                <input id="soluong" type="number" class="form-control" name="soluong" required
                                    placeholder="Nhập số lượng" min="0" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ngaybatdau" class="col-sm-3 col-form-label">Ngày bắt đầu</label>
                            <div class="col-sm-9">
                                <input id="ngaybatdau" type="date" class="form-control" name="ngaybatdau" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ngayketthuc" class="col-sm-3 col-form-label">Ngày kết thúc</label>
                            <div class="col-sm-9">
                                <input id="ngayketthuc" type="date" class="form-control" name="ngayketthuc" required />
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
                    <th>Code</th>
                    <th>Phầm trăm</th>
                    <th>Mô tả</th>
                    <th>Số lượng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($magiamgia as $mgg)
                    <tr>
                        <td>{{ $loop->iteration + ($magiamgia->currentPage() - 1) * $magiamgia->perPage() }}</td>
                        <td>{{ $mgg->code }}</td>
                        <td>{{ $mgg->phantram }}%</td>
                        <td>{{ $mgg->mota }}</td>
                        <td>{{ $mgg->soluong }}</td>
                        <td>{{ \Carbon\Carbon::parse($mgg->ngaybatdau)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mgg->ngayketthuc)->format('d/m/Y') }}</td>


                        <td>
                             <!-- Nút Sửa -->
                        <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#edit-modal-{{ $mgg->idgg }}">Sửa</button>
                        <!-- Popup sửa màu -->
                        <div class="modal fade" id="edit-modal-{{ $mgg->idgg }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa mã giảm giá</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.magiamgia.update', $mgg->idgg) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3 row">
                                                <label for="code" class="col-sm-3 col-form-label">Mã giảm giá</label>
                                                <div class="col-sm-9">
                                                    <input id="code" type="text" value="{{ $mgg->code }}" class="form-control" name="code" required
                                                        placeholder="Nhập mã giảm giá" />
                                                </div>
                                            </div>
                    
                                            <div class="mb-3 row">
                                                <label for="phantram" class="col-sm-3 col-form-label">Phần trăm (%)</label>
                                                <div class="col-sm-9">
                                                    <input id="phantram" type="number" value="{{ $mgg->phantram }}" class="form-control" name="phantram" required
                                                        placeholder="Nhập phần trăm" min="0" max="100" />
                                                </div>
                                            </div>
                    
                                            <div class="mb-3 row">
                                                <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                                                <div class="col-sm-9">
                                                    <input id="mota" type="text" value="{{ $mgg->mota }}" class="form-control" name="mota" required
                                                        placeholder="Nhập mô tả" />
                                                </div>
                                            </div>
                    
                                            <div class="mb-3 row">
                                                <label for="soluong" class="col-sm-3 col-form-label">Số lượng</label>
                                                <div class="col-sm-9">
                                                    <input id="soluong" type="number" value="{{ $mgg->soluong }}" class="form-control" name="soluong" required
                                                        placeholder="Nhập số lượng" min="0" />
                                                </div>
                                            </div>
                    
                                            <div class="mb-3 row">
                                                <label for="ngaybatdau" class="col-sm-3 col-form-label">Ngày bắt đầu</label>
                                                <div class="col-sm-9">
                                                    <input id="ngaybatdau" type="date" value="{{ $mgg->ngaybatdau }}" class="form-control" name="ngaybatdau" required />
                                                </div>
                                            </div>
                    
                                            <div class="mb-3 row">
                                                <label for="ngayketthuc" class="col-sm-3 col-form-label">Ngày kết thúc</label>
                                                <div class="col-sm-9">
                                                    <input id="ngayketthuc" type="date" class="form-control" value="{{ $mgg->ngayketthuc }}" name="ngayketthuc" required />
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
                        <form action="{{ route('admin.magiamgia.destroy', $mgg->idgg) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#delete-modal-{{  $mgg->idgg }}">Xóa</button>

                            <!-- Popup xác nhận xóa -->
                            <div class="modal fade" id="delete-modal-{{ $mgg->idgg }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa mã giảm giá này không?
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
                {{ $magiamgia->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')
    
    <form action="{{ route('admin.magiamgia.search') }}" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm mã giảm giá..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
