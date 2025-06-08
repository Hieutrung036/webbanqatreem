<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhanHoi extends Model
{
    use HasFactory;
    
    protected $table = 'phanhoi';
    protected $primaryKey = 'idph';
    public $timestamps = false;
    protected $fillable = ['noidung', 'thoigian', 'idnv', 'iddg'];

    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'idnv', 'idnv'); // Điều chỉnh đúng cột khóa ngoại
    }

    public function danhgia()
    {
        return $this->belongsTo(DanhGia::class, 'iddg', 'iddg');
    }
}
