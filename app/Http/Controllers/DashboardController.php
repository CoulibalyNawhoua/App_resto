<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:afficher_tableau_bord', ['only' => ['index']]);
    }

    public function index()
    {
        // addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        addJavascriptFile('assets/plugins/custom/cookiealert/cookiealert.bundle.js');

        return view('pages.dashboards.index');
    }
}
