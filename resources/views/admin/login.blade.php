<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .login-card h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            height: 45px;
            font-size: 16px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-danger {
            margin-top: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
        }

        .alert-danger ul {
            margin: 0;
            padding: 0;
        }

        .alert-danger li {
            list-style-type: none;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        /* Điều chỉnh chiều rộng input */
        .form-control {
            width: 92%;
            padding: 10px;
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <h2>ĐĂNG NHẬP</h2>
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
        </div>
    </div>

    <div class="footer">
        &copy; 2024 NIZISHOP. Nguyễn Trung Hiếu.
    </div>
</body>
</html>
