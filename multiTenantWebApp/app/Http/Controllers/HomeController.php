<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebAppTenant\Posts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        echo \Request::route()->getName();
//        die('27');
        $data = Posts::orderBy('id','DESC')
              ->get();
        return view('home',compact('data'));
    }
}
