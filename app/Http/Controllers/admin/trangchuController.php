<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class trangchuController extends Controller
{
    public function index(){
       
        return view('admin.trangchu');
    }
}



