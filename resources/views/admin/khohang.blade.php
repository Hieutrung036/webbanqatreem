@extends('admin.layout.indexmain')
@section('title', 'Kho hàng')

@section('body')
    <h1 style="font-size: 20px">KHO</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý kho</li>
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

        <div >
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Thông tin sản phẩm</th>
                        <th>Thông tin nhập kho</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Thông tin sản phẩm -->
                        <td>
                            <div class="product-info">
                                <img src="https://via.placeholder.com/100" alt="Sản phẩm">
                                <div>
                                    <h5>Tên sản phẩm: Tên sản phẩm</h5>
                                    <p>Kích thước: L, Màu: Đỏ</p>
                                    <p>Giá: 500,000 VNĐ</p>
                                </div>
                            </div>
                        </td>
        
                        <!-- Form nhập kho -->
                        <td>
                            <form action="#" method="POST">
                                <div class="form-row">
                                    <!-- Tên sản phẩm -->
                                    <div class="form-group col-md-4">
                                        <label for="tensanpham">Tên sản phẩm:</label>
                                        <select name="tensanpham" id="tensanpham" class="form-control" required>
                                            <option value="">Chọn sản phẩm</option>
                                            <option value="1">Sản phẩm 1</option>
                                            <option value="2">Sản phẩm 2</option>
                                            <option value="3">Sản phẩm 3</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Số lượng -->
                                    <div class="form-group col-md-4">
                                        <label for="soluong">Số lượng:</label>
                                        <input type="number" name="soluong" id="soluong" class="form-control" required min="1">
                                    </div>
                        
                                    <!-- Nhà cung cấp -->
                                    <div class="form-group col-md-4">
                                        <label for="nhacungcap">Nhà cung cấp:</label>
                                        <input type="text" name="nhacungcap" id="nhacungcap" class="form-control" required>
                                    </div>
                                </div>
                        
                                <button type="submit" class="btn btn-primary">Nhập Kho</button>
                            </form>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        
        {{-- <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $kichthuoc->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav> --}}
    </div>

@endsection


@section('search')

    <form action="" method="GET"
        class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm kích thước..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
