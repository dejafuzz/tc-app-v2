<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\FotoLanding;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $foto = FotoLanding::where('status','Posted')->get();
        
        return view ('landing.home.index',compact('foto'));
    }
}