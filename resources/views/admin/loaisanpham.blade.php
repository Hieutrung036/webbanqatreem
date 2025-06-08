@extends('admin.layout.indexmain')
@section('title', 'Loại sản phẩm')

@section('body')
    <h1 style="font-size: 20px">LOẠI SẢN PHẨM</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý sản phẩm</li>
            <li class="breadcrumb-item active">Loại sản phẩm</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <a href="{{ route('admin.danhmucsanpham') }}" class="btn btn-success">
        Danh mục sản phẩm
    </a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm loại sản phẩm
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
    
    <!-- popup thêm loại sản phẩm  -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm loại sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.loaisanpham.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên loại sản phẩm</label>
                            <div class="col-sm-9">
                                <input id="Ten" type="text" class="form-control" name="ten" required placeholder="Nhập tên loại sản phẩm" />
                            </div>
                        </div>

                        {{-- <div class="mb-3 row">
                            <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả"></textarea>
                            </div>
                        </div>
                         --}}
                       

                        
                        <div class="mb-3 row">
                            <label for="iddm" class="col-sm-3 col-form-label">Danh mục sản phẩm</label>
                            <div class="col-sm-9">
                                <select id="iddm" name="iddm" class="form-control">
                                    <option >Chọn loại danh mục</option>

                                    @foreach ($danhmucsanpham as $dmsp)
                                        <option value="{{ $dmsp->iddm }}">{{ $dmsp->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Số lượng sản phẩm -->


                        <!-- Chọn hình ảnh -->
                         
                        {{-- <div class="mb-3 row">
                            <label for="hinhanh" class="col-sm-3 col-form-label">Hình ảnh</label>
                            <div class="col-sm-9">
                                <input type="file" id="hinhanh" name="hinhanh" accept="image/jpeg, image/png"
                                    class="form-control" onchange="previewImage(event, 'preview-main-image-add')" required>
                            </div>
                            <div class="col-sm-12">
                                <img id="preview-main-image-add" src="#" alt="Xem trước hình ảnh"
                                    style="max-width: 100%; margin-top: 10px; display: none;">
                            </div>
                        </div> --}}
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
                    <th>Loại sản phẩm</th>
                    <th>Danh mục sản phẩm</th>
                    <th>Số lượng sản phẩm</th>

                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($loaisanpham as $lsp)
                    <tr>
                        <td>{{ $loop->iteration + ($loaisanpham->currentPage() - 1) * $loaisanpham->perPage() }}</td>
                        <td>{{ $lsp->ten }}</td>
                        <td>{{ $lsp->danhmucsanpham->ten }}</td>

                        <td>0</td>

                        <td>

                        
                             <!-- Nút Sửa -->
                        <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $lsp->idlsp }}">Sửa</button>
                        <!-- Popup sửa địa chỉ -->
                        <div class="modal fade" id="edit-modal-{{ $lsp->idlsp }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa loại sản phẩm</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.loaisanpham.update', $lsp->idlsp) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                        
                                           
                                            <div class="mb-3 row">
                                                <label for="ten" class="col-sm-3 col-form-label">Tên loại sản phẩm</label>
                                                <div class="col-sm-9">
                                                    <input id="ten" type="text" class="form-control" name="ten" value="{{ $lsp->ten }}"  required placeholder="Nhập tên loại sản phẩm" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="iddm" class="col-sm-3 col-form-label">Danh mục sản phẩm</label>
                                                <div class="col-sm-9">
                                                    <select id="iddm" name="iddm" class="form-control">
                                                        @foreach ($danhmucsanpham as $dmsp)
                                                            <option value="{{ $dmsp->iddm }}" {{ isset($lsp) && $lsp->iddm == $dmsp->iddm ? 'selected' : '' }}>
                                                                {{ $dmsp->ten }}
                                                            </option>
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
                        <!-- Nút Xóa -->
                        <form action="{{ route('admin.loaisanpham.destroy', $lsp->idlsp) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $lsp->idlsp }}">Xóa</button>
        
                            <!-- Popup xác nhận xóa -->
                            <div class="modal fade" id="delete-modal-{{ $lsp->idlsp }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa loại sản phẩm này không?
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
                {{ $loaisanpham->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')
    <form action="{{ route('admin.loaisanpham.search') }}" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm loại sản phẩm..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection