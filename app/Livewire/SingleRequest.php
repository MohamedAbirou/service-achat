<?php

namespace App\Livewire;

use App\Models\Request;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;
use Livewire\Component;
use Mary\Traits\Toast;

class SingleRequest extends Component
{
    use Toast;

    public $request;

    public function mount($requestId)
    {
        $this->request = Request::findOrFail($requestId);
    }

    public function openApproveRequestModal(Request $request)
    {
        $this->dispatch('openApproveRequestModal', $request->id);
    }

    public function openDeclineRequestModal(Request $request)
    {
        $this->dispatch('openDeclineRequestModal', $request->id);
    }

    public function render()
    {
        return view('livewire.single-request', ['request' => $this->request]);
    }
}
