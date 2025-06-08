@extends('admin.layout.indexmain')
@section('title', 'Loại tin tức')

@section('body')
    <h1 style="font-size: 20px">LOẠI TIN TỨC</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý tin tức</li>
            <li class="breadcrumb-item active">Loại tin tức</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm loại tin tức
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
    @if (session('error'))
        <div id="error-alert" class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('error') }}
        </div>
    @endif

    <!-- popup thêm người dùng -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm loại tin tức</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.loaitintuc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="Ten" class="col-sm-3 col-form-label">Tên loại tin tức</label>
                            <div class="col-sm-9">
                                <input id="Ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên loại tin tức" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả"></textarea>
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
                    <th>Loại tin tức</th>
                    <th>Mô tả</th>
                    <th>Số lượng tin tức</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loaitintuc as $ltt)
                    <tr>
                        <td>{{ $loop->iteration + ($loaitintuc->currentPage() - 1) * $loaitintuc->perPage() }}</td>
                        <td>{{ $ltt->ten }}</td>


                        <td style="width: 600px">{{ $ltt->mota }}</td>
                        <td>{{ $ltt->tin_tuc_count }}</td> <!-- Số lượng tin tức -->
                        <td>
                            <!-- Nút Sửa -->
                        <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $ltt->idltt }}">Sửa</button>
                        <!-- Popup sửa địa chỉ -->
                        <div class="modal fade" id="edit-modal-{{ $ltt->idltt }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa loại tin tức</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.loaitintuc.update', $ltt->idltt) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3 row">
                                                <label for="ten" class="col-sm-3 col-form-label">Tên loại tin tức</label>
                                                <div class="col-sm-9">
                                                    <input id="ten" type="text" class="form-control" name="ten" value="{{ $ltt->ten }}"  required placeholder="Nhập tên loại tin tức" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                                                <div class="col-sm-9">
                                                    <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả">{{ $ltt->mota }}</textarea>
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
                        <form action="{{ route('admin.loaitintuc.destroy', $ltt->idltt) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $ltt->idltt }}">Xóa</button>
        
                            <!-- Popup xác nhận xóa -->
                            <div class="modal fade" id="delete-modal-{{ $ltt->idltt }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa loại tin tức này không?
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
                {{ $loaitintuc->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')
    
    <form action="{{ route('admin.loaitintuc.search') }}" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm loại tin tức..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection

