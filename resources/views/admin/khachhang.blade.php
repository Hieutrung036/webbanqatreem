@extends('admin.layout.indexmain')
@section('title', 'Khách hàng')

@section('body')
    <h1 style="font-size: 20px">KHÁCH HÀNG</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý khách hàng</li>
            <li class="breadcrumb-item active">Danh sách khách hàng</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm khách hàng
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
    <!-- popup thêm khách hàng -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.khachhang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên khách hàng</label>
                            <div class="col-sm-9">
                                <input id="ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên khách hàng" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                            <div class="col-sm-9">
                                <input id="sdt" type="text" class="form-control" name="sdt" required
                                    placeholder="Nhập số điện thoại" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input id="email" type="text" class="form-control" name="email" required
                                    placeholder="Nhập email" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="matkhau" class="col-sm-3 col-form-label">Mật khẩu</label>
                            <div class="col-sm-9">
                                <input id="matkhau" type="password" class="form-control" name="matkhau"
                                    autocomplete="matkhau" placeholder="Nhập mật khẩu" />
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
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($khachhang as $kh)
                    <tr>
                        <td>{{ $loop->iteration + ($khachhang->currentPage() - 1) * $khachhang->perPage() }}</td>
                        <td>{{ $kh->ten }}</td>
                        <td>0{{ $kh->sdt }}</td>
                        <td>{{ $kh->email }}</td>
                        <td>
                            <!-- Nút Sửa -->
                             <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $kh->idkh }}">Sửa</button>
                            <!-- Popup sửa màu -->
                            <div class="modal fade" id="edit-modal-{{ $kh->idkh }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa khách hàng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.khachhang.update', $kh->idkh) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3 row">
                                                    <label for="ten" class="col-sm-3 col-form-label">Tên khách hàng</label>
                                                    <div class="col-sm-9">
                                                        <input id="ten" type="text" class="form-control" name="ten" value="{{ $kh->ten }}"  required placeholder="Nhập tên khách hàng" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                                                    <div class="col-sm-9">
                                                        <input id="sdt" type="text" class="form-control" name="sdt" value="{{ $kh->sdt }}"  required placeholder="Nhập số điện thoại" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input id="email" type="text" class="form-control" name="email" value="{{ $kh->email }}"  required placeholder="Nhập email" />
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
                            <form action="{{ route('admin.khachhang.block', $kh->idkh) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT') <!-- Thay DELETE thành PUT vì chúng ta đang cập nhật trạng thái -->
    
    @if($kh->block == 0)
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $kh->idkh }}">Chặn</button>
    @else
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $kh->idkh }}">Bỏ chặn</button>
    @endif

    <!-- Modal xác nhận chặn hoặc bỏ chặn -->
    <div class="modal fade" id="delete-modal-{{ $kh->idkh }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $kh->block == 0 ? 'Xác nhận chặn' : 'Xác nhận bỏ chặn' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn {{ $kh->block == 0 ? 'chặn' : 'bỏ chặn' }} khách hàng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    
                    <!-- Submit form, hành động sẽ phụ thuộc vào trạng thái block -->
                    <button type="submit" class="btn {{ $kh->block == 0 ? 'btn-danger' : 'btn-success' }}">
                        {{ $kh->block == 0 ? 'Chặn' : 'Bỏ chặn' }}
                    </button>
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

        <!-- Hiển thị phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $khachhang->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>



@endsection


@section('search')

    <form action="{{ route('admin.khachhang.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm khách hàng..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
