<?php
namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginCard extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function login()
    {
        // Validasi input pengguna
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->flash('message', 'Login successful!');
            return $this->redirect('/');
        }
        session()->flash('status', 'Account unsuccessfully login.');
    }

    public function render()
    {
        return view('livewire.components.login-card');
    }
}
