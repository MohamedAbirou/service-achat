<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteUser extends Component
{
    use Toast;

    public $user;

    public bool $deleteUserModal = false;

    public function render()
    {
        return view('livewire.user.delete-user');
    }

    #[On('openDeleteUserModal')]
    public function openDeleteUserModal(int $userId)
    {
        $this->user = $userId;
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
