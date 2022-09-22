<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\ReportSpecificExport;
use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;

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

        abort_if(!in_array($type, ['csv', 'xlsx', 'pdf']), 404);

        if ($dID == 0) {
            $order = $this->search->allReport($dateby, $fdate, $tdate);
            $filename = 'AllDistributor' . '-From' . $fdate . '-To' . $tdate . '-Report.' . $type;
            if ($type == 'pdf') {
                return Excel::download(new UsersExport($order['as']), $filename);
            } else {
                return Excel::download(new UsersExport($order['as']), $filename);
            }
        } else {
            $order = $this->search->disSpecific($dID, $dateby, $fdate, $tdate);
            $filename = 'DistributorID' . $dID . '-From' . $fdate . 'To' . $tdate . '-Report.' . $type;

            if ($type == 'pdf') {
                return Excel::download(new ReportSpecificExport($order['as']), $filename);
            } else {
                return Excel::download(new ReportSpecificExport($order['as']), $filename);
            }
        }
    }
}
