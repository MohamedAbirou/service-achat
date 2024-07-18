<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class UpdateProduct extends Component
{
    use WithFileUploads, Toast;

    public Product $product;

    public string $name = '';
    public float $price = 0.0;

    // UploadedFile or string
    public UploadedFile|string|null $image = null;

    public ?int $category_id = null;

    public bool $in_stock = false;

    public bool $updateProductModal = false;

    protected $rules = [
        'name' => 'required|string|max:155',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|max:1024',
        'category_id' => 'required|exists:categories,id',
        'in_stock' => 'required|boolean',
    ];

    #[On('openUpdateProductModal')]
    public function openUpdateProductModal(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->image = $product->image ? Storage::url($product->image) : null;
        $this->category_id = $product->category_id;
        $this->in_stock = $product->in_stock;
        $this->updateProductModal = true;
    }

    public function update()
    {
        $this->validate();

        $imageName = time() . '.' . $this->image->extension();

        // Store the image in the public/products directory
        $imagePath = $this->image->storePubliclyAs('products', $imageName, 'public');

        $this->product->update([
            'name'=> $this->name,
            'price' => $this->price,
            'image' => $imagePath,
            'category_id' => $this->category_id,
            'in_stock' => $this->in_stock,
        ]);

        $this->dispatch('saved');
        $this->updateProductModal = false;

        $this->success('Product updated successfully');
    }

    public function render()
    {
        // Get all categories
        $categories = Category::all();
        return view('livewire.update-product', compact('categories'));
    }
}
