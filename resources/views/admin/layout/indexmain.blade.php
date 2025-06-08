<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | ADMIN</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

        <a class="navbar-brand mr-1" href="{{ route('admin.trangchu') }}">DASHBOARD</a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>


        @yield('search')
        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <span class="badge badge-danger">9+</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link" href="{{ route('chat.show', 1) }}" id="messagesLink" role="button">
                    <i class="fas fa-envelope fa-fw"></i>
                </a>
            </li>


            <li class="nav-item dropdown no-arrow ">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header text-center" style="font-size: 16px">
                        @if (Auth::guard('nhanvien')->check())
                            @php
                                $nhanvien = Auth::guard('nhanvien')->user();
                            @endphp
                            <span class="font-weight-bold d-block">{{ $nhanvien->chucvu }}</span>
                            <span>{{ $nhanvien->ten }}</span> <!-- Hiển thị tên nhân viên -->
                        @elseif (Auth::guard('admin')->check())
                            @php
                                $admin = Auth::guard('admin')->user();
                            @endphp
                            <span class="font-weight-bold d-block">QUẢN LÝ WEBSITE</span>
                            <span>{{ $admin->ten }}</span> <!-- Hiển thị email admin -->
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Thông tin cá nhân</a>
                    <form method="POST" action="{{ route('admin.dangxuat') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                    </form>
                </div>


            </li>
        </ul>

    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            @if (Auth::guard('nhanvien')->check())
                @php
                    $chucvu = Auth::guard('nhanvien')->user()->chucvu;
                @endphp

                @if ($chucvu == 'Nhân viên bán hàng')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Quản lý đơn hàng</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <a class="dropdown-item" href="{{ route('admin.hoadon') }}">Danh sách đơn hàng</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Quản lý khách hàng</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <a class="dropdown-item" href="{{ route('admin.khachhang') }}">Danh sách khách hàng</a>
                            <a class="dropdown-item" href="{{ route('admin.diachi') }}">Địa chỉ</a>
                            <a class="dropdown-item" href="{{ route('admin.danhgia') }}">Đánh giá</a>
                        </div>
                    </li>
                @elseif($chucvu == 'Nhân viên kho')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Quản lý sản phẩm</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <a class="dropdown-item" href="{{ route('admin.sanpham') }}">Danh sách sản phẩm</a>

                        </div>
                    </li>
                @endif
            @endif

            @if (Auth::guard('admin')->check())
                <!-- Kiểm tra nếu là admin -->
                <!-- Quản lý nhân viên -->
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-tachometer-alt"></i> 
                        <span>Thống kê</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.thongke') }}">Thống kê</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý nhân viên</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.nhanvien') }}">Danh sách nhân viên</a>
                    </div>
                </li>

                <!-- Quản lý khách hàng -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý khách hàng</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.khachhang') }}">Danh sách khách hàng</a>
                        <a class="dropdown-item" href="{{ route('admin.diachi') }}">Địa chỉ</a>
                        <a class="dropdown-item" href="{{ route('admin.danhgia') }}">Đánh giá</a>
                    </div>
                </li>

                <!-- Quản lý sản phẩm -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý sản phẩm</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.sanpham') }}">Danh sách sản phẩm</a>
                        <a class="dropdown-item" href="{{ route('admin.danhmucsanpham') }}">Danh mục sản phẩm</a>
                        <a class="dropdown-item" href="{{ route('admin.loaisanpham') }}">Loại sản phẩm</a>
                        <a class="dropdown-item" href="{{ route('admin.mau') }}">Màu</a>
                        <a class="dropdown-item" href="{{ route('admin.kichthuoc') }}">Kích thước</a>
                        <a class="dropdown-item" href="{{ route('admin.thuonghieu') }}">Thương hiệu</a>
                    </div>
                </li>

                <!-- Quản lý đơn hàng -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý hóa đơn</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.hoadon') }}">Danh sách hóa đơn</a>
                        <a class="dropdown-item" href="{{ route('admin.trangthaidonhang') }}">Trạng thái đơn hàng</a>
                        <a class="dropdown-item" href="{{ route('admin.phuongthucthanhtoan') }}">Phương thức thanh
                            toán</a>
                        <a class="dropdown-item" href="{{ route('admin.phuongthucgiaohang') }}">Phương thức giao
                            hàng</a>
                        <a class="dropdown-item" href="{{ route('admin.donvivanchuyen') }}">Đơn vị vận chuyển</a>
                    </div>
                </li>

                <!-- Quản lý mã giảm giá -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý mã giảm giá</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.magiamgia') }}">Danh sách mã giảm giá</a>
                    </div>
                </li>

                <!-- Quản lý tin tức -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý tin tức</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.tintuc') }}">Danh sách tin tức</a>
                        <a class="dropdown-item" href="{{ route('admin.loaitintuc') }}">Loại tin tức</a>
                    </div>
                </li>

                <!-- Quản lý kho -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="pagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý kho</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="{{ route('admin.khohang') }}">Kho hàng</a>
                    </div>
                </li> --}}
            @endif
        </ul>


        <div id="content-wrapper">

            <div class="container-fluid">
                @yield('body')

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Nguyễn Trung Hiếu</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script src="{{ asset('admin/js/main1.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>


</body>

</html>
