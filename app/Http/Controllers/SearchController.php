<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class SearchController extends Controller
{
    use WithPagination;
    protected $search;

    public function __construct(SearchService $order)
    {
        $this->search = $order;
        $this->middleware('auth');
    }

    public function searchVal($search)
    {
        if ($search == 'order') {
            $id = $_GET['ID'];
            $order = $this->search->order($id);

            return view('order_result', compact('order', 'id'));
        } elseif ($search == 'distributor') {
            $id = $_GET['ID'];
            $dis = $this->search->distributor($id);

            if ($dis['val'] == 0 || $dis['val'] == null)
                return abort(404);
            else
                //return dd($dis['disOrder']);
                return view('distributor_result', compact('dis', 'id'));
        } else {
            return abort(404);
        }
    }

    public function disTable($id)
    {
        $order = $this->search->disOrder($id, 20);
        return view('disTable_result', compact('order', 'id'));
    }
}
