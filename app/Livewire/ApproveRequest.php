<?php

namespace App\Livewire;

use App\Models\Request;
use App\Notifications\RequestApproved;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class ApproveRequest extends Component
{
    use Toast;

    public $request;
    public bool $approveRequestModal = false;

    public function render()
    {
        return view('livewire.approve-request');
    }

    #[On('openApproveRequestModal')]
    public function openApproveRequestModal(int $requestId)
    {
        $this->request = Request::findOrFail($requestId);
        $this->approveRequestModal = true;
    }

    public function approveRequest()
    {
        $this->authorize('approve-requests');

        $this->request->update(['status' => 'approved']);

        $this->request->user->notify(new RequestApproved($this->request));

        $this->approveRequestModal = false;

        $this->dispatch('approved');

        try{
            $this->success('Request approved!');
        } catch (\Exception $e) {
            $this->error('Error approving the request!');
        }
    }
}
