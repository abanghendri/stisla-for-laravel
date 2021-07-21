<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    public $name;
    public $title="User's Roles";
    public $search;

    public $selectedItem;
    public $selectedItems = [];

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete','deleteSelected'];
     
    public function render()
    {
        $act =[];
        $permissions = Permission::all();

        foreach ($permissions as $p) {
            if(strpos($p->name, '.') !== false){
                $a = explode(".",$p->name);
                $act[$a[0]][$a[1]] = $p->display;
            }
        }
        
        
        return view('livewire.user.roles',[
            
            'roles' => ($this->search === null ) ? Role::latest()->where('name','<>','Super Admin')->paginate(10) : Role::latest()->where('name', 'like', '%'.$this->search.'%')
                                                                                         ->orWhere('guard_name','like','%'.$this->search.'%')->paginate(10),
            'actions' => $act

        ]);
        
    }

    public function updatePermission(){
        
        $role = Role::find($this->selectedItem);
        $role->syncPermissions($this->selectedItems);
        
        $this->clearAll();
        $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"permission has been updated"]);
        $this->dispatchBrowserEvent('closeModal',['modal' => 'permissionsModal']);
    }

    public function clearAll(){
        unset($this->selectedItems);
        $this->selectedItems= [];
        $this->selectedItem = null;
        $this->name = null;
    }


    public function multiple($mode = null){
        //nothin to do, this method just for collecting $this->selectedItems from checkboxes
    }

    public function deleteSelected(){
        if(Role::whereIn('id', $this->selectedItems)->delete()){
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"Roles has been deleted"]);
        };
        $this->clearAll();
    }
    

    public function open($mode, $item = null){
        if($mode == 'update' && $item !== null){
            $role = Role::find($item);
            $this->selectedItem = $role->id;
            $this->name = $role->name;
        }
        $this->dispatchBrowserEvent('openModal',['modal' => 'inputModal']);
    }

    public function confirm($item = null, $multiple = false){
        if($multiple == true){
            $this->dispatchBrowserEvent('confirm-delete',['item' => 'multiple']);
        }
        else{
            $this->dispatchBrowserEvent('confirm-delete',['item' => $item]);
        }
    }

    public function getPermissions($item){
        $this->selectedItem = $item;
        $role = Role::find($this->selectedItem);
        $this->name = $role->name;
        $perm = $role->getAllPermissions();

        foreach($perm as $p){
            $this->selectedItems[] = $p->name;
        }
        $this->dispatchBrowserEvent('openModal',['modal' => 'permissionsModal']);
    }
    
    public function delete($item){
        if(Role::where('id', $item)->delete()){
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"Role has been deleted"]);
        }
        return FALSE;
    }
    
    public function save(){
        $this->validate([
            'name' => 'required'
        ]);
        if($this->selectedItem === null){
            Role::create(['name'=> $this->name]);
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"Role has been added"]);
        }
        else{
            Role::where('id', $this->selectedItem)->update(['name'=> $this->name]);
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"Role has been updated"]);
            
        }
        $this->clearAll();
        $this->dispatchBrowserEvent('closeModal',['modal' => 'inputModal']);
    }

    
    
}
