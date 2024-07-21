<?php

namespace App\Livewire\User;

use App\Models\User;
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
        ['key' => 'department', 'label' => 'Department', 'sortable' => false],
        ['key' => 'role', 'label' => 'Role', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $departments = ['Marketing', 'Sales', 'Finance', 'Human Resources', 'IT', 'Accounting', 'Support', 'Customer Service', 'Operations', 'Legal'];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public string $query = '';

    public function mount()
    {
        $this->authorize('manage-users');
    }

    public function render()
    {
        $users = User::latest()
        ->when($this->query, fn ($query, $value) => $query->where('first_name', 'like', '%' . $value . '%')
        ->orWhere('last_name', 'like', '%' . $value . '%')
        ->orWhere('email', 'like', '%' . $value . '%'))
        ->orderBy(...array_values($this->sortBy))->paginate(10);

        return view('livewire.user-index', [
            'users' => $users,
            'departments' => $this->departments,
        ]);
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

    public function search() {
        $this->resetPage();
    }
}
