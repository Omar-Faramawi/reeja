<?php

namespace Tamkeen\Ajeer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class DummyBillingController extends Controller
{
    /**
     * Get the user account number
     *
     * @return mixed
     */
    public function getAccount()
    {
        return response()->json(['account_number' => '100011234512345']);
    }
    
    /**
     * Create Bill & return its number
     *
     * @return mixed
     */
    public function createBill()
    {
        $bill_number = rand(100, 10000);
        
        return response()->json(['bill_number' => $bill_number]);
    }
}