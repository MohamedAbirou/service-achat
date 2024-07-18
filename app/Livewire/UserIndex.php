<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Log\Logger;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public array $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'first_name', 'label' => 'First Name'],
        ['key' => 'last_name', 'label' => 'Last Name'],
        ['key' => 'email', 'label' => 'Email', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function render()
    {
        $query = User::query();

        // $queryUsers = User::query()->when($this->search, function ($query) {
        //     $query->where('first_name', 'like', '%' . $this->search . '%')
        //         ->orWhere('last_name', 'like', '%' . $this->search . '%')
        //         ->orWhere('email', 'like', '%' . $this->search . '%');
        // })->orderBy(...array_values($this->sortBy));

        if (request("first_name")) {
            $query->where('first_name', 'like', '%' . request("first_name") . '%');
        }

        $users = $query->paginate(10);

        return view('livewire.user-index', compact('users', 'query'));
    }

    public function openCreateUserModal()
    {
        $this->dispatch('openCreateUserModal');
    }

    public function openUpdateUserModal(User $user)
    {
        $this->dispatch('openUpdateUserModal', $user->id);
    }

    public function openDeleteUserModal(User $user)
    {
        $this->dispatch('openDeleteUserModal', $user->id);
    }
}
