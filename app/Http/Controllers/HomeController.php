<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //get all the required information from the database
        $stock_all = DB::table('stock')->get();

        $client_all = DB::table('client')->get();
     
        //return to view with required data
        return view('home', ['stock_all' => $stock_all, 'client_all' => $client_all]);
    }
}
