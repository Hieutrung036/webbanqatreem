<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuongThucGiaoHang extends Model
{
    use HasFactory;
    protected $table = 'phuongthucgiaohang';
    protected $primaryKey = 'idptgh';
    public $timestamps = false;
    protected $fillable = ['ten','phigiaohang','ngaydukien' ,'mota'];
}