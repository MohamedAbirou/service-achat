<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteUser extends Component
{
    use Toast;

    public int|null $user;

    public bool $deleteUserModal = false;

    public function render()
    {
        return view('livewire.delete-user');
    }

    #[On('openDeleteUserModal')]
    public function openDeleteUserModal(int $user)
    {
        $this->user = $user;
        $this->deleteUserModal = true;
    }

    public function delete()
    {
        User::destroy($this->user);

        $this->deleteUserModal = false;
        $this->user = null;

        $this->dispatch('deleted');

        $this->success('User deleted successfully');
    }
}
