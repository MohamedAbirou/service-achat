<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public array $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Category Name'],
        ['key'=> 'created_at', 'label' => 'Created At'],
        ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
    ];

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public string $query = '';

    public function mount()
    {
        $this->authorize('manage-categories');
    }

    public function render()
    {
        $categories = Category::latest()
        ->when($this->query, fn ($query, $value) => $query->where('name', 'like', '%' . $value . '%'))
        ->orderBy(...array_values($this->sortBy))->paginate(10);

        return view('livewire.category.category-index', compact('categories'));
    }

    public function openCreateCategoryModal()
    {
        $this->dispatch('openCreateCategoryModal');
    }

    public function openUpdateCategoryModal(Category $category)
    {
        $this->dispatch('openUpdateCategoryModal', $category->id);
    }

    public function openDeleteCategoryModal(Category $category)
    {
        $this->dispatch('openDeleteCategoryModal', $category->id);
    }

    public function search() {
        $this->resetPage();
    }
}
