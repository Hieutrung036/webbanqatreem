<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaGiamGia extends Model
{
    use HasFactory;
    protected $table = 'giamgia';
    protected $primaryKey = 'idgg';
    public $timestamps = false;
    protected $fillable = ['code', 'phantram','mota','soluong','ngaybatdau','ngayketthuc'];
}
