<?php

namespace App\Livewire;

use App\Models\Request;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;
use Livewire\Component;

class SingleRequest extends Component
{
    public $request;

    public function mount($requestId)
    {
        $this->request = Request::findOrFail($requestId);
    }


    public function approveRequest()
    {
        $this->authorize('approve-requests');

        $this->request->update(['status' => 'approved']);

        $this->request->user->notify(new RequestApproved($this->request));

        try{
            $this->success('Request approved!');
        } catch (\Exception $e) {
            $this->error('Error approving the request!');
        }
    }

    public function declineRequest()
    {
        $this->authorize('approve-requests');

        $this->request->update(['status' => 'declined']);

        $this->request->user->notify(new RequestDeclined($this->request));

        try {
            $this->success('Request declined!');
        } catch (\Exception $e) {
            $this->error('Error declining the request!');
        }
    }

    public function render()
    {
        return view('livewire.single-request', ['request' => $this->request]);
    }
}
