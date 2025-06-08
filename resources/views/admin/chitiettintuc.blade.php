@extends('admin.layout.indexmain')
@section('title', 'Chi tiết tin tức')

@section('body')
    <h1 style="font-size: 20px">CHI TIẾT TIN TỨC</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item">Chi tiết tin tức</li>
            <li class="breadcrumb-item active">{{ $tintuc->tieude }}</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm nội dung bài viết
    </button>
    <a href="{{ route('admin.tintuc') }}" class="btn btn-success">
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


    {{-- them --}}
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.chitiettintuc.themchitiet', ['id' => $tintuc->idtt]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <style>
                            .ck-editor__editable {
                                max-width: 600px;
                                /* Chiều rộng tối đa */
                                width: 100%;
                                /* Chiều rộng tự động */
                                min-height: 300px;
                                /* Chiều cao tối thiểu */
                                overflow-y: auto;
                                /* Thêm thanh cuộn dọc nếu nội dung vượt quá chiều cao tối đa */
                            }
                        </style>

                        <div class="mb-3 row">
                            <label for="noidung" class="col-sm-3 col-form-label">Nội dung</label>
                            <div class="col-sm-9">
                                <textarea id="noidung" name="noidung" class="form-control" rows="15" placeholder="Nhập nội dung"></textarea>
                            </div>
                        </div>

                        <!-- Hình chính -->
                        <div class="mb-3 row">
                            <label for="hinhchinh" class="col-sm-3 col-form-label">Hình chính</label>
                            <div class="col-sm-9">
                                <input type="file" id="hinhchinh" name="hinhchinh" accept="image/jpeg, image/png"
                                    class="form-control" onchange="previewImage(event, 'preview-main-image')" required>
                            </div>
                            <div class="col-sm-12">
                                <img id="preview-main-image" src="#" alt="Xem trước hình chính"
                                    style="max-width: 100%; margin-top: 10px; display: none;"
                                    onclick="event.stopPropagation();">
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




    <div class="product-details">
        <table class="table table-form" id="dataTable" width="100%" cellspacing="0">
            <tr>
                <td width="200px">Tiêu đề:</td>
                <td colspan="4">{{ $tintuc->tieude }}</td>
            </tr>
            <tr>
                <td width="200px">Ngày đăng:</td>
                <td colspan="4">{{ $tintuc->ngaydang }}</td>
            </tr>
            <tr>
                <td width="200px">Loại tin tức:</td>
                <td colspan="4">{{ $tintuc->loaitintuc->ten }}</td>
            </tr>
            <tr>
                <td width="200px">Nội dung:</td>
                <td colspan="3" width="700px"
                    style="max-width: 700px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $tintuc->noidung }}
                </td>
                <td colspan="0">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-modal">Cập nhật</button>
                    <div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập nhật bài viết</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <style>
                                            .ck-editor__editable_inline {
                                                max-width: 600px;
                                                /* Giới hạn chiều rộng tối đa */
                                                min-height: 300px;
                                                /* Chiều cao tối thiểu */
                                                overflow-y: auto;
                                                /* Thêm thanh cuộn dọc nếu nội dung vượt quá chiều cao */
                                            }
                                        </style>

                                        <div class="mb-3 row">
                                            <label for="noidung" class="col-sm-3 col-form-label">Nội dung</label>
                                            <div class="col-sm-9">
                                                <textarea id="noidung" name="noidung" class="form-control" rows="15" placeholder="Nhập nội dung">{{$tintuc->noidun}}</textarea>
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
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add-product">
                        Xóa
                    </button>
                </td>
            </tr>
            <tr>
                <td width="200px">Hình ảnh chính:</td>

                <td colspan="3" width="700px">

                        @foreach ($tintuc->hinhanh as $hinh)
                                <img src="{{ asset('uploads/' . $hinh->duongdan) }}" alt="Hình ảnh chính"
                                    style="max-width: 100%; margin-top: 10px;">
                        @endforeach
                    
                </td>
                <td colspan="0">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
                        Cập nhật
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add-product">
                        Xóa
                    </button>
                </td>
            </tr>

        </table>
    </div>
@endsection

@section('search')
    <form action="" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>
@endsection
