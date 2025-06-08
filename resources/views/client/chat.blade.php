@extends('client.layout.master')
@section('title', 'Chat')
@section('body')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container">
                <h4>Chat với nhân viên tư vấn</h4>
                <div id="chat-box" class="card">
                    <div id="message-container1" class="card-body">
                        @foreach ($tinNhan as $message)
                            <div
                                class="message {{ $message->loai_nguoi_gui == 'khachhang' ? 'from-customer' : 'from-staff' }}">
                                <strong>{{ $message->loai_nguoi_gui == 'khachhang' ? 'Bạn' : 'Nhân viên' }}:</strong>
                                <p>{{ $message->noidung }}</p>
                                <small>{{ $message->thoigian }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer">
                    <form id="send-message-form" action="{{ route('client.chat.send') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="content" name="content" class="form-control"
                                placeholder="Nhập tin nhắn..." required>
                            <button type="submit" name="sendMessageBtn" id="sendMessageBtn" class="btn11">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function scrollToBottom() {
            const messageContainer = document.getElementById('chat-box');
            if (messageContainer) {
                // console.log("Scrolling to bottom");
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }
        }

        // Scroll to bottom when the page loads
        document.addEventListener('DOMContentLoaded', scrollToBottom);

        // Monitor changes and scroll to bottom when messages are added
        const observer = new MutationObserver(scrollToBottom);
        observer.observe(document.getElementById('message-container1'), {
            childList: true,
            subtree: true
        });
    </script>

    <style>
        .from-customer {
            text-align: right;
            background-color: #e0f7fa;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
        }

        .from-staff {
            text-align: left;
            background-color: #fbe9e7;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
        }

        .users-list {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px;
            height: calc(100vh - 100px);
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
            height: calc(70vh - 150px);
            /* Chiều cao ngắn hơn (70% chiều cao màn hình) */
            max-height: 400px;
            /* Giới hạn chiều cao tối đa */
            overflow-y: auto;
            /* Cho phép scroll nếu nội dung quá dài */
        }

        .btn11 {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            padding: 0px 15px;

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
@endsection
