<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Distributor extends Component
{
    use WithPagination;
    public $attribute = 'users.id', $searchval;

    public function render()
    {
        $disInfo = DB::table('users')->select(
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.phone',
            'users.state'
        )
            ->join('users_groups', 'users_groups.user_id', '=', 'users.id')
            ->where('users_groups.group_id', 2)
            ->where($this->attribute, 'like', '%' . $this->searchval . '%')
            ->paginate(20);
        //return dd($disInfo);
        return view('livewire.distributor', [
            'dis' => $disInfo,
            'val' => 'asa'
        ]);
    }
}
