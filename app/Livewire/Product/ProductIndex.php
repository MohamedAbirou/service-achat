<?php

namespace App\Livewire\Product;

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
        ['key' => 'created_at', 'label' => 'Created At', 'sortable' => false],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public array $filters = [
        'low_to_high' => false,
        'high_to_low' => false,
        'in_stock' => false,
        'out_of_stock' => false,
        'latest' => false,
        'oldest' => false,
    ];

    public string $query = '';

    public function mount()
    {
        $this->authorize('manage-products');
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->query, function ($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                    ->orWhereRelation('category', 'name', 'like', '%' . $this->query . '%');
            })
            ->when($this->filters['low_to_high'], function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->filters['high_to_low'], function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->filters['in_stock'], function ($query) {
                $query->where('in_stock', true);
            })
            ->when($this->filters['out_of_stock'], function ($query) {
                $query->where('in_stock', false);
            })
            ->when($this->filters['latest'], function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($this->filters['oldest'], function ($query) {
                $query->orderBy('created_at', 'asc');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.product.product-index', [
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

    public function search()
    {
        $this->resetPage();
    }
}
