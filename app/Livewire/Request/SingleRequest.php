<?php

namespace App\Livewire\Request;

use App\Models\Request;
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
        return view('livewire.request.single-request', ['request' => $this->request]);
    }
}
