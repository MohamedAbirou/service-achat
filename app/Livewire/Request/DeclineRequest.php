<?php

namespace App\Livewire\Request;

use App\Models\Request;
use App\Notifications\RequestDeclined;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeclineRequest extends Component
{
    use Toast;

    public $request;
    public bool $declineRequestModal = false;

    public function render()
    {
        return view('livewire.request.decline-request');
    }

    #[On('openDeclineRequestModal')]
    public function openDeclineRequestModal(int $requestId)
    {
        $this->request = Request::findOrFail($requestId);
        $this->declineRequestModal = true;
    }

    public function declineRequest()
    {
        $this->authorize('approve-requests');

        $this->request->update(['status' => 'declined']);

        $this->request->user->notify(new RequestDeclined($this->request));

        $this->declineRequestModal = false;

        $this->dispatch('declined');

        try{
            $this->success('Request declined!');
        } catch (\Exception $e) {
            $this->error('Error declining the request!');
        }
    }
}
