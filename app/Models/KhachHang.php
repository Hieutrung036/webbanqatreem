<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class KhachHang extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'khachhang';
    protected $primaryKey = 'idkh';

    protected $fillable = ['ten', 'sdt', 'email', 'matkhau'];
    public $timestamps = false;

    protected $hidden = ['matkhau'];

    public function getAuthPassword()
    {
        return $this->matkhau;
    }

    public function diachi()
    {
        return $this->hasMany(DiaChi::class, 'idkh', 'idkh');
    }
    public function chat()
    {
        return $this->hasMany(Chat::class, 'idkh', 'idkh');
    }
    
}
