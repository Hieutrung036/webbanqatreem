<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .store-name {
            font-size: 24px;
            font-weight: bold;
        }

        .header .logo img {
            max-width: 50px;
            /* Điều chỉnh kích thước ảnh logo */
            height: auto;
            object-fit: contain;
            /* Đảm bảo ảnh không bị méo */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Header: Store Name and Logo -->
    <div class="header">
        <div class="store-name">NIZI - CỬA HÀNG QUẦN ÁO TRẺ EM</div>
       
    </div>

    <h2>Hóa Đơn Bán Hàng</h2>
    <p><strong>Tên khách hàng:</strong> {{ $hoadon->diachi->tennguoinhan }}</p>
    <p><strong>Số điện thoại:</strong> 0{{ $hoadon->diachi->sdt }}</p>
    <p><strong>Địa chỉ:</strong> {{ $hoadon->diachi->diachi }},{{ $hoadon->diachi->phuongxa }},{{ $hoadon->diachi->quanhuyen }},{{ $hoadon->diachi->tinhthanhpho }}</p>
    <p><strong>Ngày lập:</strong> {{ \Carbon\Carbon::parse($hoadon->ngaylap)->format('d-m-Y') }}
    </p>
    <p><strong>Nhân viên:</strong> {{ $hoadon->nhanvien->ten }}</p>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hoadon->chitiethoadon as $key => $cthd)
                @foreach ($cthd->chitietsanpham as $ctsp)
                    @php
                        $gia = $ctsp->sanpham->gia;
                        if ($ctsp->sanpham->giamgia) {
                            $gia = $gia - ($gia * $ctsp->sanpham->giamgia->phantram) / 100;
                        }
                        $thanhTien = $gia * $cthd->soluong;
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ctsp->sanpham->ten }}</td>
                        <td>{{ $cthd->soluong }}</td>
                        <td>{{ number_format($gia, 0, ',', '.') }} VND</td>
                        <td>{{ number_format($thanhTien, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <strong>Tổng tiền: </strong> {{ number_format($hoadon->tongtien, 0, ',', '.') }} VND
    </div>

</body>

</html>
