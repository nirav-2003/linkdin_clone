<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'email|required|exists:users',
        'password' => 'required'
    ];

    public function render()
    {
        return view('livewire.login');
    }

    public function submitlogindata()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('message', 'Login Successfully');
            return $this->redirect('/crud', navigate: true);
        } else {
            session()->flash('message', 'Something Wrong ');
        }
    }

    // public function logout()
    // {
    //     Auth::logout();
    //     session()->flash('message', 'Logout Successfully🤓');
    //     return redirect('login');
    // }
}
