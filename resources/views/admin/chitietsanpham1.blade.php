@extends('admin.layout.indexmain')
@section('title', 'Chi tiết sản phẩm')

@section('body')
    <h1 style="font-size: 20px">SẢN PHẨM</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Chi tiết sản phẩm</li>
            <li class="breadcrumb-item active">{{ $sanpham->ten }}</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm màu và size
    </button>
    <a href="{{ route('admin.chitietsanpham', $sanpham->idsp) }}" class="btn btn-success">
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

    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm màu và kích thước</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.chitietsanpham1.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên sản phẩm</label>
                            <div class="col-sm-9">
                                <select id="idsp" name="idsp" required class="form-control">

                                    <option value="{{ $sanpham->idsp }}">{{ $sanpham->ten }}</option>
                                </select>
                            </div>
                        </div>




                        <div class="mb-3 row">
                            <label for="idm" class="col-sm-3 col-form-label">Màu</label>
                            <div class="col-sm-9">
                                <select id="idm" name="idm" required class="form-control">
                                    <option value="">Chọn màu</option>
                                    @foreach ($mau as $m)
                                        <option value="{{ $m->idm }}">{{ $m->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idkt" class="col-sm-3 col-form-label">Kích thước</label>
                            <div class="col-sm-9">
                                <select id="idkt" name="idkt" required class="form-control">
                                    <option value="">Chọn kích thước</option>
                                    @foreach ($kichthuoc as $kt)
                                        <option value="{{ $kt->idkt }}">{{ $kt->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="soluong" class="col-sm-3 col-form-label">Số lượng</label>
                            <div class="col-sm-9">
                                <input id="soluong" type="text" class="form-control" name="soluong" required
                                    placeholder="Nhập số lượng" />
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
                    <th>Màu</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sanpham->chitietsanpham as $ctsp)
                    <tr>
                        <td>{{ $loop->iteration + ($chitietsanpham->currentPage() - 1) * $chitietsanpham->perPage() }}</td>
                        <td>{{ $ctsp->mau->ten }}</td>
                        <td>{{ $ctsp->kichthuoc->ten }}</td>
                        <td>{{ $ctsp->soluong }}</td>

                        <td>
                            <!-- Nút Sửa -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $ctsp->idctsp }}">Sửa</button>
                            <!-- Popup sửa-->
                            <div class="modal fade" id="edit-modal-{{ $ctsp->idctsp }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa size và màu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.chitietsanpham1.update', $ctsp->idctsp) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="idsp" value="{{ $ctsp->idsp }}" />

                                                <div class="mb-3 row">
                                                    <label for="idm" class="col-sm-3 col-form-label">Màu</label>
                                                    <div class="col-sm-9">
                                                        <select id="idm" name="idm" required class="form-control">
                                                            <option value="">Chọn màu</option>
                                                            @foreach ($mau as $m)
                                                                <option value="{{ $m->idm }}" {{ $m->idm == $ctsp->idm ? 'selected' : '' }}>
                                                                    {{ $m->ten }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                            
                                                <div class="mb-3 row">
                                                    <label for="idkt" class="col-sm-3 col-form-label">Size</label>
                                                    <div class="col-sm-9">
                                                        <select id="idkt" name="idkt" required class="form-control">
                                                            <option value="">Chọn kích thước</option>
                                                            @foreach ($kichthuoc as $kt)
                                                                <option value="{{ $kt->idkt }}" {{ $kt->idkt == $ctsp->idkt ? 'selected' : '' }}>
                                                                    {{ $kt->ten }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                            
                                                <div class="mb-3 row">
                                                    <label for="soluong" class="col-sm-3 col-form-label">Số lượng</label>
                                                    <div class="col-sm-9">
                                                        <input id="soluong" type="number" value="{{ $ctsp->soluong }}" class="form-control" name="soluong" required placeholder="Nhập số lượng" />
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
                            <form action="{{ route('admin.chitietsanpham1.destroy', $ctsp->idctsp) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $ctsp->idctsp }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $ctsp->idctsp }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa sản phẩm này không?
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
        
    </div>
@endsection


@section('search')

    <form action="{{ route('admin.sanpham.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
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
