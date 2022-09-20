<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    use WithPagination;
    protected $search;
    public $orderData;

    public function __construct(ReportService $order)
    {
        $this->search = $order;
        $this->middleware('auth');
    }

    public function index()
    {
        $dID = '0';
        $dateby = '0';
        $fromdate = '';
        $todate = '';

        $order = $this->search->daily();
        $disNames = $this->search->disNames();
        $display = 0;
        return view('report', compact('dID', 'dateby', 'disNames', 'order', 'display', 'fromdate', 'todate'));
    }

    public function search()
    {
        $dID = $_GET['disID'];
        $dateby = $_GET['dateBy'];
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];

        if ($dID == 0) {
            $display = 1;
            $order = $this->search->allReport($dateby, $fromdate, $todate);
        } else {
            $display = 2;
            $order = $this->search->disSpecific($dID, $dateby, $fromdate, $todate);
        }
        $disNames = $this->search->disNames();

        $this->orderData = $order['as'];

        return view('report', compact('dID', 'dateby', 'disNames', 'order', 'display', 'fromdate', 'todate'));
    }


    public function download($dID, $dateby, $fdate, $tdate)
    {
        $type = $_GET['fileType'];

        if ($dID == 0) {
            $order = $this->search->allReport($dateby, $fdate, $tdate);
            $filename = 'allDistributor' . '-from=' . $fdate . '-to=' . $tdate . '-Report';
        } else {
            //
            $filename = 'ID=' . $dID . '-from=' . $fdate . '-to=' . $tdate . '-Report';
        }

        if ($type == 'pdf')
            // {
            //     $dompdf = new Dompdf();
            // }
            return Excel::download(new UsersExport($order['as']), $filename . '.pdf');
        elseif ($type == 'exe')
            return Excel::download(new UsersExport($order['as']), $filename . '.xlsx');
        elseif ($type == 'csv')
            return Excel::download(new UsersExport($order['as']), $filename . '.csv');
        else {
            return abort(404);
        }
        //return Excel::download(new UsersExport($order['as']), 'users.csv');
        // return dd($order['as']);
    }

    public function export()
    {
        $fileType = $_GET['fileType'];
        return dd($this->orderData);


        // if ($type == 'pdf')
        //     return Excel::download(new UsersExport, 'users.pdf');
        // elseif ($type == 'exe')
        //     return Excel::download(new UsersExport, 'users.pdf');
        // elseif ($type == 'csv')
        //     return Excel::download(new UsersExport, 'users.csv');
        // else {
        //     return abort(404);
        // }
    }
}
