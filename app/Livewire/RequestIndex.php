<?php

namespace App\Livewire;

use App\Models\Request;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RequestIndex extends Component
{
    use WithPagination, Toast;

    public array $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'quantity', 'label' => 'Quantity'],
        ['key' => 'budget', 'label' => 'Budget'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'department', 'label' => 'Department'],
        ['key' => 'product_id', 'label' => 'Product'],
        ['key' => 'user_id', 'label' => 'User'],
        ['key' => 'created_at', 'label' => 'Created At'],
        ['key' => 'updated_at', 'label' => 'Updated At'],
        ['key' => 'actions', 'label' => 'Actions'],
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
        ->when($user->role === 'admin', function ($query) use ($user) {
            // Admins can see all requests
            // No additional conditions needed
        })
        ->when($this->query, fn ($query, $value) => $query
        ->where(function ($query) use ($value) {
            $query->where('title', 'like', '%' . $value . '%')
                ->orWhere('description', 'like', '%' . $value . '%');
        }))
        ->paginate(10);

        return view('livewire.request-index', compact('requests'));
    }

    public function approveRequest($requestId)
    {
        $request = Request::findOr($requestId);
        $this->authorize('approve-requests');

        $request->update(['status' => 'approved']);

        $request->user->notify(new RequestApproved($request));

        try{
            $this->success('Request approved!');
        } catch (\Exception $e) {
            $this->error('Error approving the request!');
        }
    }

    public function declineRequest($requestId)
    {
        $request = Request::findOr($requestId);
        $this->authorize('approve-requests');

        $request->update(['status' => 'declined']);

        $request->user->notify(new RequestDeclined($request));

        try {
            $this->success('Request declined!');
        } catch (\Exception $e) {
            $this->error('Error declining the request!');
        }
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

    public function getProductName($productId)
    {
        return Request::where('product_id', $productId)->first()->product->name ?? 'N/A';
    }

    public function getUserName($userId)
    {
        return Request::where('user_id', $userId)->first()->user->first_name ?? 'N/A';
    }

    public function search() {
        $this->resetPage();
    }
}
