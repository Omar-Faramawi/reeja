<?php

namespace Tamkeen\Ajeer\Http\Controllers;

class UserController extends Controller
{
    /*
     * The index method
     */
    public function index()
    {
    }

    /*
     * Change lang method
     */
    public function getLocale($locale)
    {
        if ($locale == 'ar') {
            $lang = $locale;
            $dir = '-rtl';
        } else {
            $lang = 'en';
            $dir = '';
        }
        session()->put('locale', $lang);
        session()->set('dir', $dir);
        app()->setLocale($lang);

        return redirect()->back();
    }
}
