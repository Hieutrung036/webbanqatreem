<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KichThuoc extends Model
{
    use HasFactory;
    protected $table = 'kichthuoc';
    protected $primaryKey = 'idkt';
    public $timestamps = false;
    protected $fillable = ['ten', 'mota'];
}
