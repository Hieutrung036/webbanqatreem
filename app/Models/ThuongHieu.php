<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThuongHieu extends Model
{
    use HasFactory;
    protected $table = 'thuonghieu';
    protected $primaryKey = 'idth';
    public $timestamps = false;
    protected $fillable = ['ten'];
    public function sanpham()
    {
        return $this->hasMany(SanPham::class, 'idth', 'idth'); 
    }
}
