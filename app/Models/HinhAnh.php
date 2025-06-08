<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HinhAnh extends Model
{
    use HasFactory;
    protected $table = 'hinhanh';
    protected $primaryKey = 'idh';
    public $timestamps = false;
    protected $fillable = ['idh', 'duongdan', 'idsp', 'idm', 'idctsp'];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
    
    public function chitietsanpham()
    {
        return $this->belongsTo(ChiTietSanPham::class, 'idctsp', 'idctsp');
    }
}
