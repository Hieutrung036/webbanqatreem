<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonViVanChuyen extends Model
{
    use HasFactory;
    protected $table = 'donvivanchuyen';
    protected $primaryKey = 'iddvvc';
    public $timestamps = false;
    protected $fillable = ['ten'];
    
}
