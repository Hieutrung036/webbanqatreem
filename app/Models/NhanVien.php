<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;;

class NhanVien extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nhanvien';
    protected $primaryKey = 'idnv';

    protected $fillable = ['ten', 'chucvu', 'email', 'sodienthoai', 'matkhau'];
    public $timestamps = false;

    protected $hidden = ['matkhau'];

    public function getAuthPassword()
    {
        return $this->matkhau;
    }
    public function chat()
    {
        return $this->hasMany(Chat::class, 'idnv', 'idnv');
    }
}
