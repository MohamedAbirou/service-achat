<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SingleProduct extends Component
{
    public $product;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
    }

    public function render()
    {
        return view('livewire.single-product', ['product' => $this->product]);
    }

    public function openUpdateProductModal(Product $product)
    {
        $this->dispatch('openUpdateProductModal', $product->id);
    }

    public function openDeleteProductModal(Product $product)
    {
        $this->dispatch('openDeleteProductModal', $product->id);
    }

    public function getCategoryName($categoryId)
    {
        return Product::where('category_id', $categoryId)->first()->category->name ?? 'N/A';
    }
}
