<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistCard extends Component
{
    // Public properties for form inputs
    public $name;
    public $email;
    public $password;
    public $phone_number;
    public $remember = false;

    // Validation rules (removed dynamic methods from the array)
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',  // Use simple rule
        'phone_number' => 'nullable|digits_between:10,15',
    ];

    // Submit the form
    public function submit()
    {
        // Validate the form data
        $this->validate();

        // Create the user
        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone_number' => $this->phone_number,
            'type' => 'buyer',
            'activation' => true,
        ]);

        // Attempt to log the user in if the registration is successful
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->flash('message', 'Login successful!');
            return redirect()->route('home');
        } else {
            session()->flash('error', 'Invalid credentials.');
        }
    }

    public function render()
    {
        return view('livewire.components.regist-card');  // Render the registration form view
    }
}
