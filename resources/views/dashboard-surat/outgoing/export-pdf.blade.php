<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        .meta { font-size: 12px; color: #555; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">Dicetak: {{ $generatedAt->format('d M Y H:i') }}</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Kirim</th>
                <th>Nomor Surat</th>
                <th>Penerima</th>
                <th>Perihal</th>
                <th>Jenis</th>
                <th>Unit</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letters as $letter)
                <tr>
                    <td>{{ optional($letter->sent_at)->format('d-m-Y') }}</td>
                    <td>{{ $letter->letter_number }}</td>
                    <td>{{ $letter->recipient }}</td>
                    <td>{{ $letter->subject }}</td>
                    <td>{{ $letter->letter_type }}</td>
                    <td>{{ $letter->unit_code }}</td>
                    <td>{{ $letter->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
