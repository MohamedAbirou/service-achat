<?php

namespace App\Livewire\User;

use App\Models\User;
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

    public bool $updateUserModal = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
    ];

    #[On('openUpdateUserModal')]
    public function openUpdateUserModal(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->updateUserModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ]);

        $this->dispatch('saved');
        $this->updateUserModal = false;

        $this->success('User updated successfully');
    }

    public function render()
    {
        return view('livewire.update-user');
    }
}
