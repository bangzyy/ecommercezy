<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function index(){
    $carts = Cart::with('product')->where('user_id', Auth::id())->get();
    return view('cart', compact('carts'));
    }
    public function add(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'color' => 'nullable|string'
    ]);
    // Periksa apakah item dengan warna dan produk yang sama sudah ada
    $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->where('color', $request->color) // tambahkan pengecekan warna
                ->first();

    if ($cart) {
        $cart->quantity += $request->quantity;
        $cart->save();
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'quantity' => $request->quantity,
            'color' => $request->color,
        ]);
    }
    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}
    public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'color' => 'nullable|string'
    ]);
    $cart = Cart::findOrFail($id);
    $cart->update([
        'quantity' => $request->quantity,
        'color' => $request->color,
    ]);
    return redirect()->back()->with('success', 'Product Qunatity Success Updated.');
}
    public function remove($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
