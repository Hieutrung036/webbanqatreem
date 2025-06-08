<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuongThucThanhToan extends Model
{
    use HasFactory;
    protected $table = 'phuongthucthanhtoan';
    protected $primaryKey = 'idpttt';
    public $timestamps = false;
    protected $fillable = ['ten', 'mota'];
}
