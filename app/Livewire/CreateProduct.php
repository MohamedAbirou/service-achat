<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CreateProduct extends Component
{
    use WithFileUploads, Toast;

    public bool $createProductModal = false;
    public string $name = '';
    public float $price = 0.0;
    public ?UploadedFile $image = null;
    public ?int $category_id = null;
    public bool $in_stock = false;

    protected $rules = [
        'name' => 'required|string|max:155',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|max:1024',
        'category_id' => 'required|exists:categories,id',
        'in_stock' => 'required|boolean',
    ];

    public function render()
    {
        // Get all categories
        $categories = Category::all();
        return view('livewire.create-product', compact('categories'));
    }

    #[On('openCreateProductModal')]
    public function openCreateProductModal()
    {
        $this->reset();
        $this->createProductModal = true;
    }

    public function save()
    {
        $this->validate();

        $imageName = time() . '.' . $this->image->extension();

        // Store the image in the public/products directory
        $imagePath = $this->image->storePubliclyAs('products', $imageName, 'public');

        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
            'category_id' => $this->category_id,
            'in_stock' => $this->in_stock,
        ]);

        $this->dispatch('created');
        $this->createProductModal = false;
        $this->reset();

        $this->success('Product created successfully');
    }
}
