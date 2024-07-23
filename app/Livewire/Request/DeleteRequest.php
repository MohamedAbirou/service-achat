<?php

namespace App\Livewire\Request;

use App\Models\Product;
use App\Models\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteRequest extends Component
{
    use Toast;

    public $request;
    public bool $deleteRequestModal = false;

    public function render()
    {
        return view('livewire.request.delete-request');
    }

    #[On('openDeleteRequestModal')]
    public function openDeleteRequestModal(int $requestId)
    {
        $this->request = Request::findOrFail($requestId);
        $this->deleteRequestModal = true;
    }

    public function delete()
    {
        $this->request->delete();

        $this->deleteRequestModal = false;
        $this->request = null;

        $this->dispatch('deleted');

        try {
            $this->success('Request deleted successfully');
        } catch (\Exception $e) {
            $this->error('Error deleting the request!');
        }
    }
}
