<?php

namespace App\Livewire\Request;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
class RequestIndex extends Component
{
    use WithPagination, Toast;

    public array $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'quantity', 'label' => 'Quantity'],
        ['key' => 'budget', 'label' => 'Budget'],
        ['key' => 'status', 'label' => 'Status', 'sortable' => false],
        ['key' => 'department', 'label' => 'Department', 'sortable' => false],
        ['key' => 'product_id', 'label' => 'Product', 'sortable' => false],
        ['key' => 'user_id', 'label' => 'User', 'sortable' => false],
        ['key' => 'created_at', 'label' => 'Created At', 'sortable' => false, 'desc' => true],
        ['key' => 'updated_at', 'label' => 'Updated At', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public array $requestFilters = [
        'low_to_high' => false,
        'high_to_low' => false,
        'approved' => false,
        'pending' => false,
        'declined' => false,
        'latest' => false,
        'oldest' => false,
    ];

    public $query = '';

    public function render()
    {
        $user = Auth::user();

        $requests = Request::latest()
            ->when($user->role === 'employee', function ($query) use ($user) {
                // Employees can only see their own requests
                $query->where('user_id', $user->id);
            })
            ->when($user->role === 'manager', function ($query) use ($user) {
                // Managers can see requests from their department
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('department', $user->department);
                });
            })
            ->when($this->query, function ($query, $value) {
                $query->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%' . $value . '%')
                        ->orWhereRelation('user', 'first_name', 'like', '%' . $value . '%')
                        ->orWhereRelation('user', 'last_name', 'like', '%' . $value . '%')
                        ->orWhereRelation('user', 'department', 'like', '%' . $value . '%')
                        ->orWhereRelation('product', 'name', 'like', '%' . $value . '%');
                });
            })
            ->when($this->requestFilters['low_to_high'], function ($query) {
                $query->orderBy('budget', 'asc');
            })
            ->when($this->requestFilters['high_to_low'], function ($query) {
                $query->orderBy('budget', 'desc');
            })
            ->when($this->requestFilters['approved'], function ($query) {
                $query->where('status', 'approved');
            })
            ->when($this->requestFilters['pending'], function ($query) {
                $query->where('status', 'pending');
            })
            ->when($this->requestFilters['declined'], function ($query) {
                $query->where('status', 'declined');
            })
            ->when($this->requestFilters['latest'], function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($this->requestFilters['oldest'], function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.request.request-index', [
            'requests' => $requests,
            'requestFilters' => $this->requestFilters,
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex items-center justify-center h-full">
            <!-- Loading spinner... -->
            <h3 class="text-2xl font-semibold text-gray-500 dark:text-gray-400">Loading requests...</h3>
        </div>
        HTML;
    }

    public function openCreateRequestModal()
    {
        $this->dispatch('openCreateRequestModal');
    }

    public function openUpdateRequestModal(Request $request)
    {
        $this->dispatch('openUpdateRequestModal', $request->id);
    }

    public function openDeleteRequestModal(Request $request)
    {
        $this->dispatch('openDeleteRequestModal', $request->id);
    }

    public function openApproveRequestModal(Request $request)
    {
        $this->dispatch('openApproveRequestModal', $request->id);
    }

    public function openDeclineRequestModal(Request $request)
    {
        $this->dispatch('openDeclineRequestModal', $request->id);
    }

    public function getProductName($productId)
    {
        return Request::where('product_id', $productId)->first()->product->name ?? 'N/A';
    }

    public function getUserName($userId)
    {
        return Request::where('user_id', $userId)->first()->user->first_name ?? 'N/A';
    }

    public function search()
    {
        $this->resetPage();
    }
}
