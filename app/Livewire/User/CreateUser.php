<?php

namespace App\Livewire\User;

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

    public $role;

    public $department;

    public bool $createUserModal = false;

    public array $departments = ['Marketing', 'Sales', 'Finance', 'Human Resources', 'IT', 'Accounting', 'Support', 'Customer Service', 'Operations', 'Legal'];


    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|max:16|confirmed',
        'role' => 'required|string|in:employee,manager',
        'department' => 'required|string'
    ];

    public function render()
    {
        return view('livewire.user.create-user', ['departments' => $this->departments]);
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
            'role' => $this->role,
            'department' => $this->department
        ]);

        $this->dispatch('created');
        $this->createUserModal = false;
        $this->reset();

        $this->success('User created successfully');
    }
}
