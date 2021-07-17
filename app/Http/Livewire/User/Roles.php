<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    public $name;
    public $title="User's Roles";
    public $search;

    public $selectedItem;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete'];
     
    public function render()
    {
        return view('livewire.user.roles',[
            
            'roles' => ($this->search === null ) ? Role::latest()->paginate(10) : Role::latest()->where('name', 'like', '%'.$this->search.'%')
                                                                                         ->orWhere('guard_name','like','%'.$this->search.'%')->paginate(10)
        ]);
        
    }

    

    public function open($mode, $item = null){
        if($mode == 'update' && $item !== null){
            $role = Role::find($item);
            $this->selectedItem = $role->id;
            $this->name = $role->name;
        }
        $this->dispatchBrowserEvent('openModal');
    }

    public function confirm($item){
        $this->dispatchBrowserEvent('confirm-delete',['item' => $item]);
    }
    
    public function delete($item){
        if(Role::where('id', $item)->delete()){
            $this->dispatchBrowserEvent('success-nofitfy',['ntitle' => 'Success', 'nmessage' =>"Role has been deleted"]);
            
        }
        return FALSE;
    }
    
    public function save(){
        $this->validate([
            'name' => 'required'
        ]);
        if($this->selectedItem === null){
            Role::create(['name'=> $this->name]);
            $this->dispatchBrowserEvent('success-nofitfy',['ntitle' => 'Success', 'nmessage' =>"Role has been added"]);
        }
        else{
            Role::where('id', $this->selectedItem)->update(['name'=> $this->name]);
            $this->dispatchBrowserEvent('success-nofitfy',['ntitle' => 'Success', 'nmessage' =>"Role has been updated"]);
            
        }
        $this->name = null;
        $this->selectedItem = null;
        $this->dispatchBrowserEvent('closeModal');
    }
    
}
