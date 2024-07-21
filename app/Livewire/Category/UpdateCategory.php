<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class UpdateCategory extends Component
{
    use Toast;

    public $category;
    public $name;

    public bool $updateCategoryModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    #[On('openUpdateCategoryModal')]
    public function openUpdateCategoryModal(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->updateCategoryModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
        ]);

        $this->dispatch('saved');
        $this->updateCategoryModal = false;

        $this->success('Category updated successfully');
    }

    public function render()
    {
        return view('livewire.update-category');
    }
}
