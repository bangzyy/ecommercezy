@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-10">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }} 👋</h1>
        <a href="{{ route('admin.sales.export.pdf') }}"
            class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-2.5 rounded-lg shadow hover:bg-red-700 transition">
            ⬇ Download Laporan PDF
        </a>
    </div>
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-dashboard-card icon="fas fa-box" color="blue" title="Total Produk" :value="$totalProducts" />
        <x-dashboard-card icon="fas fa-users" color="green" title="Total Users" :value="$totalUsers" />
        <x-dashboard-card icon="fas fa-shopping-cart" color="purple" title="Total Checkout" :value="$totalCheckouts" />
        <x-dashboard-card icon="fas fa-money-bill-wave" color="yellow" title="Total Penjualan" :value="'Rp ' . number_format($totalRevenue, 0, ',', '.')" />
    </div>
    <p class="text-gray-500 text-sm">Kelola kategori, produk, pesanan, dan pelanggan dengan cepat dari sini 🚀</p>
    {{-- Grafik Penjualan --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-700 mb-4">📊 Grafik Penjualan Tahunan</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <canvas id="salesChart" height="80"></canvas>
        </div>
    </div>
    {{-- Grafik Status Checkout --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-700 mb-4">📈 Grafik Status Checkout</h2>
        <div class="bg-white p-6 rounded-lg shadow max-w-xl mx-auto">
            <canvas id="statusChart" height="80"></canvas>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Penjualan',
                data: @json($data),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                },
                legend: { display: false }
            }
        }
    });
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($statusCounts->keys()),
            datasets: [{
                data: @json($statusCounts->values()),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.7)',     // done
                    'rgba(59, 130, 246, 0.7)',    // accepted
                    'rgba(234, 179, 8, 0.7)',     // pending
                    'rgba(239, 68, 68, 0.7)',     // rejected
                    'rgba(75, 85, 99, 0.7)',
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#4B5563',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
