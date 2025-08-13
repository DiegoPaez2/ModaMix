<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
class AdminInventory extends Component
{
    use WithPagination;

    public function getPerdidas()
    {
        // Pérdidas: productos que no se han vendido (order_items_count = 0)
        return \App\Models\Product::withCount('orderItems')
            ->where('order_items_count', 0)
            ->count();
    }
    public function getTopProducts()
    {
        return \App\Models\Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
    }

    public function getGanancias()
    {
        return \App\Models\Order::sum('total');
    }
    public $modalOpen = false;
    public $editProductId = null;
    public $form = [
        'name' => '',
        'price' => '',
        'old_price' => '',
        'quantity' => '',
        'stock_status' => 'instock',
        'category_id' => '',
        'brief_description' => '',
        'description' => '',
    ];

    public function openModal($id = null) {
        $this->modalOpen = true;
        $this->editProductId = $id;
        if ($id) {
            $product = Product::find($id);
            $this->form = [
                'name' => $product->name,
                'price' => $product->price,
                'old_price' => $product->old_price,
                'quantity' => $product->quantity,
                'stock_status' => $product->stock_status,
                'category_id' => $product->categories->first()->id ?? '',
                'brief_description' => $product->brief_description,
                'description' => $product->description,
            ];
        } else {
            $this->form = [
                'name' => '',
                'price' => '',
                'old_price' => '',
                'quantity' => '',
                'stock_status' => 'instock',
                'category_id' => '',
                'brief_description' => '',
                'description' => '',
            ];
        }
    }

    public function closeModal() {
        $this->modalOpen = false;
        $this->editProductId = null;
    }

    public function saveProduct() {
        $data = $this->form;
        if ($this->editProductId) {
            $product = Product::find($this->editProductId);
            $product->update($data);
        } else {
            $product = Product::create($data);
        }
        if ($data['category_id']) {
            $product->categories()->sync([$data['category_id']]);
        }
        $this->closeModal();
    }

    public function deleteProduct($id) {
        Product::find($id)->delete();
    }

    public $search = '';
    public $filterStock = '';
    public $filterCategory = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStock() { $this->resetPage(); }
    public function updatingFilterCategory() { $this->resetPage(); }

    public function render()
    {
        $query = Product::with('categories');
        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }
        if ($this->filterStock) {
            $query->where('stock_status', $this->filterStock);
        }
        if ($this->filterCategory) {
            $query->whereHas('categories', function($q) {
                $q->where('name', $this->filterCategory);
            });
        }
        $products = $query->paginate(10);
        $categories = \App\Models\Category::all();
        return view('livewire.admin-inventory', compact('products', 'categories'));
    }
}
