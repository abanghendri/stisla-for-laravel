<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Permissions extends Component
{
    public function render()
    {
        return view('livewire.permissions',[
            'title' => 'Permissions'
        ]);
    }

    public function add(){
        $this->dispatchBrowserEvent('openModal');
    }
}
