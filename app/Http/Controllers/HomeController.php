<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        // addJavascriptFile('plugins/custom/cookiealert/cookiealert.bundle.js');

        return view('pages.homes.index');
    }
}
