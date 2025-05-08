<html>
<head>
    <title>Laporan Data Pasien</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Data Pasien</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Pasien</th>
                <th>NIK</th>
                <th>Gender</th>
                <th>Penyakit</th>
                <th>Waktu Periksa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $p)
            <tr>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->nik }}</td>
                <td>{{ $p->gender }}</td>
                <td>{{ $p->penyakit }}</td>
                <td>{{ $p->waktu_periksa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 