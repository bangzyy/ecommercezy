<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Checkout;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class DashboardController extends Controller
{
   public function adminDashboard()
{
    $totalProducts = Product::count();
    $totalUsers = User::count();
    $totalCheckouts = Checkout::count();
    $totalRevenue = Checkout::whereIn('status', ['accepted', 'done'])->sum('total_price');
    $totalCategories = Category::count();
    // Grafik Penjualan per Bulan (untuk SQLite)
    $monthlySales = Checkout::selectRaw("strftime('%m', created_at) as month, SUM(total_price) as total")
        ->whereIn('status', ['accepted', 'done'])
        ->whereYear('created_at', now()->year)
        ->groupByRaw("strftime('%m', created_at)")
        ->orderByRaw("strftime('%m', created_at)")
        ->pluck('total', 'month');
    $labels = [];
    $data = [];
    for ($i = 1; $i <= 12; $i++) {
        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
        $labels[] = \Carbon\Carbon::create()->month($i)->format('M');
        $data[] = $monthlySales->has($month) ? $monthlySales[$month] : 0;
    }
    // Grafik Status Checkout
   $statusCounts = Checkout::select('status')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('status')
    ->pluck('total', 'status');
// pastikan nilai kosong tetap ditampilkan
$statuses = ['done', 'accepted', 'pending', 'rejected', 'cancelled'];
$statusCounts = collect($statuses)->mapWithKeys(function($status) use ($statusCounts) {
    return [$status => $statusCounts->get($status, 0)];
});
    return view('admin.dashboard', compact(
        'totalProducts',
        'totalUsers',
        'totalCheckouts',
        'totalRevenue',
        'totalCategories',
        'labels',
        'data',
        'statusCounts'
    ));
}
public function exportPdf()
{
    $sales = Checkout::with(['product', 'user'])
        ->whereIn('status', ['accepted', 'done'])
        ->orderBy('created_at')
        ->get();
    $totalKeseluruhan = $sales->sum('total_price');
    return Pdf::loadView('admin.exports.sales_pdf', compact('sales', 'totalKeseluruhan'))
        ->download('laporan_penjualan.pdf');
}
}
