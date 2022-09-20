<?php

namespace App\Services;

use App\Models\DisOrderLogModel;
use App\Models\DistributorOrderModel;
use Exception;
use Illuminate\Support\Facades\DB;

class SearchService
{
    public function distributor($dis_id)
    {
        try {
            $dis_info = DB::table('users')
                ->where('id', $dis_id)
                ->first();
            $val = DB::table('users')->where('id', $dis_id)->count();
            return  [
                'val' => $val,
                'dis_info' => $dis_info,
                'vip_info'  => $this->isUserVIP($dis_id),
                'disOrder' => $this->disOrder($dis_id, 10)
            ];
        } catch (Exception $e) {
            return $val = 0;
        }
    }

    public function order($order_id)
    {
        try {
            $order_log = DB::table('distributor_order_log')
                ->select(
                    'distributor_order_log.id',
                    'distributor_order_log.qty',
                    'distributor_order_log.order_date',
                    'distributor_order_log.add_date',
                    'distributor_order_log.pickup_date',
                    'distributor_order_log.total_distance',
                    'distributor_order_log.driver_id',
                    'distributor_order_log.distributor_id',
                    (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS distributor_name")),
                    (DB::raw("(select CONCAT(first_name,' ', last_name) from users where id = distributor_order_log.driver_id) AS driver_name")),
                    'users.email',
                    'users.phone',
                )
                ->join('users', 'users.id', '=', 'distributor_order_log.distributor_id')
                ->where('distributor_order_log.id', $order_id)
                ->first();

            $dis_order = DB::table('distributor_order')->select(
                'area',
                'address_unit',
                'address',
                'postal_code',
                'seq',
                'zone'
            )
                ->where('unique_id', $order_id)
                ->orderBy('seq', 'asc')
                ->get();

            $distance_info = $this->getDistance($dis_order);
            $vip_info = $this->isUserVIP($order_log->distributor_id);

            return [
                'order_log' => $order_log,
                'order_address' => $dis_order,
                'vip_info' => $vip_info,
                'isLocal' => $distance_info
            ];
        } catch (Exception $e) {
            return 0;
        }
    }


    public function isUserVIP($userID)
    {
        try {
            $viplog = DB::table('vip_logs')
                ->select(
                    'vip_logs.vip_status',
                    'logpoint.log_point'
                )
                ->join('logpoint', 'logpoint.id', '=', 'vip_logs.logpoint_id')
                ->where('user_id', $userID)->first();

            if (!empty($viplog)) {
                return [
                    'vip_package' => $viplog->log_point,
                    'vip_status'  => $viplog->vip_status
                ];
            } else {
                return [
                    'vip_package' => 0,
                    'vip_status'  => 'Not VIP'
                ];
            }
        } catch (Exception $e) {
            return [
                'vip_package' => 0,
                'vip_status'  => 'Not VIP'
            ];
        }
    }


    public function disOrder($id, $paginate)
    {
        try {
            $order = DB::table('distributor_order_log')
                ->select(
                    'id',
                    'add_date',
                    'order_date',
                    'qty',
                    'status'
                )
                ->where('distributor_id', 11215)
                ->paginate($paginate);

            $orderTotal = DB::table('distributor_order_log')
                ->where('distributor_id', $id)
                ->count();

            if ($orderTotal > 0) {

                foreach ($order as $o) {
                    $val = DB::table('distributor_order')
                        ->select('address')
                        ->where('unique_id', $o->id)
                        ->orderBy('seq', 'asc')
                        ->get();

                    $dd[] = array(
                        'id' => $o->id,
                        'add_date' => $o->add_date,
                        'order_date' => $o->order_date,
                        'islocal' => $this->getDistance($val),
                        'qty' => $o->qty,
                        'status' => $o->status
                    );
                }

                return [
                    'link' => $order,
                    'val' => $dd,
                    'total' => $orderTotal
                ];
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getDistance($val)
    {
        $fromAd = strtolower($val[0]->address);
        $toAd = strtolower($val[1]->address);

        if (str_contains($fromAd, 'kuala lumpur') || str_contains($fromAd, 'selangor')) {
            if (str_contains($fromAd, 'kuala lumpur')) {
                if (str_contains($toAd, 'kuala lumpur')) {
                    return 'Local';
                } else {
                    return 'Outstate';
                }
            } elseif (str_contains($fromAd, 'selangor')) {
                if (str_contains($toAd, 'selangor')) {
                    return 'Local';
                } else {
                    return 'Outstate';
                }
            } else {
                return 'not define';
            }
        } else {
            if (str_contains($fromAd, 'perlis')) {
                if (str_contains($toAd, 'perlis')) {
                    return 'Local';
                } else {
                    return 'Outstate';
                }
            } elseif (str_contains($fromAd, 'kedah')) {
                if (str_contains($toAd, 'kedah')) {
                    return 'Local';
                } else {
                    return 'Outstate';
                }
            } elseif (str_contains($fromAd, 'penang')) {
                if (str_contains($toAd, 'penang'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'kelantan')) {
                if (str_contains($toAd, 'kelantan'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'terengganu')) {
                if (str_contains($toAd, 'terengganu'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'pahang')) {
                if (str_contains($toAd, 'pahang'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'perak')) {
                if (str_contains($toAd, 'perak'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'putrajaya')) {
                if (str_contains($toAd, 'putrajaya'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'negeri sembilan')) {
                if (str_contains($toAd, 'negeri sembilan'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'malacca')) {
                if (str_contains($toAd, 'malacca'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'johor')) {
                if (str_contains($toAd, 'johor'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'labuan')) {
                if (str_contains($toAd, 'labuan'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'sabah')) {
                if (str_contains($toAd, 'sabah'))
                    return 'Local';
                else
                    return 'Outstate';
            } elseif (str_contains($fromAd, 'sarawak')) {
                if (str_contains($toAd, 'sarawak'))
                    return 'Local';
                else
                    return 'Outstate';
            } else {
                return 'not define';
            }
        }
    }
}
