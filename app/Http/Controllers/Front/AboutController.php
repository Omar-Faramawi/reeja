<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * Display about us page
     * 
     * @return mixed
     */
    public function index()
    {
        return view('front.about.about_us');
    }
    
    /**
     * Display FAQs page
     * 
     * @return mixed
     */
    public function faq()
    {
        return view('front.about.faq');
    }
    
    /**
     * Display terms & conditions static page
     * 
     * @return mixed
     */
    public function terms()
    {
        return view('front.about.terms');
    }
    
    /**
     * Display support page
     * 
     * @return mixed
     */
    public function support()
    {
        return view('front.about.support');
    }
}
