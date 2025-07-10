<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .footer-total { font-weight: bold; background: #ddd; }
    </style>
</head>
<body>
    <h2 style="text-align: center;"> Laporan Penjualan</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Bulan</th>
                <th>Nama User</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $s)
            <tr>
                <td>{{ $s->created_at->format('d-m-Y') }}</td>
                <td>{{ $s->created_at->format('F') }}</td>
                <td>{{ $s->user->name }}</td>
                <td>{{ $s->product->product_name }}</td>
                <td>{{ $s->quantity }}</td>
                <td>Rp {{ number_format($s->product->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($s->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="footer-total">
                <td colspan="6" style="text-align:right;">Total Keseluruhan:</td>
                <td>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
