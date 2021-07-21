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
    public $selectedItems = [];
    public $roles =  [];

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete','deleteSelected'];


    public function mount(){
        $this->title = 'Users';
        $this->roles = Role::orderBy('id','DESC')->get();
    }
    
    public function render()
    {
       
        return view('livewire.user.user',[
             'users' => ($this->search === null ) ? ModelsUser::latest()->paginate(10) : ModelsUser::latest()->where('name', 'like', '%'.$this->search.'%')->paginate(10),
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

    public function confirm($item = null, $multiple = false){
        if($multiple == true){
            $this->dispatchBrowserEvent('confirm-delete',['item' => 'multiple']);
        }
        else{
            $this->dispatchBrowserEvent('confirm-delete',['item' => $item]);
        }
    }
    
    public function delete($item){
        if(ModelsUser::where('id', $item)->delete()){
            $this->dispatchBrowserEvent('success-izi',['ntitle' => 'Success', 'nmessage' =>"User has been deleted"]);
        }
        return FALSE;
    }
}
