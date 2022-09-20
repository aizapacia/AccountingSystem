<?php

namespace App\Services;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;


class HomeService
{

    public function distributorList()
    {
        try {
            return DB::table('users')
                ->select(
                    'users.id',
                    'users.username',
                    (DB::raw("CONCAT(users.first_name,' ',  users.last_name) AS name"))
                )
                ->join('users_groups', 'users_groups.user_id', '=', 'users.id')
                ->where('group_id', 2)
                ->where('users.active', 1)
                ->orderBy('users.first_name', 'asc')
                ->get();
        } catch (Exception $e) {
            return null;
        }
    }
}
