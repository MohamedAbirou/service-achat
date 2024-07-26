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
        ['key' => 'first_name', 'label' => 'Full Name'],
        ['key' => 'email', 'label' => 'Email', 'sortable' => false],
        ['key' => 'department', 'label' => 'Department', 'sortable' => false],
        ['key' => 'role', 'label' => 'Role', 'sortable' => false],
        ['key' => 'created_at', 'label' => 'Created At'],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $departments = ['Marketing', 'Sales', 'Finance', 'Human Resources', 'IT', 'Accounting', 'Support', 'Customer Service', 'Operations', 'Legal'];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public string $query = '';

    public array $filters = [
        'department' => [],
    ];

    public function mount()
    {
        $this->authorize('manage-users');
    }

    public function render()
    {
        $users = User::latest()
            ->when($this->query, fn($query, $value) => $query->where('first_name', 'like', '%' . $value . '%')
                ->orWhere('last_name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%'))
            ->when(count($this->filters['department']) > 0, fn($query) => $query->whereIn('department', $this->filters['department']))
            ->orderBy(...array_values($this->sortBy))->paginate(10);

        return view('livewire.user.user-index', [
            'users' => $users,
            'departments' => $this->departments,
        ]);
    }

    public function updateDepartmentFilter($department)
    {
        if (($key = array_search($department, $this->filters['department'])) !== false) {
            unset($this->filters['department'][$key]);
        } else {
            $this->filters['department'][] = $department;
        }
        $this->resetPage();
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

    public function search()
    {
        $this->resetPage();
    }
}
