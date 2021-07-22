<?php

namespace App\Http\Livewire;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule as ValidationRule;

class User extends Component
{
    public $title, 
           $search,
           $name,
           $role,
           $email,
           $password,
           $selectedItem;
    public $force = false;
    public $selectedItems = [];
    public $roles =  [];

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete','deleteSelected','test'];
    protected $queryString = ['search'];

 
    public function mount(){
        $this->title = 'Users';
        $this->roles = Role::orderBy('id','DESC')->get();
        $this->search = request()->query('search', $this->search);
    }
    
   
    public function render()
    {
       
        return view('livewire.user.user',[
             'users' => ($this->search === null ) ? ModelsUser::with('roles')->latest()->paginate(10) : ModelsUser::with('roles')->latest()->where('name', 'like', '%'.$this->search.'%')->paginate(10),
             'trash' => ($this->search === null ) ? ModelsUser::onlyTrashed()->paginate(10) : ModelsUser::onlyTrashed()->where('name', 'like', '%'.$this->search.'%')->paginate(10)
            ]);
    }

    public function open($mode, $item = null){
        $this->clearAll();
        if($mode == 'update' && $item !== null){
            $user = ModelsUser::find($item);
            $this->selectedItem = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->getRoleNames()[0];

        }
        $this->dispatchBrowserEvent('openModal',['modal' => 'inputModal']);
    }

    public function clearAll(){
        $this->title = $this->search = $this->role = $this->name =  $this->email = $this->password =  $this->selectedItem = null;
        unset($this->selectedItems);
        $this->selectedItems = [];
        $this->force = false;
    }

    public function multiple($mode = null){
        //nothin to do, this method just for collecting $this->selectedItems from checkboxes
    }

    public function deleteSelected(){
        if($this->force === false){
            Modelsuser::whereIn('id', $this->selectedItems)->delete();
        }
        else{
            Modelsuser::onlyTrashed()->whereIn('id', $this->selectedItems)->forceDelete();

        }
        $this->clearAll();
        $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"Users has been deleted"]);
    }

    public function save(){
        

        if($this->selectedItem === null){
            $this->validate([
                'name' => 'required|min:3',
                'email' =>['required','email', ValidationRule::unique('users')->ignore($this->selectedItem)],
                'password' => 'required|min:8',
                'role' =>'required'
            ]);
            $user = ModelsUser::create([
                'name' => $this->name,
                'email' => $this->email,
                'email_verified_at' => now(),
                'password' => password_hash($this->password,PASSWORD_DEFAULT), 
                'remember_token' => Str::random(10),
            ]);
            $user->assignRole($this->role);
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"User has been added"]);
        }
        else{
             $this->validate([
                'name' => 'required|min:3',
                'email' =>['required','email', ValidationRule::unique('users')->ignore($this->selectedItem)],
                'role' =>'required'
            ]);
            ModelsUser::where('id', $this->selectedItem)->update([
                'name'=> $this->name,
                'email' => $this->email,
            ]);
            if($this->password !== null){
                ModelsUser::where('id', $this->selectedItem)->update([
                    'password' => password_hash($this->password,PASSWORD_DEFAULT)
                ]);
            }
            $user = ModelsUser::find($this->selectedItem);
            $user->syncRoles($this->role);
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"User's data has been updated"]);
        }
        $this->clearAll();
        $this->dispatchBrowserEvent('closeModal',['modal' => 'inputModal']);
    }

    public function confirm($item = null, $multiple = false, $permanently = false){
        $this->force = $permanently;
        $this->selectedItem = $item;
        
        if($item === null && $multiple === true){
            //multiple softDelete
            $this->dispatchBrowserEvent('confirm-delete',['mode' => 'multiple','item' => null, 'for' => 'trash']);
        }
        if($item === null && $multiple === true && $permanently === true){
            //multiple force delete
            $this->dispatchBrowserEvent('confirm-delete',['mode' => 'multiple', 'item' => null, 'for' => 'force']);
        }
        
        if($item !== null && $multiple === false && $permanently === true){
            // single force delete
            $this->dispatchBrowserEvent('confirm-delete',['mode'=>'single','item' => $item, 'for' => 'force']);
        }

        if($item !== null && $multiple === false && $permanently === false){
            $this->dispatchBrowserEvent('confirm-delete',['mode'=>'single','item' => $item, 'for' => 'trash']);
        }
    }
    
    public function delete(){
        if($this->force === false){
            ModelsUser::where('id', $this->selectedItem)->delete();
        }
        else{
            ModelsUser::onlyTrashed()->find($this->selectedItem)->forceDelete();
        }
        $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"User has been deleted"]);
        $this->clearAll();
        return FALSE;
    }
}
