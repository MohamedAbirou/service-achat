<?php

namespace App\Livewire\Product;

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
    public ?UploadedFile $image = null;

    public ?string $imageUrl = null;

    public ?int $category_id = null;

    public bool $in_stock = false;

    public bool $updateProductModal = false;

    public function rules()
    {
        return [
            'name' => 'required|string|max:155',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024',
            'category_id' => 'required|exists:categories,id',
            'in_stock' => 'required|boolean',
        ];
    }


    #[On('openUpdateProductModal')]
    public function openUpdateProductModal(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;

        if ($product->image) {
            $this->imageUrl = Storage::url($product->image);
        }

        $this->category_id = $product->category_id;
        $this->in_stock = $product->in_stock;
        $this->updateProductModal = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->image instanceof UploadedFile) {
            // Store the image in the public/products directory
            $imagePath = $this->image->storePublicly('products', 'public');
        }

        $this->product->update([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath ?? $this->product->image,
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
        return view('livewire.product.update-product', compact('categories'));
    }
}
