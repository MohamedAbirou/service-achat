<?php

namespace App\Livewire\User;

use App\Models\Request;
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
        if (Request::where('user_id', $this->user)->exists()) {
            $this->error('Cannot delete user with requests');
            $this->deleteUserModal = false;
            return;
        }

        User::destroy($this->user);

        $this->deleteUserModal = false;
        $this->user = null;

        $this->dispatch('deleted');

        $this->success('User deleted successfully');
    }
}
