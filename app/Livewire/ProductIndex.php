<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public array $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'image', 'label' => 'Image', 'sortable' => false],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'price', 'label' => 'Price'],
        ['key' => 'category_id', 'label' => 'Category', 'sortable' => false],
        ['key' => 'in_stock', 'label' => 'In Stock', 'sortable' => false],
        ['key' => 'created_at', 'label' => 'created At'],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public array $filters = ['Low to High', 'High to Low', 'In Stock', 'Out Of Stock', 'Latest', 'Oldest'];

    public string $query = '';

    public function mount()
    {
        $this->authorize('manage-products');
    }

    public function render()
    {
        $products = Product::latest()
        ->when($this->query, fn ($query, $value) => $query->where('name', 'like', '%' . $value . '%')
        ->orWhereRelation('category', 'name', 'like', '%' . $value . '%'))
        ->orderBy(...array_values($this->sortBy))->paginate(10);

        return view('livewire.product-index', [
            'products' => $products,
            'filters' => $this->filters,
        ]);
    }

    public function openCreateProductModal()
    {
        $this->dispatch('openCreateProductModal');
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


    public function search() {
        $this->resetPage();
    }
}
