<html>

<head>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <h2>🧾 Laporan Keluhan Bulanan</h2>
    <p>📅 Periode: {{ $periode }}</p>
    <p>📤 Waktu Generate: {{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>🆔</th>
                <th>🧑 Nama Penghuni</th>
                <th>🏠 Alamat</th>
                <th>📂 Kategori</th>
                <th>📝 Deskripsi</th>
                <th>📅 Tanggal</th>
                <th>🔄 Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataKeluhan as $index => $keluhan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $keluhan->penghuni->nama }}</td>
                    <td>{{ $keluhan->penghuni->alamat_unit }}</td>
                    <td>{{ $keluhan->kategori->nama_kategori }}</td>
                    <td>{{ $keluhan->deskripsi }}</td>
                    <td>{{ \Carbon\Carbon::parse($keluhan->created_at)->translatedFormat('d M Y - H:i') }}</td>
                    <td>{{ ucfirst($keluhan->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
