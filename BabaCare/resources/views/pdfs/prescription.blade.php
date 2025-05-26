<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Obat - {{ $prescription->prescription_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            margin: 15px;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-radius: 8px;
        }
        
        .hospital-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #007bff;
        }
        
        .hospital-info {
            font-size: 10px;
            margin-bottom: 2px;
            color: #6c757d;
        }
        
        .prescription-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0 10px 0;
            background-color: #007bff;
            color: white;
            padding: 8px;
            border-radius: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-box {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
            background-color: #f8f9fa;
        }
        
        .info-header {
            font-weight: bold;
            font-size: 12px;
            color: #007bff;
            margin-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 4px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 4px;
        }
        
        .info-label {
            font-weight: bold;
            width: 80px;
            flex-shrink: 0;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
        }
        
        .allergy-alert {
            background-color: #f8d7da;
            border: 2px solid #dc3545;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .allergy-alert h4 {
            margin: 0 0 5px 0;
            color: #721c24;
            font-size: 12px;
            font-weight: bold;
        }
        
        .allergy-alert p {
            margin: 0;
            color: #721c24;
            font-size: 10px;
        }
        
        .prescription-content {
            border: 2px solid #007bff;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }
        
        .prescription-content h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        
        .medication-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #28a745;
            border-left: 4px solid #28a745;
            background-color: white;
            border-radius: 4px;
        }
        
        .medication-name {
            font-weight: bold;
            font-size: 12px;
            color: #28a745;
            margin-bottom: 5px;
        }
        
        .medication-details {
            color: #495057;
            font-size: 10px;
        }
        
        .detail-item {
            margin-bottom: 2px;
        }
        
        .label {
            font-weight: bold;
            color: #6c757d;
        }
        
        .instructions {
            margin-top: 10px;
            padding: 8px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
        }
        
        .instructions h4 {
            margin: 0 0 5px 0;
            font-size: 11px;
            color: #856404;
        }
        
        .instructions ul {
            margin: 0;
            padding-left: 15px;
            font-size: 9px;
        }
        
        .instructions li {
            margin-bottom: 2px;
            color: #856404;
        }
        
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: end;
        }
        
        .date-issued {
            font-size: 10px;
            color: #495057;
        }
        
        .signature-section {
            text-align: center;
            width: 200px;
            /* border: 1px solid #dee2e6;
            border-radius: 6px; */
            padding: 10px;
            background-color: transparent;
        }
        
        .signature-title {
            font-weight: bold;
            margin-bottom: 30px;
            color: #495057;
            font-size: 11px;
        }
        
        .signature-line {
            border-top: 2px solid #007bff;
            padding-top: 5px;
            font-weight: bold;
            color: #007bff;
            font-size: 10px;
        }
        
        .no-medication {
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border: 2px dashed #6c757d;
            border-radius: 6px;
            color: #6c757d;
            font-style: italic;
            font-size: 10px;
        }
        
        .bottom-note {
            margin-top: 15px;
            font-size: 8px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
        }
        
        @media print {
            body { 
                margin: 10px;
                font-size: 10px;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="hospital-name">{{ config('hospital.origin_hospital_name') }}</div>
        <div class="hospital-info">{{ config('hospital.origin_hospital_address') }}</div>
        <div class="hospital-info">Telp: {{ config('hospital.origin_hospital_phone') }} | Email: {{ config('hospital.origin_hospital_email') }}</div>
        <!-- <div class="hospital-info">Izin Operasional: 1234/DINKES/2020</div> -->
    </div>

    <div class="prescription-title">RESEP OBAT</div>

    <div class="info-grid">
        <div class="info-box">
            <div class="info-header">INFORMASI RESEP & PASIEN</div>
            <div class="info-row">
                <span class="info-label">No. Resep:</span>
                <span class="info-value"><strong>{{ $prescription->prescription_code }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal:</span>
                <span class="info-value">{{ $prescription->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Pasien:</span>
                <span class="info-value"><strong>{{ $prescription->patient->nama_pasien ?? 'N/A' }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">NIK:</span>
                <span class="info-value">{{ $prescription->patient->nik ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Gender:</span>
                <span class="info-value">{{ $prescription->patient->gender ?? 'N/A' }}</span>
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-header">INFORMASI MEDIS</div>
            <div class="info-row">
                <span class="info-label">Keluhan:</span>
                <span class="info-value">{{ $prescription->patient->keluhan ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Diagnosis:</span>
                <span class="info-value">{{ $prescription->patient->penyakit ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Hasil:</span>
                <span class="info-value">{{ $prescription->patient->hasil_pemeriksaan ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dokter:</span>
                <span class="info-value">{{ $prescription->staff->name ?? 'Dr. [Nama Dokter]' }}</span>
            </div>
        </div>
    </div>

    @if($prescription->patient->allergy || $prescription->drugs_allergies)
    <div class="allergy-alert">
        <h4>PERINGATAN ALERGI</h4>
        @if($prescription->patient->allergy)
            <p><strong>Alergi:</strong> {{ $prescription->patient->allergy }}</p>
        @endif
        @if($prescription->drugs_allergies)
            <p><strong>Catatan:</strong> {{ $prescription->drugs_allergies }}</p>
        @endif
    </div>
    @endif

    <div class="prescription-content">
        <h3>OBAT YANG DIRESEPKAN</h3>
        
        @if($prescription->patient->obat_id && $prescription->patient->obat)
            <div class="medication-item">
                <div class="medication-name">
                    R/ {{ $prescription->patient->obat->nama_obat ?? 'Nama Obat Tidak Tersedia' }}
                </div>
                <div class="medication-details">
                    <div class="detail-item">
                        <span class="label">Jenis:</span> {{ $prescription->patient->obat->jenis_obat ?? 'N/A' }}
                    </div>
                    <div class="detail-item">
                        <span class="label">Cara Pakai:</span> Sesuai petunjuk dokter
                    </div>
                </div>
            </div>
        @else
            <div class="no-medication">
                <p><strong>Tidak ada obat tersimpan dalam sistem</strong></p>
            </div>
            
            <!-- Template untuk diisi manual -->
            <div class="medication-item">
                <div class="medication-name">R/ ________________</div>
                <div class="medication-details">
                    <div class="detail-item"><span class="label">Dosis:</span> ________________</div>
                    <div class="detail-item"><span class="label">Cara pakai:</span> ________________</div>
                </div>
            </div>
        @endif
        
        <div class="instructions">
            <h4>PETUNJUK UMUM:</h4>
            <ul>
                <li>Minum obat sesuai dosis yang ditentukan</li>
                <li>Habiskan antibiotik meski sudah sembuh</li>
                <li>Simpan di tempat sejuk dan kering</li>
                <li>Konsultasi jika ada efek samping</li>
                <li>Perhatikan tanggal kedaluwarsa</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <div class="date-issued">
            <strong>{{ $prescription->created_at->format('d F Y') }}</strong>
        </div>
        
        <div class="signature-section">
            <div class="signature-title">Dokter Pemeriksa</div>
            <div class="signature-line">
                {{ $prescription->staff->name ?? 'Dr. [Nama Dokter]' }}
            </div>
        </div>
    </div>

    <div class="bottom-note">
        <p><strong>PENTING:</strong> Resep ini hanya berlaku untuk satu kali pengambilan obat dan tidak dapat dipindahtangankan</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>