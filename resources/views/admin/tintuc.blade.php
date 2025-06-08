@extends('admin.layout.indexmain')
@section('title', 'Tin tức')

@section('body')
    <h1 style="font-size: 20px">TIN TỨC</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý tin tức</li>
            <li class="breadcrumb-item active">Danh sách tin tức</li>
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
        Thêm tin tức
    </button>

    <!-- popup thêm người dùng -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm tin tức</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.tintuc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="tieude" class="col-sm-3 col-form-label">Tiêu đề</label>
                            <div class="col-sm-9">
                                <input id="tieude" type="text" class="form-control" name="tieude" required
                                    placeholder="Nhập tiêu đề" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="noidung" class="form-label">Nội dung</label>
                            <textarea id="noidung" name="noidung" class="form-control"  rows="11"></textarea>
                        </div>
                        <div class="mb-3 row">
                            <label for="hinhchinh" class="col-sm-3 col-form-label">Hình chính</label>
                            <div class="col-sm-9">
                                <input type="file" id="hinhchinh" name="hinhchinh" accept="image/jpeg, image/png"
                                    class="form-control" onchange="previewImage(event, 'preview-main-image-add')" required>
                            </div>
                            <div class="col-sm-12">
                                <img id="preview-main-image-add" src="#" alt="Xem trước hình chính"
                                    style="max-width: 100%; margin-top: 10px; display: none;">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-3 d-flex align-items-center">
                                <label for="noibat" class="form-label me-2">Nổi bật</label>
                                <input id="noibat" type="checkbox" name="noibat" value="1" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idltt" class="col-sm-3 col-form-label">Loại tin tức</label>
                            <div class="col-sm-9">
                                <select id="idltt" name="idltt" required class="form-control">
                                    <option value="">Chọn loại tin tức</option>
                                    @foreach ($loaitintuc as $ltt)
                                        <option value="{{ $ltt->idltt }}">{{ $ltt->ten }} </option>
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
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Nổi bật</th>

                    <th>Loại tin tức</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tintuc as $tt)
                    <tr>
                        <td>{{ $loop->iteration + ($tintuc->currentPage() - 1) * $tintuc->perPage() }}</td>
                        <td style="width:500px">{{ $tt->tieude }}</td>
                        <td style="width:200px">{{ \Carbon\Carbon::parse($tt->ngaydang)->format('Y-m-d') }}</td>
                        <td>
                            @if ($tt->noibat == 1)
                               Có
                            @else
                                Không
                            @endif
                        </td>

                        <td>{{ $tt->loaitintuc->ten }}</td>

                        <td>
                            <!-- Nút Sửa -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $tt->idtt }}">Sửa</button>
                            <!-- Popup sửa tin tức -->
                            <div class="modal fade" id="edit-modal-{{ $tt->idtt }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa tin tức</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.tintuc.update', $tt->idtt) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                            
                                                <div class="mb-3 row">
                                                    <label for="tieude" class="col-sm-3 col-form-label">Tiêu đề</label>
                                                    <div class="col-sm-9">
                                                        <input id="tieude" type="text" class="form-control" name="tieude" value="{{ $tt->tieude }}" required placeholder="Nhập tiêu đề" />
                                                    </div>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="noidung" class="form-label">Nội dung</label>
                                                    <textarea id="noidung-{{ $tt->idtt }}" name="noidung" class="form-control"  rows="11">{{ $tt->noidung }}</textarea>
                                                </div>
                            
                                                <div class="mb-3 row">
                                                    <label for="hinhchinh" class="col-sm-3 col-form-label">Hình chính</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" id="hinhchinh" name="hinhchinh" accept="image/jpeg, image/png" class="form-control" onchange="previewImage(event, 'preview-main-image-edit-{{ $tt->idtt }}')">
                                                    </div>
                                                    <div class="col-sm-12 mt-2">
                                                        @if ($tt->hinhanh)
                                                            <img id="preview-main-image-edit-{{ $tt->idtt }}" src="{{ asset('uploads/tintuc/' . $tt->hinhanh) }}" alt="Xem trước hình chính" style="max-width: 100%;">
                                                        @else
                                                            <img id="preview-main-image-edit-{{ $tt->idtt }}" src="#" alt="Xem trước hình chính" style="display: none;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="noibat" class="form-label me-2">Nổi bật</label>
                                                        <input id="noibat" type="checkbox" name="noibat" value="1" {{ $tt->noibat == 1 ? 'checked' : '' }} />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="idltt" class="col-sm-3 col-form-label">Loại tin tức</label>
                                                    <div class="col-sm-9">
                                                        <select id="idltt" name="idltt" required class="form-control">
                                                            <option value="">Chọn loại tin tức</option>
                                                            @foreach ($loaitintuc as $ltt)
                                                                <option value="{{ $ltt->idltt }}" {{ $tt->idltt == $ltt->idltt ? 'selected' : '' }}>
                                                                    {{ $ltt->ten }}
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
                            <form action="{{ route('admin.tintuc.destroy', $tt->idtt) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $tt->idtt }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $tt->idtt }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa tin tức này không?
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
                {{ $tintuc->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>

@endsection


@section('search')
    
    <form action="{{ route('admin.tintuc.search') }}" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm tin tức..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection

