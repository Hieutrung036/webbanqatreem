<!DOCTYPE html>
<html>

<head>
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #555555;
            line-height: 1.5;
            font-size: 15px;
        }

        a {
            color: #4283B4;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            border-radius: 4px;
            background-color: #1666a2;
            color: rgb(0, 0, 0);
            text-align: center;
            text-decoration: none;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>NIZI Shop</h1>
        <p>Xin chào!</p>
        <p>Click vào đường dẫn dưới đây để thiết lập mật khẩu tài khoản của bạn tại <a href="{{ route('trangchu') }}">NIZI Shop</a>. Nếu bạn không có yêu cầu thay đổi mật khẩu, xin hãy vui lòng xóa email này để bảo mật thông tin:</p>
        
        <!-- Sử dụng bảng để căn chỉnh layout -->
        <table role="presentation" cellspacing="0" cellpadding="0"  width="70%">
            <tr>
                <td style="align-items: center" >
                    <a href="{{ $url }}" class="button" style="color: #ffffff">Thiết lập mật khẩu</a>
                </td>
                <td width="50px" style="align-items: center">
                    <span>Hoặc</span>
                </td>
                <td style="align-items: center">
                    <a href="{{ route('trangchu') }}" style="color:#4283B4;">Đến cửa hàng của chúng tôi</a>
                </td>
            </tr>
        </table>

        <p class="footer">
            Nếu bạn có bất cứ câu hỏi nào, đừng ngần ngại liên lạc với chúng tôi tại <br>sale@nizi.com
        </p>
    </div>
</body>

</html>
