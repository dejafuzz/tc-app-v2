<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(){
        
        $role = Role::all();
        
        return view('admin.roles.index',compact('role'));
    }

}