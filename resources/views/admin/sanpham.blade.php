@extends('admin.layout.indexmain')
@section('title', 'Sản phẩm')

@section('body')
    <h1 style="font-size: 20px">DANH SÁCH SẢN PHẨM</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý sản phẩm</li>
            <li class="breadcrumb-item active">Danh sách sản phẩm</li>
        </ol>
    </nav>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
        Thêm sản phẩm
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
    <!-- popup thêm sản phẩm -->
    <div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.sanpham.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="ten" class="col-sm-3 col-form-label">Tên sản phẩm</label>
                            <div class="col-sm-9">
                                <input id="ten" type="text" class="form-control" name="ten" required
                                    placeholder="Nhập tên sản phẩm" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="gia" class="col-sm-3 col-form-label">Giá</label>
                            <div class="col-sm-9">
                                <input id="gia" type="text" class="form-control" name="gia" required
                                    placeholder="Nhập giá" />
                            </div>
                        </div>


                        <div class="mb-3 row">

                            <div class="col-sm-3 d-flex align-items-center">
                                <label for="noibat" class="form-label me-2">Nổi bật</label>
                                <input id="noibat" type="checkbox" name="noibat" value="1" />
                            </div>
                            <div class="col-sm-3 d-flex align-items-center">
                                <label for="moi" class="form-label me-2">Mới</label>
                                <input id="moi" type="checkbox" name="moi" value="1" />
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="chatlieu" class="col-sm-3 col-form-label">Chất liệu</label>
                            <div class="col-sm-9">
                                <input id="chatlieu" type="text" class="form-control" name="chatlieu" required
                                    placeholder="Nhập chất liệu" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="idgg" class="col-sm-3 col-form-label">Giảm giá</label>
                            <div class="col-sm-9">
                                <select id="idgg" name="idgg" required class="form-control">
                                    <option value="">Chọn giảm giá</option>
                                    @foreach ($magiamgia as $mgg)
                                        <option value="{{ $mgg->idgg }}">{{ $mgg->code }} @if ($mgg->phantram > 0)
                                                {{ $mgg->phantram }}%
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idth" class="col-sm-3 col-form-label">Thương hiệu</label>
                            <div class="col-sm-9">
                                <select id="idth" name="idth" required class="form-control">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($thuonghieu as $th)
                                        <option value="{{ $th->idth }}">{{ $th->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="idlsp" class="col-sm-3 col-form-label">Loại sản phẩm</label>
                            <div class="col-sm-9">
                                <select id="idlsp" name="idlsp" required class="form-control">
                                    <option value="">Chọn loại sản phẩm</option>
                                    @foreach ($loaisanpham as $lsp)
                                        <option value="{{ $lsp->idlsp }}">
                                            {{ $lsp->ten }} - 
                                            @if ($lsp->danhmucsanpham->gioitinh == 0)
                                                Bé trai
                                            @elseif ($lsp->danhmucsanpham->gioitinh == 1)
                                                Bé gái
                                            @else
                                                Không xác định
                                            @endif
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




    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Chất liệu</th>
                    <th>Nổi bật</th>
                    <th>Mới</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sanpham as $sp)
                    <tr>
                        <td>{{ $loop->iteration + ($sanpham->currentPage() - 1) * $sanpham->perPage() }}</td>
                        <td>{{ $sp->ten }}</td>
                        <td>
                            @php
                                $tongSoLuong = 0;
                            @endphp
                            @foreach ($sp->chitietsanpham as $ctsp)
                                @php
                                    $tongSoLuong += $ctsp->soluong;
                                @endphp
                            @endforeach
                            {{ $tongSoLuong }} cái
                        </td>
                        <td> {{ \Illuminate\Support\Str::limit($sp->mota, 70, '.......') }}
                        </td>

                        <td>{{ number_format($sp->gia, 0, ',', ',') }} VND</td>
                        <td>{{ $sp->chatlieu }}</td>
                        <td>
                            @if ($sp->noibat == 0)
                                Không
                            @else
                                Có
                            @endif
                        </td>
                        <td>
                            @if ($sp->moi == 0)
                                Không
                            @else
                                Có
                            @endif
                        </td>
                        <td>
                            <!-- Nút Sửa -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-modal-{{ $sp->idsp }}">Sửa</button>
                            <!-- Popup sửa-->
                            <div class="modal fade" id="edit-modal-{{ $sp->idsp }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa sản phẩm</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.sanpham.update', $sp->idsp) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3 row">
                                                    <label for="ten" class="col-sm-3 col-form-label">Tên sản
                                                        phẩm</label>
                                                    <div class="col-sm-9">
                                                        <input id="ten" type="text" class="form-control"
                                                            value="{{ $sp->ten }}" name="ten" required
                                                            placeholder="Nhập tên sản phẩm" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="mota" class="col-sm-3 col-form-label">Mô tả</label>
                                                    <div class="col-sm-9">
                                                        <textarea id="mota" class="form-control" name="mota" rows="3" required placeholder="Nhập mô tả">{{ $sp->mota }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="gia" class="col-sm-3 col-form-label">Giá</label>
                                                    <div class="col-sm-9">
                                                        <input id="gia" type="text" value="{{ $sp->gia }}"
                                                            class="form-control" name="gia" required
                                                            placeholder="Nhập giá" />
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="noibat" class="form-label me-2">Nổi bật</label>
                                                        <input id="noibat" type="checkbox" name="noibat"
                                                            value="1" {{ $sp->noibat ? 'checked' : '' }} />
                                                    </div>
                                                    <div class="col-sm-3 d-flex align-items-center">
                                                        <label for="moi" class="form-label me-2">Mới</label>
                                                        <input id="moi" type="checkbox" name="moi"
                                                            value="1" {{ $sp->moi ? 'checked' : '' }} />
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="chatlieu" class="col-sm-3 col-form-label">Chất
                                                        liệu</label>
                                                    <div class="col-sm-9">
                                                        <input id="chatlieu" type="text" class="form-control"
                                                            name="chatlieu" value="{{ $sp->chatlieu }}" required
                                                            placeholder="Nhập chất liệu" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="idgg" class="col-sm-3 col-form-label">Giảm giá</label>
                                                    <div class="col-sm-9">
                                                        <select id="idgg" name="idgg" required
                                                            class="form-control">
                                                            <option value="">Chọn giảm giá</option>
                                                            @foreach ($magiamgia as $mgg)
                                                                <option value="{{ $mgg->idgg }}"
                                                                    {{ $mgg->idgg == $sp->idgg ? 'selected' : '' }}>
                                                                    {{ $mgg->code }} @if ($mgg->phantram > 0)
                                                                        {{ $mgg->phantram }}%
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="mb-3 row">
                                                    <label for="idth" class="col-sm-3 col-form-label">Thương
                                                        hiệu</label>
                                                    <div class="col-sm-9">
                                                        <select id="idth" name="idth" required
                                                            class="form-control">
                                                            <option value="">Chọn thương hiệu</option>
                                                            @foreach ($thuonghieu as $th)
                                                                <option value="{{ $th->idth }}"
                                                                    {{ $th->idth == $sp->idth ? 'selected' : '' }}>
                                                                    {{ $th->ten }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="idlsp" class="col-sm-3 col-form-label">Loại sản
                                                        phẩm</label>
                                                    <div class="col-sm-9">
                                                        <select id="idlsp" name="idlsp" required
                                                            class="form-control">
                                                            <option value="">Chọn loại sản phẩm</option>
                                                            @foreach ($loaisanpham as $lsp)
                                                                <option value="{{ $lsp->idlsp }}"
                                                                    {{ $lsp->idlsp == $sp->idlsp ? 'selected' : '' }}>
                                                                    {{ $lsp->ten }} - 
                                                                    @if ($lsp->danhmucsanpham->gioitinh == 0)
                                                                        Bé trai
                                                                    @elseif ($lsp->danhmucsanpham->gioitinh == 1)
                                                                        Bé gái
                                                                    @else
                                                                        Không xác định
                                                                    @endif
                                                                    
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
                            <form action="{{ route('admin.sanpham.destroy', $sp->idsp) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-modal-{{ $sp->idsp }}">Xóa</button>

                                <!-- Popup xác nhận xóa -->
                                <div class="modal fade" id="delete-modal-{{ $sp->idsp }}" tabindex="-1"
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

                            <a href="{{ route('admin.chitietsanpham', $sp->idsp) }}" class="btn btn-primary">Chi tiết</a>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $sanpham->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
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
