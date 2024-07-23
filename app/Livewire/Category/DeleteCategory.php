<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteCategory extends Component
{
    use Toast;

    public $category;

    public bool $deleteCategoryModal = false;

    public function render()
    {
        return view('livewire.category.delete-category');
    }

    #[On('openDeleteCategoryModal')]
    public function openDeleteCategoryModal(int $categoryId)
    {
        $this->category = $categoryId;
        $this->deleteCategoryModal = true;
    }

    public function delete()
    {
        if (Product::where('category_id', $this->category)->exists()) {
            $this->error('Category has products, please delete them first');

            $this->deleteCategoryModal = false;
            return;
        }

        Category::destroy($this->category);

        $this->deleteCategoryModal = false;
        $this->category = null;

        $this->dispatch('deleted');

        $this->success('Category deleted successfully');
    }
}
