<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;

class DeleteCategory extends Component
{
    use Toast;

    public $category;

    public bool $deleteUserModal = false;

    public function render()
    {
        return view('livewire.delete-category');
    }

    #[On('openDeleteCategoryModal')]
    public function openDeleteCategoryModal(int $categoryId)
    {
        $this->category = $categoryId;
        $this->deleteCategoryModal = true;
    }

    public function delete()
    {
        Category::destroy($this->category);

        $this->deleteCategoryModal = false;
        $this->category = null;

        $this->dispatch('deleted');

        $this->success('Category deleted successfully');
    }
}
