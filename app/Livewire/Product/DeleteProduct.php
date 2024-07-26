<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Request;
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
        return view('livewire.product.delete-product');
    }


    #[On('openDeleteProductModal')]
    public function openDeleteProductModal(int $product)
    {
        $this->product = $product;
        $this->deleteProductModal = true;
    }

    public function delete()
    {
        if (Request::where('product_id', $this->product)->exists()) {
            $this->error('Products can not be deleted if they are used in a request');

            $this->deleteProductModal = false;
            return;
        }

        Product::destroy($this->product);

        $this->redirect('/products');

        $this->deleteProductModal = false;
        $this->product = null;

        $this->dispatch('deleted');

        $this->success('Product deleted successfully');
    }
}
