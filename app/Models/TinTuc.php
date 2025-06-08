<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TinTuc extends Model
{
    use HasFactory;
    protected $table = 'tintuc';
    protected $primaryKey = 'idtt';
    public $timestamps = false;
    protected $fillable = ['tieude', 'noidung', 'ngaydang','hinhanh','noibat', 'idltt' ];
    public function loaitintuc()
    {
        return $this->belongsTo(LoaiTinTuc::class, 'idltt', 'idltt');
    }
   
}
