<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckoutController extends Controller
{
    public function create(Product $product)
    {
        $userId = Auth::id();
        $checkouts = Checkout::where('user_id', $userId)->with('product')->latest()->get();
        return view('checkout.success', compact('checkouts'));
    }
    public function index()
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kamu kosong!');
        }

        return view('success', compact('carts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'selected_carts' => 'required|array|min:1',
            'selected_carts.*' => 'integer|exists:carts,id',
        ]);
        $userId = Auth::id();
        $selectedCartIds = $request->input('selected_carts');
        $carts = Cart::where('user_id', $userId)
            ->whereIn('id', $selectedCartIds)
            ->with('product')
            ->get();
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih untuk checkout!');
        }
        $ongkir = 15000;
        foreach ($carts as $cart) {
            $totalHarga = ($cart->product->price * $cart->quantity) + $ongkir;
            Checkout::create([
                'user_id'        => $userId,
                'product_id'     => $cart->product_id,
                'quantity'       => $cart->quantity,
                'total_price'    => $totalHarga, // harga + ongkir
                'address'        => $request->address,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);
            $cart->delete();
        }
        return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
    }
    public function success()
    {
        $userId = Auth::id();
        $checkouts = Checkout::where('user_id', $userId)->with('product')->latest()->get();
        return view('checkout.success', compact('checkouts'));
    }
    public function terima($id)
    {
        $checkout = Checkout::findOrFail($id);
        if ($checkout->status === 'accepted') {
            $checkout->status = 'done';
            $checkout->save();
            return response()->json(['message' => 'Pesanan diterima dan status diperbarui.']);
        }

        return response()->json(['message' => 'Status tidak dapat dikonfirmasi.'], 400);
    }
    public function batalkan($id)
    {
        $checkout = Checkout::findOrFail($id);
        if ($checkout->status === 'pending') {
            $checkout->status = 'rejected';
            $checkout->save();
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }
        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
    }
    public function destroy($id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->delete();
        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
    // === ADMIN METHODS ===
    public function adminIndex()
    {
        // Ambil semua checkout beserta relasi user dan product
        $checkouts = Checkout::with('product', 'user')
            ->latest()
            ->get()
            ->groupBy('user_id'); // Group by user

        return view('admin.checkouts.index', [
            'groupedCheckouts' => $checkouts
        ]);
    }
    public function adminUsers()
    {
        // Ambil user yang pernah melakukan checkout
        $users = User::whereHas('checkouts')->get();
        return view('admin.checkouts.users', compact('users'));
    }
    public function adminUserCheckouts(User $user)
    {
        $checkouts = $user->checkouts()->with('product')->latest()->paginate(10);
        return view('admin.checkouts.user_checkouts', compact('user', 'checkouts'));
    }
    public function accept($checkoutId)
    {
        $checkout = Checkout::findOrFail($checkoutId);
        $checkout->update(['status' => 'accepted']);
        return response()->json(['success' => true, 'message' => 'Pesanan diterima.']);
    }
    public function reject($checkoutId)
    {
        $checkout = Checkout::findOrFail($checkoutId);
        $checkout->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => 'Pesanan ditolak.']);
    }
}
