<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Request;
use App\Models\User;
use App\Notifications\NewRequestNotification;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateRequest extends Component
{
    use Toast;

    public $title;
    public $description;
    public $product_id;
    public $quantity;
    public $budget;
    public bool $createRequestModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'budget' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $products = Product::where('in_stock', true)->get();
         return view('livewire.create-request', compact('products'));
    }

    #[On('openCreateRequestModal')]
    public function openCreateRequestModal()
    {
        $this->createRequestModal = true;
    }

    public function save()
    {
        $this->validate();

        $request = Request::create([
            'title' => $this->title,
            'description' => $this->description,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'budget' => $this->budget,
            'user_id' => auth()->id(),
            'department' => auth()->user()->department,
            'status' => auth()->user()->role === 'employee' ? 'pending' : 'approved',
        ]);

        $this->dispatch('created');
        $this->createRequestModal = false;
        $this->reset();

        try {
            $this->notifyManagersAndAdmins($request);
            $this->success('Request created successfully!');
        } catch (\Exception $e) {
            $this->error('Error creating the request!');
        }
    }

    protected function notifyManagersAndAdmins(Request $request) {
        $usersToNotify = User::where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('role', User::ROLE_MANAGER)
                    ->where('department', $request->department);
            })->orWhere('role', User::ROLE_ADMIN);
        })->get();

        foreach($usersToNotify as $user) {
            $user->notify(new NewRequestNotification($request));
        }
    }
}
