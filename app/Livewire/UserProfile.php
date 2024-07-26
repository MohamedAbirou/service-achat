<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public $user;

    public function mount($userId)
    {
        $this->authorize('manage-users');
        $this->user = User::findOrFail($userId);
    }

    public function render()
    {
        return view('livewire.user-profile', ['user' => $this->user]);
    }

    public function openUpdateRequestModal(Request $request)
    {
        $this->dispatch('openUpdateRequestModal', $request->id);
    }

    public function openDeleteRequestModal(Request $request)
    {
        $this->dispatch('openDeleteRequestModal', $request->id);
    }
}
