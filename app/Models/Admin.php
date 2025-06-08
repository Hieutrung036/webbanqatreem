<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'idadmin';

    protected $fillable = ['ten', 'email', 'matkhau'];
    public $timestamps = false;

    protected $hidden = ['matkhau'];

    public function getAuthPassword()
    {
        return $this->matkhau;
    }
}
