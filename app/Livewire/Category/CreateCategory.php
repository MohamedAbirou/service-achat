<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateCategory extends Component
{
    use Toast;

    public $name;

    public bool $createCategoryModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.category.create-category');
    }

    #[On('openCreateCategoryModal')]
    public function openCreateCategoryModal()
    {
        $this->reset();
        $this->createCategoryModal = true;
    }

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
        ]);

        $this->dispatch('created');
        $this->createCategoryModal = false;
        $this->reset();

        $this->success('Category created successfully');
    }
}
