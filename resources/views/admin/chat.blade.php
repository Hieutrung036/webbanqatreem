@extends('admin.layout.indexmain')
@section('title', 'Chat với khách hàng')


@section('body')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main id="main" class="main">
        <div class="pagetitle">

            <div class="container" style="height: 490px">
                <div class="row">
                    <div class="col-md-4">
                        <div class="users-list">
                            <h3>Hộp thư</h3>
                            <ul>
                                @foreach ($khachHangList as $khachHang)
                                    <li>
                                        <a href="{{ route('chat.show', ['idkh' => $khachHang->idkh]) }}">
                                            {{ $khachHang->ten }}
                                        </a>
                                        <p>
                                            Nội dung 
                                            @if ($khachHang->co_tin_nhan_moi)
                                                <span style="color: red;">(Có tin nhắn mới)</span>
                                            @endif
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            
                        </div>




                    </div>
                    {{-- Kiểm tra nếu có dữ liệu khách hàng và tin nhắn --}}
                    @if (isset($khachHang))
                        <div class="col-md-8">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <h2>Chat với khách hàng</h2>
                                    <div id="chat-box" class="card">
                                        <div id="message-container" class="card-body">
                                            @foreach ($chatMessages as $message)
                                                <!-- Sử dụng $chatMessages thay vì $chat -->
                                                <div class="message">
                                                    <strong>
                                                        @if ($message->loai_nguoi_gui == 'khachhang')
                                                            {{ $message->khachHang->ten }}: <!-- Hiển thị tên khách hàng -->
                                                        @else
                                                            Nhân viên:
                                                        @endif
                                                    </strong>
                                                    <p>{{ $message->noidung }}</p>
                                                    <small>{{ $message->thoigian }}</small>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="card-footer">
                                            <form action="{{ route('chat.send') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idnv" value="1"> <!-- id nhân viên -->
                                                <input type="hidden" name="idkh" value="{{ $idkh }}">
                                                <!-- idkh từ controller -->
                                                <div class="input-group">
                                                    <input type="text" id="content" name="content" class="form-control"
                                                        placeholder="Nhập tin nhắn...">
                                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif




                </div>
            </div>
            <style>
                .users-list {
                    background-color: #f0f0f0;
                    border: 1px solid #ddd;
                    padding: 10px;
                    height: calc(80vh - 10px);
                    /* Chiều cao cố định cho danh sách người dùng */
                    overflow-y: auto;
                    /* Cho phép scroll nếu danh sách quá dài */
                }

                .users-list ul {
                    list-style-type: none;
                    padding: 0;
                }

                .users-list ul li {
                    margin-bottom: 10px;
                }

                #chat-box {
                    height: 490px;
                    /* Chiều cao cố định cho vùng chat */
                    overflow-y: auto;
                    /* Cho phép scroll nếu nội dung chat quá dài */
                }

                #chat-messages {
                    height: calc(100% - 60px);
                    /* Chiều cao của phần hiển thị tin nhắn */
                    overflow-y: auto;
                    /* Cho phép scroll nếu tin nhắn quá dài */
                }

                .message {
                    padding: 10px;
                    border-bottom: 1px solid #ddd;
                }

                #chat-form {
                    margin-top: 10px;
                }
            </style>
            <script>
                // Tự động scroll xuống cuối vùng chat khi có tin nhắn mới
                var chatBox = document.getElementById('chat-box');
                chatBox.scrollTop = chatBox.scrollHeight;
                var chatMessages = document.getElementById("chat-messages");
                // Cuộn xuống dưới cùng khi tải trang
                chatMessages.scrollTop = chatMessages.scrollHeight;
                // Hàm để cuộn xuống dưới cùng
                function scrollToBottom() {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
                // Khi có tin nhắn mới, gọi hàm scrollToBottom để tự động cuộn xuống dưới cùng
                var sendMessageBtn = document.getElementById("sendMessageBtn");
                sendMessageBtn.addEventListener("click", function() {
                    scrollToBottom();
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#sendMessageBtn').click(function(e) {
                        e.preventDefault(); // Ngăn chặn hành động mặc định của nút submit
                        // Lấy dữ liệu từ form
                        var formData = $('#send-message-form').serialize();
                        // Gửi AJAX request
                        $.ajax({
                            url: $('#send-message-form').attr('action'),
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                // Xử lý phản hồi thành công
                                console.log('Message sent successfully:', response);
                                // $('#message-container').html('<p>' + response.Noidung + '</p>');

                                location.reload();
                                // Đóng modal hoặc làm gì đó sau khi gửi tin nhắn thành công
                            },
                            error: function(xhr, status, error) {
                                // Xử lý lỗi
                                console.error('Error:', error);
                            }
                        });
                    });
                });
            </script>
        </div>
    </main>
@endsection


@section('search')
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Tìm kiếm..." aria-label="Search"
                aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endsection
