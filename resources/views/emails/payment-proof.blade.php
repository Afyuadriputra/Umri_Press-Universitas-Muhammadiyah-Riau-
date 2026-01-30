<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran Pesanan</title>
</head>
<body>
    <p>Halo Admin UMRI Press,</p>
    <p>Berikut bukti pembayaran untuk pesanan baru.</p>

    <ul>
        <li><strong>Order ID:</strong> #{{ $order->id }}</li>
        <li><strong>Buku:</strong> {{ $order->buku->judul ?? '-' }}</li>
        <li><strong>Format:</strong> {{ strtoupper($order->tipe_order) }}</li>
        <li><strong>Nama:</strong> {{ $order->recipient_name }}</li>
        <li><strong>HP:</strong> {{ $order->recipient_phone }}</li>
        <li><strong>Email:</strong> {{ $order->recipient_email }}</li>
        <li><strong>Pembayaran:</strong>
            {{ $paymentMethod ? $paymentMethod->name : '-' }}
            @if ($paymentMethod && $paymentMethod->account_number)
                - {{ $paymentMethod->account_number }} ({{ $paymentMethod->account_name }})
            @endif
        </li>
        <li><strong>Harga:</strong> Rp {{ number_format($order->harga_setelah_diskon ?? $order->harga_asli, 0, ',', '.') }}</li>
        <li><strong>Alamat:</strong> {{ $order->alamat_lengkap }}</li>
    </ul>

    @if ($proofUrl)
        <p>Bukti pembayaran juga bisa diakses melalui link berikut:</p>
        <p><a href="{{ $proofUrl }}" target="_blank">Buka bukti pembayaran</a></p>
    @endif

    <p>File bukti pembayaran juga terlampir pada email ini.</p>
    <p>Terima kasih.</p>
</body>
</html>
