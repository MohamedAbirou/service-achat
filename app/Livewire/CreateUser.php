<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateUser extends Component
{
    use Toast;

    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $password_confirmation;

    public bool $createUserModal = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|max:16|confirmed',
    ];

    public function render()
    {
        return view('livewire.create-user');
    }

    #[On('openCreateUserModal')]
    public function openCreateUserModal()
    {
        $this->reset();
        $this->createUserModal = true;
    }

    public function save()
    {
        $this->validate();

        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'email_verified_at' => now(),
        ]);

        $this->dispatch('created');
        $this->createUserModal = false;
        $this->reset();

        $this->success('User created successfully');
    }
}
