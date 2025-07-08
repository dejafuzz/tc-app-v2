<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\PaketLanding;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index(){
        $paket = PaketLanding::where('status', 'Posted')->get();
        return view('landing.packages.index', compact('paket'));
    }
}
