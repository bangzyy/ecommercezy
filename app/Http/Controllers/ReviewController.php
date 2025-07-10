<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'checkout_id' => 'required|exists:checkout,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string'
    ]);
   $user = Auth::user();
Review::create([
    'user_id' => $user->id,
    'product_id' => $request->product_id,
    'checkout_id' => $request->checkout_id,
    'rating' => $request->rating,
    'review' => $request->review
]);
    return redirect()->back()->with('success', 'Ulasan berhasil dikirim!');
}
}
