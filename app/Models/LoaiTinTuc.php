<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiTinTuc extends Model
{
    use HasFactory;
    protected $table = 'loaitintuc';
    protected $primaryKey = 'idltt';
    public $timestamps = false;
    protected $fillable = ['ten', 'mota','soluongtintuc'];
    public function tintuc()
    {
        return $this->hasMany(TinTuc::class, 'idltt', 'idltt');
    }
}
