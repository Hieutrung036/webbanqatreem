@extends('admin.layout.indexmain')
@section('title', 'Nhân viên')

@section('body')
    <h1 style="font-size: 20px">NHÂN VIÊN</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý nhân viên</li>
            <li class="breadcrumb-item active">Danh sách nhân viên</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm nhân viên
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
    <!-- popup thêm nhân viên -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.nhanvien.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên nhân viên</label>
                            <div class="col-sm-9">
                                <input id="ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên nhân viên" />
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
                            <label for="ten" class="col-sm-3 col-form-label">Chức vụ</label>
                            <div class="col-sm-9">
                                <input id="chucvu" type="text" class="form-control" name="chucvu" required
                                    placeholder="Nhập chức vụ" />
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
                    <th>Tên nhân viên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Mật khẩu</th>

                    <th>Chức vụ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nhanvien as $nv)
                    <tr>
                        <td>{{ $loop->iteration + ($nhanvien->currentPage() - 1) * $nhanvien->perPage() }}</td>
                        <td>{{ $nv->ten }}</td>
                        <td>0{{ $nv->sdt }}</td>
                        <td>{{ $nv->email }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doipassword-{{ $nv->idnv }}">
                                Thay đổi mật khẩu
                            </button>
                        </td>
                        <div class="modal fade" id="doipassword-{{ $nv->idnv }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.nhanvien.updatepassword', $nv->idnv) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="idnv" value="{{ $nv->idnv }}">
                                            <div class="mb-3 row">
                                                <label for="matkhau" class="col-sm-4 col-form-label">Nhập mật khẩu mới</label>
                                                <div class="col-sm-8">
                                                    <input id="matkhau" type="password" class="form-control" name="matkhau" required placeholder="Nhập mật khẩu mới" />
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
                        
                        
                    
                        <td>{{ $nv->chucvu }}</td>

                        <td>
                            <!-- Nút Sửa -->
                             <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $nv->idnv }}">Sửa</button>
                            <!-- Popup sửa màu -->
                            <div class="modal fade" id="edit-modal-{{ $nv->idnv }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa nhân viên</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.nhanvien.update', $nv->idnv) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3 row">
                                                    <label for="ten" class="col-sm-3 col-form-label">Tên nhân viên</label>
                                                    <div class="col-sm-9">
                                                        <input id="ten" type="text" class="form-control" name="ten" value="{{ $nv->ten }}"  required placeholder="Nhập tên nhân viên" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                                                    <div class="col-sm-9">
                                                        <input id="sdt" type="text" class="form-control" name="sdt" value="0{{ $nv->sdt }}"  required placeholder="Nhập số điện thoại" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input id="email" type="text" class="form-control" name="email" value="{{ $nv->email }}"  required placeholder="Nhập email" />
                                                    </div>
                                                </div>
                                               
                                                 <div class="mb-3 row">
                                                    <label for="email" class="col-sm-3 col-form-label">Chức vụ</label>
                                                    <div class="col-sm-9">
                                                        <input id="chucvu" type="text" class="form-control" name="chucvu" value="{{ $nv->chucvu }}"  required placeholder="Nhập email" />
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
                            <form action="{{ route('admin.nhanvien.destroy', $nv->idnv) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $nv->idnv }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $nv->idnv }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nhân viên này không?
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

        <!-- Hiển thị phân trang -->
        {{-- <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ nhanvien->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>  --}}
    </div>



@endsection


@section('search')

    <form action="{{ route('admin.nhanvien.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm nhân viên..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
