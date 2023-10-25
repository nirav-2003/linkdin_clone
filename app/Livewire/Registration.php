<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registration extends Component
{
    public $name;
    public $email;
    public $image;
    public $password;
    public $userimage;

    use WithFileUploads;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|unique:users|email',
        'password' => 'required|min:6',
        // 'image' => 'required|image'
    ];

    public function render()
    {
        return view('livewire.registration');
    }

    public function submitdata()
    {

        $this->validate();
        $usercreate = new User();
        $usercreate->name = $this->name;
        $usercreate->email = $this->email;
        $usercreate->password = $this->password;

        if ($this->userimage) {
            $usercreate->image = $this->userimage->store('public/images');
        }

        $usercreate->save();


        $this->name = '';
        $this->email = '';
        $this->password = '';

        // session()->flash('message', 'User Registration Successfully 🥳');

        if ($usercreate) {
            return $this->redirect('login', navigate: true);
        } else {
            session()->flash('message', 'Something Wrong 🥳');
        }
    }
}
