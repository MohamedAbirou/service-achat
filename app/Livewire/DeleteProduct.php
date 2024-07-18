<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteProduct extends Component
{
    use Toast;

    public int|null $product;

    public bool $deleteProductModal = false;

    public function render()
    {
        return view('livewire.delete-product');
    }


    #[On('openDeleteProductModal')]
    public function openDeleteProductModal(int $product)
    {
        $this->product = $product;
        $this->deleteProductModal = true;
    }

    public function delete()
    {
        Product::destroy($this->product);

        $this->deleteProductModal = false;
        $this->product = null;

        $this->dispatch('deleted');

        $this->success('Product deleted successfully');
    }
}
