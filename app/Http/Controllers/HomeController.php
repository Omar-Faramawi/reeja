<?php

namespace Tamkeen\Ajeer\Http\Controllers;

use Tamkeen\Ajeer\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.home.select_establishment');
    }
    
    /**
     * Show the users homepage
     * 
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('front.home.home_layout');
    }
}
