<?php

namespace App\Livewire\Request;

use App\Models\Product;
use App\Models\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class UpdateRequest extends Component
{
    use Toast;

    public $request;
    public $title;
    public $description;
    public $product_id;
    public $quantity;
    public $budget;
    public bool $updateRequestModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'budget' => 'required|numeric|min:0',
    ];

    #[On('openUpdateRequestModal')]
    public function openUpdateRequestModal(Request $request)
    {
        $this->request = $request;
        $this->title = $request->title;
        $this->description = $request->description;
        $this->product_id = $request->product_id;
        $this->quantity = $request->quantity;
        $this->budget = $request->budget;
        $this->updateRequestModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->request->update([
            'title' => $this->title,
            'description' => $this->description,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'budget' => $this->budget,
        ]);

        $this->dispatch('saved');
        $this->updateRequestModal = false;

        try {
            $this->success('Request updated successfully');
        } catch (\Exception $e) {
            $this->error('Error updating the request!');
        }
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.request.update-request', [
            'products' => $products
        ]);
    }
}
