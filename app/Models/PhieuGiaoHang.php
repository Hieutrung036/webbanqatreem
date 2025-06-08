<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuGiaoHang extends Model
{
    use HasFactory;
    protected $table = 'phieugiaohang';
    protected $primaryKey = 'idpgh';
    public $timestamps = false;
    protected $fillable = ['ghichu', 'idhd','iddc','iddvvc'];
    public function hoadon()
    {
        return $this->hasMany(HoaDon::class, 'idhd', 'iddh');
    }
    public function diachi()
    {
        return $this->hasMany(DiaChi::class, 'iddc', 'iddc');
    }
    public function donvivanchuyen()
    {
        return $this->belongsTo(DonViVanChuyen::class, 'iddvvc', 'iddvvc');
    }
}
