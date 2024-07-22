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
        $this->user = User::findOrFail($userId);
    }

    public function render()
    {
        // $this->user->load('requests');

        // if ($this->user->requests->count() > 0) {
        //     $this->user->requests->each(function ($request) {
        //         $request->load('product');
        //     });
        // }

        // dd($this->user->role);

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
