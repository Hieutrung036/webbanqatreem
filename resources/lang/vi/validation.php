
<?php

return [
    'required' => 'Trường :attribute là bắt buộc.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'regex' => 'Số điện thoại không hợp lệ.',
    'unique' => 'Trùng :attribute.',
    'string' => 'Trường :attribute phải là một chuỗi.',
    'between' => 'Trường :attribute phải nằm giữa :min và :max.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'exists' => ':attribute không tồn tại',
    'custom' => [
        'sdt' => [
            'sdt.required' => 'Số điện thoại là bắt buộc.',
            'sdt.regex' => 'Số điện thoại không hợp lệ.',
        ],
        'email' => [
            'unique' => 'Địa chỉ email đã được sử dụng.',
        ],
        'matkhau' => [
            'min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ],
       'hinhchinh' => [
            'required' => 'Vui lòng chọn hình ảnh.',
            'image' => 'Tệp phải là một hình ảnh.',
            'mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif.',
            'max' => 'Dung lượng hình ảnh tối đa là 2MB.',
        ],
        'hinhphu' => [
            'required' => 'Vui lòng chọn hình ảnh.',
            'image' => 'Tệp phải là một hình ảnh.',
            'mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif.',
            'max' => 'Dung lượng hình ảnh tối đa là 2MB.',
        ],
    ],
];


