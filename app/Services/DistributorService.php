<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


class DistributorService
{

    protected $vip_status;
    protected $vip_package;


    public function all()
    {
        $dis_info = DB::table('users')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.address',
                'vip_logs.vip_status',
                'logpoint.log_point'
            )
            ->join('vip_logs', 'vip_logs.user_id', '=', 'users.id')
            ->join('logpoint', 'logpoint.id', '=', 'vip_logs.logpoint_id')
            ->join('users_groups', 'users_groups.user_id', '=', 'users.id')
            ->where('group_id', 2)
            ->paginate(20);


        return [
            'dis' => $dis_info
        ];
    }

    public function disSpecific($val)
    {
        $dis_info = DB::table('users')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.address',
                'vip_logs.vip_status',
                'logpoint.log_point'
            )
            ->join('vip_logs', 'vip_logs.user_id', '=', 'users.id')
            ->join('logpoint', 'logpoint.id', '=', 'vip_logs.logpoint_id')
            ->join('users_groups', 'users_groups.user_id', '=', 'users.id')
            ->where('group_id', 2)
            ->paginate(20);

        return [
            'dis' => $dis_info
        ];
    }
}
