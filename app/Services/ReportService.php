<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportService
{
    protected $DISTANCE;
    protected $local_or_not;
    protected $distancePrice;
    protected $userVip;
    protected $state;
    protected $vip_package;
    protected $perbox;
    protected $userinfo;

    /**
     * Get all Distributor Name and ID
     *
     * @return void
     */
    public function disNames()
    {
        return  DB::table('users')
            ->select(
                (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS name")),
                'users.id'
            )
            ->join('users_groups', 'users_groups.user_id', '=', 'users.id')
            ->where('users_groups.group_id', 2)
            ->orderBy('users.first_name', 'asc')
            ->get();
    }

    /**
     * daily
     *
     * @return void
     */
    public function daily()
    {
        try {
            $datenow = date_format(Carbon::now(), 'Y-m-d');

            $order_log = DB::table('distributor_order_log')
                ->select(
                    'distributor_order_log.id',
                    DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                    'distributor_order_log.qty',
                    'distributor_order_log.order_date',
                    'distributor_order_log.add_date',
                    'distributor_order_log.driver_id',
                    'distributor_order_log.distributor_id',
                    (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS distributor_name")),
                    (DB::raw("(select CONCAT(first_name,' ', last_name) from users where id = distributor_order_log.driver_id) AS driver_name")),
                    'users.email',
                    'users.phone',
                )
                ->join('users', 'users.id', '=', 'distributor_order_log.distributor_id')
                ->where('distributor_order_log.order_date', 'like', $datenow . '%')
                ->paginate(10);

            if (!empty($order_log['total'])) {
                foreach ($order_log as $o) {
                    $this->isUserVIP($o->distributor_id);
                    $dis_data[] = array(
                        'order_id' => $o->id,
                        'distributor_id' => $o->distributor_id,
                        'distributor_name' => $o->distributor_name,
                        'vip' => $this->userVip,
                        'vip_package' => $this->vip_package,
                        'driver_name' => $o->driver_name,
                        'driver_id' => $o->driver_id,
                        'add_date' => $o->add_date,
                        'delivery_date'    => $o->order_date,
                        'km'            => $this->getDistance($o->id, $o->qty),
                        'local_int'     => $this->local_or_not,
                        'qty'           => $o->qty,
                        'pickup_charge' => $o->pickup_charge,
                        'over_size'     => 0,
                        'over_weight'   => 0,
                        'amount'        => $this->ComputeAmount(
                            $this->DISTANCE,
                            $o->pickup_charge,
                            0,
                            0
                        ),
                        'state' => $this->state
                    );
                }

                if ($order_log->total() > 10) {
                    $all_order = DB::table('distributor_order_log')
                        ->select(
                            'distributor_order_log.id',
                            DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                            'distributor_order_log.qty',
                            'distributor_order_log.distributor_id'
                        )->where('distributor_order_log.order_date', $datenow)->get();

                    foreach ($all_order as $a) {
                        $this->isUserVIP($a->distributor_id);
                        $all_data[] = array(
                            'km' => $this->getDistance($a->id, $a->qty),
                            'amount'        => $this->ComputeAmount(
                                $this->DISTANCE,
                                $a->pickup_charge,
                                0,
                                0
                            ),
                        );
                    }

                    $AllTotal = $this->totalAmount($all_data);
                } else {
                    $AllTotal = $this->totalAmount($dis_data);
                }


                return [
                    'datenow' => $datenow,
                    'as' => $dis_data,
                    'today' => $order_log,
                    'totalAmount' => $AllTotal,
                    'hasval' => 1
                ];
            } else {
                return [
                    'datenow' => $datenow,
                    'hasval' => 0
                ];
            }
        } catch (Exception $e) {
            return [
                'datenow' => Carbon::now(),
                'hasval' => 0
            ];
        }
    }

    /**
     * allReport
     *
     * @return void
     */
    public function allReport($dateby, $fromdate, $todate)
    {
        try {
            $dis_data = array();
            $fd = new DateTime($fromdate);
            $td = new DateTime($todate);
            $from = date_format($fd, 'Y-m-d H:i:s');
            $to = date_format($td, 'Y-m-d H:i:s');

            if ($dateby == 0) {
                $dby = 'distributor_order_log.add_date';
            } else {
                $dby = 'distributor_order_log.order_date';
            }


            $order_log = DB::table('distributor_order_log')
                ->select(
                    'distributor_order_log.id',
                    DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                    'distributor_order_log.qty',
                    'distributor_order_log.order_date',
                    'distributor_order_log.add_date',
                    'distributor_order_log.driver_id',
                    'distributor_order_log.distributor_id',
                    (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS distributor_name")),
                    (DB::raw("(select CONCAT(first_name,' ', last_name) from users where id = distributor_order_log.driver_id) AS driver_name")),
                    'users.email',
                    'users.phone'
                )
                ->join('users', 'users.id', '=', 'distributor_order_log.distributor_id')
                ->whereBetween($dby, [$from, $to])
                ->paginate(10);

            foreach ($order_log as $o) {
                $this->isUserVIP($o->distributor_id);
                $dis_data[] = array(
                    'order_id' => $o->id,
                    'add_date' => $o->add_date,
                    'delivery_date'    => $o->order_date,
                    'distributor_id' => $o->distributor_id,
                    'distributor_name' => $o->distributor_name,
                    'vip' => $this->userVip,
                    'vip_package' => $this->vip_package,
                    'driver_name' => $o->driver_name,
                    'driver_id' => $o->driver_id,
                    'km'            => $this->getDistance($o->id, $o->qty),
                    'local_int'     => $this->local_or_not,
                    'qty'           => $o->qty,
                    'pickup_charge' => $o->pickup_charge,
                    'over_size'     => 0,
                    'over_weight'   => 0,
                    'amount'        => $this->ComputeAmount(
                        $this->DISTANCE,
                        $o->pickup_charge,
                        0,
                        0
                    ),
                    'state' => $this->state
                );
            }

            if ($order_log->total() > 10) {
                $all_order = DB::table('distributor_order_log')
                    ->select(
                        'distributor_order_log.id',
                        DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                        'distributor_order_log.qty',
                        'distributor_order_log.distributor_id'
                    )
                    ->whereBetween($dby, [$from, $to])->get();

                foreach ($all_order as $a) {
                    $this->isUserVIP($a->distributor_id);
                    $all_data[] = array(
                        'km' => $this->getDistance($a->id, $a->qty),
                        'amount'        => $this->ComputeAmount(
                            $this->DISTANCE,
                            $a->pickup_charge,
                            0,
                            0
                        ),
                    );
                }

                $AllTotal = $this->totalAmount($all_data);
            } else {
                $AllTotal = $this->totalAmount($dis_data);
            }

            return [
                'tdate' => $todate,
                'fdate' => $fromdate,
                'as' => $dis_data,
                'today' => $order_log,
                'totalAmount' => $AllTotal,
                'pagetotal' => $this->totalAmount($dis_data)
            ];
        } catch (Exception $e) {
            //
        }
    }


    public function disSpecific($disID, $dateby, $fromdate, $todate)
    {
        try {
            $dis_data = array();
            $fd = new DateTime($fromdate);
            $td = new DateTime($todate);
            $from = date_format($fd, 'Y-m-d H:i:s');
            $to = date_format($td, 'Y-m-d H:i:s');


            $user = DB::table('users')->select(
                'id',
                (DB::raw("CONCAT(first_name,' ',  last_name) AS name")),
            )->where('id', $disID)->first();

            if ($dateby == 0) {
                $dby = 'distributor_order_log.add_date';
            } else {
                $dby = 'distributor_order_log.order_date';
            }

            $order_log = DB::table('distributor_order_log')
                ->select(
                    'distributor_order_log.id',
                    DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                    'distributor_order_log.qty',
                    'distributor_order_log.order_date',
                    'distributor_order_log.add_date',
                    'distributor_order_log.driver_id',
                    'distributor_order_log.distributor_id',
                    (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS distributor_name")),
                    (DB::raw("(select CONCAT(first_name,' ', last_name) from users where id = distributor_order_log.driver_id) AS driver_name")),
                    'users.email',
                    'users.phone'
                )
                ->join('users', 'users.id', '=', 'distributor_order_log.distributor_id')
                ->whereBetween($dby, [$from, $to])
                ->where('distributor_id', $disID)
                ->paginate(10);

            foreach ($order_log as $o) {
                $dis_data[] = array(
                    'order_id' => $o->id,
                    'driver_name' => $o->driver_name,
                    'driver_id' => $o->driver_id,
                    'add_date' => $o->add_date,
                    'delivery_date'    => $o->order_date,
                    'km'            => $this->getDistance($o->id, $o->qty),
                    'local_int'     => $this->local_or_not,
                    'qty'           => $o->qty,
                    'pickup_charge' => $o->pickup_charge,
                    'over_size'     => 0,
                    'over_weight'   => 0,
                    'amount'        => $this->ComputeAmount(
                        $this->DISTANCE,
                        $o->pickup_charge,
                        0,
                        0
                    ),
                    'state' => $this->state
                );
            }

            if ($order_log->total() > 10) {
                $all_order = DB::table('distributor_order_log')
                    ->select(
                        'distributor_order_log.id',
                        DB::raw('IF(distributor_order_log.qty < 10, 0,50) as pickup_charge'),
                        'distributor_order_log.qty',
                        'distributor_order_log.distributor_id'
                    )
                    ->whereBetween($dby, [$from, $to])
                    ->where('distributor_id', $disID)->get();

                foreach ($all_order as $a) {
                    $this->isUserVIP($a->distributor_id);
                    $all_data[] = array(
                        'km' => $this->getDistance($a->id, $a->qty),
                        'amount'        => $this->ComputeAmount(
                            $this->DISTANCE,
                            $a->pickup_charge,
                            0,
                            0
                        ),
                    );
                }

                $AllTotal = $this->totalAmount($all_data);
            } else {
                $AllTotal = $this->totalAmount($dis_data);
            }

            return [
                'as' => $dis_data,
                'today' => $order_log,
                'totalAmount' => $AllTotal,
                'pagetotal' => $this->totalAmount($dis_data),
                'vip' => $this->isUserVIP($disID),
                'user' => $user
            ];
        } catch (Exception $e) {
            //
        }
    }


    /**
     ********************************** COMPUTATIONS
     */

    protected function getDistance($unique_id, $qty)
    {
        try {
            $address = DB::table('distributor_order') //get FROM address info from DB
                ->where('unique_id', $unique_id)
                ->get();

            $fromState = $this->checkState($address[0]); //get sender State
            $toState   = $this->checkState($address[1]);   //get receiver State

            $this->state = $fromState . '-' . $toState;

            if ($fromState == $toState) { //Check if local or Interstate
                $this->local_or_not = 'Local';
            } else {
                $this->local_or_not = 'Outstation';
            }


            $from = $address[0];
            $to = $address[1];


            //Calculate distance from latitude and longitude
            $theta = floatval($from->lng) - floatval($to->lng);

            $dist = sin(deg2rad(floatval($from->lat))) * sin(deg2rad(floatval($to->lat))) +  cos(deg2rad(floatval($from->lat))) * cos(deg2rad(floatval($to->lat))) * cos(deg2rad($theta));

            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $distance = ($miles * 1.609344);
            $this->DISTANCE = $distance; //assign to public variable.

            //Compute distance Price
            if ($fromState == 'Selangor' && $fromState == 'Kuala Lumpur') {
                $this->distancePrice = number_format((float)$distance, 2, '.', '');
            } else {
                if ($this->userVip == 1) { //check if user is VIP
                    if ($this->local_or_not == 'Local') { //if Local
                        switch ($this->vip_package) {
                            case 25000:
                                $this->perbox = 12;
                                break;
                            case 15000:
                                $this->perbox = 13;
                                break;
                            case 10000:
                                $this->perbox = 13;
                                break;
                            case 5000:
                                $this->perbox = 15;
                                break;
                        }
                    } else { //ifState
                        switch ($this->vip_package) {
                            case 25000:
                                $this->perbox = 22;
                                break;
                            case 15000:
                                $this->perbox = 23;
                                break;
                            case 10000:
                                $this->perbox = 24;
                                break;
                            case 5000:
                                $this->perbox = 30;
                                break;
                        }
                    }
                }
            }
            return $distance;

            $this->distancePrice = $this->perbox * $qty;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function isUserVIP($userID)
    {
        try {
            $viplog = DB::table('vip_logs')
                ->where('user_id', $userID)->first();

            if (!empty($viplog)) {
                $this->userVip = 1;
                $logVal = DB::table('logpoint')->where('id', $viplog->logpoint_id)->first();
                $this->vip_package = $logVal->log_point;
            } else {
                $this->userVip = 0;
                $this->vip_package = "-";
            }
        } catch (Exception $e) {
            $this->userVip = 0;
            return;
        }
    }

    /**
     * checkState 
     *this return if the delibery i
     * 
     * @param  mixed $val
     * @return void
     */
    protected function checkState($val)
    {
        try {
            $postalCode = (int)$val->postal_code;

            if ($postalCode <= 2800 && $postalCode >= 1000)
                return 'Perlis';
            elseif ($postalCode <= 9810 && $postalCode >= 5000)
                return 'Kedah';
            elseif ($postalCode <= 14400 && $postalCode >= 10000)
                return 'Penang';
            elseif ($postalCode <= 18500 && $postalCode >= 15000)
                return 'Kelantan';
            elseif ($postalCode <= 24300 && $postalCode >= 20000)
                return 'Terengganu';
            elseif ($postalCode <= 28800 && $postalCode >= 25000)
                return 'Pahang';
            elseif ($postalCode <= 36810 && $postalCode >= 30000)
                return 'Perak';
            elseif ($postalCode <= 48300 && $postalCode >= 40000)
                return 'Selangor';
            elseif ($postalCode <= 60000  && $postalCode >= 50000)
                return 'Kuala Lumpur';
            elseif ($postalCode <= 62988 && $postalCode >= 62000)
                return 'Putrajaya';
            elseif ($postalCode <= 73509 && $postalCode >= 70000)
                return 'Negeri Sembilan';
            elseif ($postalCode <= 78309 && $postalCode >= 75000)
                return 'Malacca';
            elseif ($postalCode <= 86900 && $postalCode >= 79000)
                return 'Johor';
            elseif ($postalCode <= 87033 && $postalCode >= 87000)
                return 'Labuan';
            elseif ($postalCode <= 91309 && $postalCode >= 87010)
                return 'Sabah';
            elseif ($postalCode <= 98859 && $postalCode >= 93000)
                return 'Sarawak';
            else
                return 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function ComputeAmount($distance, $pCharge, $oSize, $oWeight)
    {
        try {
            $amount = $distance + $pCharge;

            if ($oSize == 1) { //Check if the Size is less than 50cm
                $amount *= 2;
            }

            if ($oWeight == 1) { //Check if weight is more than 50kg
                $amount *= 2;
            }

            return $this->distancePrice = number_format((float)$amount, 2, '.', '');
        } catch (Exception $e) {
            return 0;
        }
    }

    protected function totalAmount($amount)
    {
        try {
            $total = 0;
            foreach ($amount as $a) {
                //Add all amount to get the total.
                $total += $a['amount'];
            }
            return $total;
        } catch (Exception $e) {
            //
        }
    }
}
