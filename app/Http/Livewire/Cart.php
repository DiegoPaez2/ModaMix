<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as CartFacade;
use Illuminate\Http\Request;

class Cart extends Component
{
    public static function destroy()
    {
        return CartFacade::destroy();
    }
    public static function content()
    {
        return CartFacade::content();
    }
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ], [
            'product_id.required' => 'Debes seleccionar un producto.',
            'product_id.integer' => 'El producto seleccionado no es válido.',
            'product_id.exists' => 'El producto seleccionado no existe.',
        ]);
        $p = Product::find($validated['product_id']);
    CartFacade::add($p->id, $p->name, 1, $p->price)->associate('App\Models\Product');
        session()->flash('success', 'Item added in Cart');
        return redirect()->route('cart');
    }
    public function incQty(Request $req)
    {
        $validated = $req->validate([
            'row_id' => ['required', 'string'],
        ], [
            'row_id.required' => 'No se encontró el producto en el carrito.',
            'row_id.string' => 'El identificador del producto no es válido.',
        ]);
        $rowId = $validated['row_id'];
    $product = CartFacade::get($rowId);
    $qty = $product->qty + 1;
    CartFacade::update($rowId, $qty);
        return redirect()->route('cart');
    }
    public function decQty(Request $req)
    {
        $validated = $req->validate([
            'row_id' => ['required', 'string'],
        ], [
            'row_id.required' => 'No se encontró el producto en el carrito.',
            'row_id.string' => 'El identificador del producto no es válido.',
        ]);
        $rowId = $validated['row_id'];
    $product = CartFacade::get($rowId);
    $qty = max($product->qty - 1, 1);
    CartFacade::update($rowId, $qty);
        return redirect()->route('cart');
    }
    public function destroyItem(Request $req)
    {
        $validated = $req->validate([
            'row_id' => ['required', 'string'],
        ], [
            'row_id.required' => 'No se encontró el producto en el carrito.',
            'row_id.string' => 'El identificador del producto no es válido.',
        ]);
        $rowId = $validated['row_id'];
    CartFacade::remove($rowId);
        session()->flash('success', 'Item has been removed from cart');
        return redirect()->back();
    }
    public function destroyCart(Request $req)
    {
    CartFacade::destroy();
        session()->flash('success', 'Cart has been cleared');
        return redirect()->back();
    }
    public function render()
    {
        return view('livewire.cart');
    }
}
