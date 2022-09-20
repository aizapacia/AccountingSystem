<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Searchbar extends Component
{
    public     $searchby;

    public function render()
    {
        return view('livewire.searchbar');
    }
}
