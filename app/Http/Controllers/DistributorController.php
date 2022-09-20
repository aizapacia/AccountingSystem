<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    public $attribute = 'id', $searchval;
    public $dis;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function search()
    {
    }






    public function index()
    {
        return view('distributor');
    }
}
