<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhanHoi;

class phanhoiController extends Controller
{
    
    public function index()
    {
        $phanhoi = PhanHoi::all();
        $phanhoi = PhanHoi::paginate(10); 
        return view('admin.phanhoi', compact('phanhoi'));
    }
}
