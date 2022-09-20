<?php

namespace App\Http\Controllers;

use App\Services\DistributorService;
use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $disNames;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $disN)
    {
        $this->middleware('auth');
        $this->disNames = $disN;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Dnames = $this->disNames->distributorList();
        // return dd($Dnames);
        return view('home', compact('Dnames'));
    }


    public function searchOrder($id)
    {
    }
}
