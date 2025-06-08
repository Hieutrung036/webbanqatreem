@extends('admin.layout.indexmain')

@section('title', 'Thống kê')
@section('body')
    <style>
        .statistic-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
    </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Thống kê doanh thu</h1>
            {{--            <nav> --}}
            {{--                <ol class="breadcrumb"> --}}
            {{--                    <li class="breadcrumb-item"><a href="index.html">Quản lý doanh thu</a></li> --}}
            {{--                    <li class="breadcrumb-item active">Hồ sơ cá nhân</li> --}}
            {{--                </ol> --}}
            {{--            </nav> --}}
        </div>
        <div class="row" style="margin: 20px;">
            <div class="col-md-6" style="text-align: right">
                <form action="{{ route('admin.showViewThang') }}">
                    <div class="row">
                        @csrf
                        <div class="col-md-5">
                            <input id="batdau" type="date" class="form-control" name="batdau" required
                                autocomplete="batdau" value="" />
                        </div>
                        <div class="col-md-5">
                            <input id="ketthuc" type="date" class="form-control" name="ketthuc" required
                                autocomplete="ketthuc" value="" />
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-warning">Lọc</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6" style="text-align: right">
                <form action="">
                    @csrf
                    <button type="submit" class="btn btn-primary">Bỏ lọc</button>
                </form>
            </div>
        </div>
        <div>
            <form action="{{ route('admin.xuatexcel') }}" method="POST">
                @csrf
                <table class="row-md-8" style="margin: 25px;">
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="month-year" name="month_year"
                                placeholder="MM/YYYY">
                        </td>
                        <td width="20px"></td>
                        <td>
                            <input type="submit" class="btn btn-warning" name="export_csv" value="Xuất Excel">
                        </td>
                    </tr>
                </table>
            </form>
        </div>


        <div class="container">
            <!-- Tổng số đơn hàng -->
            <div class="statistic-card">
                <h4>Tổng số đơn hàng giao thành công / Tổng số đơn hàng</h4>
                <p>{{ $demdonhangthanhcong }} / {{ count($donhangs) }}</p>
            </div>
            <div class="statistic-card">
                <h4>Tổng số đơn hàng đã được bán / Tổng số đơn hàng</h4>
                <p>{{ $demdonhangdaban }} / {{ count($donhangs) }}</p>
            </div>

            <!-- Tổng số sản phẩm -->
            <div class="statistic-card">
                <h4>Tổng số sản phẩm</h4>
                <p>{{ count($sanphams) }}</p>
            </div>

            <div class="statistic-card">
                <h4>Tổng số khách hàng mua hàng / Tổng số khách hàng</h4>
                <p>{{ $demkhachhang }} / {{ count($khachhang) }}</p>
            </div>

            <!-- Tổng doanh thu -->
            <div class="statistic-card">
                <h4>Tổng doanh thu</h4>
                @php
                    $tong = 0;
                @endphp
                @foreach ($donhangs as $donhang)
                    @php
                        // Kiểm tra nếu đơn hàng thỏa mãn điều kiện
                        $trangthai = $donhang->trangthaidonhang->ten;

                        if ($trangthai == 'Giao hàng thành công' || $trangthai == 'Mua hàng thành công') {
                            $tong += $donhang->tongtien;
                        }
                    @endphp
                @endforeach
                <p>{{ number_format($tong) }} VNĐ</p>
            </div>


            <!-- Doanh thu theo tháng -->
            <div class="statistic-card">
                <table>
                    <tr>
                        <form method="GET" action="">
                            <td>
                                <h4>Doanh thu năm</h4>
                            </td>
                            <td style="width: 10px"></td>
                            <td>
                                <h4>
                                    <input type="number" id="nam" name="nam" class="form-control"
                                        value="{{ $nam }}">
                                </h4>
                            </td>
                            <td style="width: 10px"></td>
                            <td>
                                <h4>
                                    <button type="submit" class="btn btn-primary">Xem </button>
                                </h4>
                            </td>
                        </form>
                    </tr>
                </table>
                <div>
                    <table class="table mt-4">
                        <td>
                            <b>
                                Tháng <br>
                                Tổng Doanh Thu
                            </b>
                        </td>
                        @foreach (range(1, 12) as $month)
                            @php
                                $doanhThuThang = $doanhThu->firstWhere('thang', $month);
                            @endphp
                            <td>
                                <b>{{ $month }}</b> <br>
                                {{ $doanhThuThang ? number_format($doanhThuThang->tong_doanhthu) : '0' }} VNĐ
                            </td>
                        @endforeach
                        <tr> Tổng doanh thu năm {{ $nam }}: {{ number_format($tongnam) }} VNĐ</tr>
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>

                        <script>
                            var months = @json($months);
                            var revenues = @json($revenueByMonth);
                            var ctx = document.getElementById('myChart').getContext('2d');

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    datasets: [{
                                        label: 'Doanh thu (VND)',
                                        data: revenues,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderWidth: 1

                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            beginAtZero: true
                                        },
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>




                    </table>
                </div>
            </div>

            <!-- Đơn hàng theo trạng thái -->
            <div class="statistic-card">
                <h4>Số đơn hàng theo trạng thái</h4>
                <ul>
                    @foreach ($trangthais as $trangthai)
                        <li>{{ $trangthai->ten }} : {{ $soLuongTheoTrangThai[$trangthai->idttdh] }} đơn hàng</li>
                    @endforeach
                </ul>
            </div>

            <div class="statistic-card">
                <h4>Số lượng sản phẩm theo danh mục</h4>
                <ul>
                    @foreach ($loaisanphams as $loaisanpham)
                        @php
                            // Lấy thông tin danh mục từ iddm (mối quan hệ giữa LoaiSanPham và DanhMucSanPham)
                            $danhmuc = App\Models\DanhMucSanPham::find($loaisanpham->iddm);
                        @endphp
                        <li>{{ $loaisanpham->ten }} -
                            @if ($danhmuc)
                                {{ $danhmuc->gioitinh == 0 ? 'Bé trai' : 'Bé gái' }} :
                            @else
                                Không xác định :
                            @endif
                            {{ $soLuongTheoLoaiSP[$loaisanpham->idlsp] }} sản phẩm
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </main>
    <script>
        document.getElementById('month-year').addEventListener('input', function(e) {
            var value = e.target.value;
            var regex = /^(0[1-9]|1[0-2])\/(\d{4})$/;

            if (!regex.test(value)) {
                e.target.setCustomValidity('Vui lòng nhập tháng theo định dạng MM/YYYY');
            } else {
                e.target.setCustomValidity('');
            }
        });
    </script>
@endsection

@section('search')

    <form action="" method="GET" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>
@endsection
