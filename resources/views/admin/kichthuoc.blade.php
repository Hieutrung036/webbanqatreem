@extends('admin.layout.indexmain')
@section('title', 'Kích thước')

@section('body')
<h1 style="font-size: 20px">KÍCH THƯỚC</h1>
<nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý sản phẩm</li>
        <li class="breadcrumb-item active">Kích thước</li>
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
        Thêm kích thước
    </button>
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm kích thước</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.kichthuoc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="Ten" class="col-sm-3 col-form-label">Tên kích thước</label>
                            <div class="col-sm-9">
                                <input id="Ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên kích thước" />
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
                    <th>Kích thước</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kichthuoc as $kt)
                <tr>
                    <td>{{ $loop->iteration + ($kichthuoc->currentPage() - 1) * $kichthuoc->perPage() }}</td>
                    <td>{{ $kt->ten }}</td>
                    
                    <td >{{ $kt->mota }}</td>
                  
                    <td>
                       
                        <!-- Nút Sửa -->
                        <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $kt->idkt }}">Sửa</button>
                        <!-- Popup sửa địa chỉ -->
                        <div class="modal fade" id="edit-modal-{{ $kt->idkt }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa kích thước</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.kichthuoc.update', $kt->idkt) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3 row">
                                                <label for="ten" class="col-sm-3 col-form-label">Tên kích thước</label>
                                                <div class="col-sm-9">
                                                    <input id="ten" type="text" class="form-control" name="ten" value="{{ $kt->ten }}"  required placeholder="Nhập tên kích thước" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                                                <div class="col-sm-9">
                                                    <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả">{{ $kt->mota }}</textarea>
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
                        <form action="{{ route('admin.kichthuoc.destroy', $kt->idkt) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $kt->idkt }}">Xóa</button>
        
                            <!-- Popup xác nhận xóa -->
                            <div class="modal fade" id="delete-modal-{{ $kt->idkt }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa kích thước này không?
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
                {{ $kichthuoc->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')
    
    <form action="{{ route('admin.kichthuoc.search') }}" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm kích thước..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
