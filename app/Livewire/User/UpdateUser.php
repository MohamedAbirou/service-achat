<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class UpdateUser extends Component
{
    use Toast;

    public $user;
    public $first_name;
    public $last_name;
    public $email;
    public $role;
    public $department;

    public bool $updateUserModal = false;

    public array $departments = ['Marketing', 'Sales', 'Finance', 'Human Resources', 'IT', 'Accounting', 'Support', 'Customer Service', 'Operations', 'Legal'];


    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|string|in:employee,manager',
        'department' => 'required|string'
    ];

    #[On('openUpdateUserModal')]
    public function openUpdateUserModal(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->department = $user->department;
        $this->updateUserModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'department' => $this->department
        ]);

        $this->dispatch('saved');
        $this->updateUserModal = false;

        $this->success('User updated successfully');
    }

    public function render()
    {
        return view('livewire.user.update-user', ['departments' => $this->departments]);
    }
}
