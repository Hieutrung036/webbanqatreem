<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mau extends Model
{
    use HasFactory;
    protected $table = 'mau';
    protected $primaryKey = 'idm';
    public $timestamps = false;
    protected $fillable = ['ten', 'mota'];

    public function chitietsanpham()
    {
        return $this->hasMany(ChitietSanpham::class, 'idm', 'idm');
    }
    public function hinhanh()
    {
        return $this->hasMany(Hinhanh::class, 'idm');
    }
}
