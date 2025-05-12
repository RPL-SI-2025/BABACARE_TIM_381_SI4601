<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Rujukan Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }
        .header-details {
            font-size: 9px;
            margin-bottom: 10px;
            text-align: center;
        }
        .reference-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .patient-info table {
            width: 100%;
            font-size: 11px;
        }
        .patient-info table tr td {
            padding: 5px 0;
        }
        .patient-info .label {
            width: 30%;
            font-weight: normal;
        }
        .body-text {
            font-size: 11px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-title">{{ config('hospital.origin_hospital_name') }}</div>
        <div class="header-details">{{ config('hospital.origin_hospital_address') }} | Telp. {{ config('hospital.origin_hospital_phone') }} | Email: {{ config('hospital.origin_hospital_email') }}</div>
        <hr>
    </div>

    <div class="reference-info">
        <div>
            <p>Nomor: {{ $referral->kode_rujukan }}/{{ $referral->patient->id }}/{{ date('Y') }}<br>
            Perihal: Rujukan Medis</p>
        </div>
        <div>
            <p>Kepada Yth,<br>
            Dr. {{ $referral->destinationHospital->nama_staff }}<br>
            Di {{ $referral->destinationHospital->alamat }}<br></p>
        </div>
    </div>

    <div class="body-text">

        <p>Dengan hormat,</p>
        <p>Bersama ini kami rujuk pasien berikut untuk mendapatkan penanganan lebih lanjut di fasilitas kesehatan yang Bapak/Ibu pimpin:</p>

        <div class="patient-info">
            <table>
                <tr>
                    <td class="label">Nama Pasien</td>
                    <td>: {{ $referral->patient->nama_pasien }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td>: {{ $referral->gender }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Lahir</td>
                    <td>: {{ $referral->patient->tanggal_lahir->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td>: {{ $referral->address }}</td>
                </tr>
                <tr>
                    <td class="label">Diagnosa Sementara</td>
                    <td>: {{ $referral->hasil_pemeriksaan }}</td>
                </tr>
                <tr>
                    <td class="label">Penanganan Sementara</td>
                    <td>: {{ $referral->pengobatan_sementara }}</td>
                </tr>
                <tr>
                    <td class="label">Keadaan</td>
                    <td>: {{ $referral->keadaan_saat_rujuk }}</td>
                </tr>
            </table>
        </div>

        <p>Demikian surat rujukan ini kami buat. Besar harapan kami agar pasien tersebut dapat segera memperoleh penanganan yang diperlukan. Atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature">
        <p>{{ config('hospital.origin_city') }}, {{ $referral->created_at->format('d F Y') }}</p>
        <p>Hormat kami,</p>
        <br><br>
        <p>{{ $referral->staff->name }}</p>
    </div>
</body>
</html>