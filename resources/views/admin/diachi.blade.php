@extends('admin.layout.indexmain')
@section('title', 'Địa chỉ')

@section('body')
    <h1 style="font-size: 20px">ĐỊA CHỈ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý khách hàng</li>
            <li class="breadcrumb-item active">Địa chỉ</li>
        </ol>
    </nav>

    <!-- Nút mở popup -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm địa chỉ
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
    <!-- popup thêm địa chỉ -->
    
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm địa chỉ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.diachi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="tennguoinhan" class="col-sm-3 col-form-label">Tên người nhận</label>
                            <div class="col-sm-9">
                                <input id="tennguoinhan" type="text" class="form-control" name="tennguoinhan"
                                    required placeholder="Nhập tên người nhận" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                            <div class="col-sm-9">
                                <input id="sdt" type="tel" class="form-control" name="sdt" required
                                    placeholder="Nhập số điện thoại" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="diachi" class="col-sm-3 col-form-label">Địa chỉ</label>
                            <div class="col-sm-9">
                                <input id="diachi" type="text" class="form-control" name="diachi" required
                                    placeholder="Nhập địa chỉ" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phuongxa" class="col-sm-3 col-form-label">Phường / Xã</label>
                            <div class="col-sm-9">
                                <input id="phuongxa" type="text" class="form-control" name="phuongxa" required
                                    placeholder="Nhập phường / xã" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="quanhuyen" class="col-sm-3 col-form-label">Quận / Huyện</label>
                            <div class="col-sm-9">
                                <input id="quanhuyen" type="text" class="form-control" name="quanhuyen" required
                                    placeholder="Nhập quận / huyện" />
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="tinhthanhpho" class="col-sm-3 col-form-label">Tỉnh / Thành phố</label>
                            <div class="col-sm-9">
                                <input id="tinhthanhpho" type="text" class="form-control" name="tinhthanhpho"
                                    required placeholder="Nhập tỉnh / thành phố" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idkh" class="col-sm-3 col-form-label">Khách hàng</label>
                            <div class="col-sm-9">
                                <select id="idkh" name="idkh" required class="form-control">
                                    <option value="">Chọn khách hàng</option> <!-- Tùy chọn mặc định -->
                                    @foreach ($khachhang as $kh)
                                        <!-- Lặp qua danh sách người dùng -->
                                        <option value="{{ $kh->idkh }}">{{ $kh->ten }}</option>
                                        <!-- Hiển thị tên người dùng -->
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
                    <th>Tên người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Phường / Xã</th>
                    <th>Quận / Huyện</th>
                    <th>Tỉnh / Thành Phố</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diachi as $dc)
                    <tr>
                        <td>{{ $loop->iteration + ($diachi->currentPage() - 1) * $diachi->perPage() }}</td>
                        <td>{{ $dc->tennguoinhan }}</td>
                        <td>0{{ $dc->sdt }}</td>
                        <td style="width:300px">{{ $dc->diachi }}</td>
                        <td>{{ $dc->phuongxa }}</td>
                        <td>{{ $dc->quanhuyen }}</td>
                        <td>{{ $dc->tinhthanhpho }}</td>
                        <td>
                            <!-- Nút Sửa -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $dc->iddc }}">Sửa</button>
                            <!-- Popup sửa địa chỉ -->
                            <div class="modal fade" id="edit-modal-{{ $dc->iddc }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa địa chỉ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.diachi.update', $dc->iddc) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="mb-3 row">
                                                    <label for="tennguoinhan" class="col-sm-3 col-form-label">Tên người nhận</label>
                                                    <div class="col-sm-9">
                                                        <input id="tennguoinhan" type="text" class="form-control" value="{{ $dc->tennguoinhan }}" name="tennguoinhan"
                                                            required placeholder="Nhập tên người nhận" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="sdt" class="col-sm-3 col-form-label">Số điện thoại</label>
                                                    <div class="col-sm-9">
                                                        <input id="sdt" type="tel" class="form-control" value="{{ $dc->sdt }}" name="sdt" required
                                                            placeholder="Nhập số điện thoại" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="diachi" class="col-sm-3 col-form-label">Địa chỉ</label>
                                                    <div class="col-sm-9">
                                                        <input id="diachi" type="text" class="form-control" value="{{ $dc->diachi }}" name="diachi" required
                                                            placeholder="Nhập địa chỉ" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="phuongxa" class="col-sm-3 col-form-label">Phường / Xã</label>
                                                    <div class="col-sm-9">
                                                        <input id="phuongxa" type="text" class="form-control" value="{{ $dc->phuongxa }}" name="phuongxa" required
                                                            placeholder="Nhập phường / xã" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="quanhuyen" class="col-sm-3 col-form-label">Quận / Huyện</label>
                                                    <div class="col-sm-9">
                                                        <input id="quanhuyen" type="text" class="form-control" value="{{ $dc->quanhuyen }}" name="quanhuyen" required
                                                            placeholder="Nhập quận / huyện" />
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3 row">
                                                    <label for="tinhthanhpho" class="col-sm-3 col-form-label">Tỉnh / Thành phố</label>
                                                    <div class="col-sm-9">
                                                        <input id="tinhthanhpho" type="text" class="form-control" value="{{ $dc->tinhthanhpho }}" name="tinhthanhpho"
                                                            required placeholder="Nhập tỉnh / thành phố" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="idkh" class="col-sm-3 col-form-label">Người dùng</label>
                                                    <div class="col-sm-9">
                                                        <select id="idkh" name="idkh" required class="form-control">
                                                            <option value="">Chọn người dùng</option> <!-- Tùy chọn mặc định -->
                                                            @foreach ($khachhang as $kh)
                                                                <option value="{{ $kh->idkh }}"
                                                                    {{ $kh->idkh == $dc->idkh ? 'selected' : '' }}>
                                                                    {{ $kh->ten }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                            <form action="{{ route('admin.diachi.destroy', $dc->iddc) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $dc->iddc }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $dc->iddc }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa địa chỉ này không?
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
                {{ $diachi->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')

    <form action="{{ route('admin.diachi.search') }}" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm địa chỉ..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
