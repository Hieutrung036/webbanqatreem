<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KhoHang;
use Illuminate\Http\Request;

class khohangController extends Controller
{
    //
    public function index(){
        $khohang = KhoHang::all();
        return view('admin.khohang', compact('khohang'));
    }
}
