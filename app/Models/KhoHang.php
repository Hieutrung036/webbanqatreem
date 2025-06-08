<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoHang extends Model
{
    use HasFactory;
    protected $table = 'khohang';
    protected $primaryKey = 'idkho';
    public $timestamps = false;
    protected $fillable = ['soluong', 'ngaycapnhat','nhacungcap','idsp'];
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
}
