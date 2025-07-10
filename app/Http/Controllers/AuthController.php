<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Checkout;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    public function index(): View{
        return view('auth.login');
    }
    public function registration(): View
    {
        return view('auth.registration');
    }
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // cek role setelah berhasil login
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->withSuccess('You have Successfully logged in as Admin');
            } else {
                return redirect()->intended('/dashboard')->withSuccess('You have Successfully logged in');
            }
        }
        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }
    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);
        return redirect("login")->withSuccess('Great! You have Successfully registered');
    }
    public function showResetForm()
{
    return view('auth.reset-password');
}
public function updatePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
    ]);
    $user = \App\Models\User::where('email', $request->email)->first();
    if (!$user) {
    return back()->withErrors(['email' => 'User not found']);
}
    $user->password = bcrypt($request->password);
    $user->save();
    return redirect()->route('login')->with('success', 'Password updated successfully.');
}
    public function dashboard()
    {
        $products = Product::all();
         $categories = Category::all();
        if(Auth::check()){
            // Kalau role admin, redirect ke admin dashboard
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
                return view('admin.dashboard', compact('products'));
            }
            // kalau user biasa, ke user dashboard
            return view('dashboard', compact('products', 'categories'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    public function adminDashboard()
{
    $products = Product::all();
    $categories = Category::all();
    $totalUsers = User::count();
    $totalCheckouts = Checkout::count();
    $totalRevenue = Checkout::sum('total_price');
    return view('admin.dashboard', compact('products', 'categories', 'totalUsers', 'totalCheckouts', 'totalRevenue'));
}
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // default role user
        ]);
    }
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    public function home(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return view('home');
        }
        return redirect()->route('dashboard');
    }
}
