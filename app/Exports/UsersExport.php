<?php

namespace App\Exports;

use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
{
    use Exportable;
    protected $data;
    public $cols = [
        'order_id',
        'order_date',
        'delivery_date',
        'distributor_id',
        'distributor_name',
        'vip_package',
        'driver_id',
        'driver_name',
        'local/state',
        'pickup_charge',
        'quantity',
        'over_size',
        'over_weight',
        'amount'
    ];


    public function __construct($data)
    {
        foreach ($data as $a) {
            $this->data[] = array(
                'order_id' => $a['order_id'],
                'order_date' => $a['add_date'],
                'delivery_date' => $a['delivery_date'],
                'distributor_id' => $a['distributor_id'],
                'distributor_name' => $a['distributor_name'],
                'vip_package' => $a['vip_package'],
                'driver_id' => $a['driver_id'],
                'driver_name' => $a['driver_name'],
                'local/state' => $a['local_int'],
                'pickup_charge' => $a['pickup_charge'],
                'quantity' => $a['qty'],
                'over_size' => $a['over_size'],
                'over_weight' => $a['over_weight'],
                'amount'  => $a['amount']
            );
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->cols;
    }
}
