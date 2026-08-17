<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>
        @php
            $titles = [
                'siswa' => 'Input Data Siswa',
                'ajukan_konseling' => 'Laporan Ajukan Konseling',
                'konseling' => 'Laporan Input Data Konseling',
                'monitoring' => 'Laporan Input Data Monitoring',
                'pelanggaran' => 'Laporan Input Data Pelanggaran',
            ];
            $currentTitle = $titles[$jenis] ?? 'Laporan BK';
        @endphp
        {{ $currentTitle }} — SMK Negeri 3 Padang
    </title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        /* Top Header Box Layout */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-table td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo-cell {
            width: 140px;
            height: 60px;
        }
        .kop-title-main {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .kop-title-sub {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop-report-title {
            font-size: 12pt;
            font-weight: normal;
            text-align: center;
            padding: 6px;
            border: 1px solid #000;
            border-top: none;
        }

        /* Main Data Table Layout */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -1px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
            vertical-align: middle;
            font-size: 10.5pt;
        }
        .data-table th {
            background-color: #d1d5db; /* Solid grey header as in design */
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Footer Signature */
        .footer-container {
            margin-top: 30px;
            width: 100%;
        }
        .signature-box {
            float: right;
            text-align: center;
            width: 250px;
            font-size: 11pt;
        }
        .signature-space {
            height: 70px;
        }

        .clear {
            clear: both;
        }

        /* Print Controls */
        .no-print-bar {
            background: #f3f4f6;
            padding: 10px 15px;
            border-bottom: 1px solid #d1d5db;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-print {
            background: #1e40af;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-print:hover {
            background: #1e3a8a;
        }

        @media print {
            .no-print-bar { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Bar Tombol Cetak (Hanya tampil di layar) -->
    <div class="no-print-bar">
        <div>
            <strong>Cetak Laporan:</strong> {{ $currentTitle }}
        </div>
        <div>
            <button onclick="window.print()" class="btn-print">🖨️ Cetak Halaman</button>
            <button onclick="window.close()" class="btn-print" style="background:#6b7280; margin-left: 6px;">Tutup</button>
        </div>
    </div>

    <!-- Header Laporan (Sesuai Desain Output Perancangan) -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo-cell">
                <img src="{{ asset('images/logo-smk3.jpg') }}" alt="Logo SMK N 3 Padang" style="height: 75px; width: auto;">
            </td>
            <td>
                <div class="kop-title-main">BIMBINGAN KONSELING DAN MONITORING</div>
                <div class="kop-title-sub">SMK NEGERI 3 PADANG</div>
            </td>
        </tr>
    </table>

    <div class="kop-report-title">
        {{ $currentTitle }}
    </div>

    <!-- Tabel Data Laporan (Sesuai Fields Desain Gambar) -->
    <table class="data-table">
        <thead>
            @if($jenis === 'siswa')
                <tr>
                    <th>No.</th>
                    <th>ID SISWA</th>
                    <th>NISN</th>
                    <th>NAMA</th>
                    <th>JENIS KELAMIN</th>
                    <th>KELAS</th>
                    <th>ALAMAT</th>
                    <th>NO HP</th>
                </tr>
            @elseif($jenis === 'ajukan_konseling')
                <tr>
                    <th>No.</th>
                    <th>ID KONSELING</th>
                    <th>NAMA SISWA</th>
                    <th>TANGGAL KONSELING</th>
                    <th>KELUHAN</th>
                </tr>
            @elseif($jenis === 'konseling')
                <tr>
                    <th>No.</th>
                    <th>ID DATA KONSELING</th>
                    <th>NAMA SISWA</th>
                    <th>TANGGAL</th>
                    <th>MASALAH</th>
                    <th>SOLUSI</th>
                    <th>GURU BK</th>
                </tr>
            @elseif($jenis === 'monitoring')
                <tr>
                    <th>No.</th>
                    <th>ID MONITORING</th>
                    <th>NAMA SISWA</th>
                    <th>TANGGAL MONITORING</th>
                    <th>PERKEMBANGAN</th>
                </tr>
            @elseif($jenis === 'pelanggaran')
                <tr>
                    <th>No.</th>
                    <th>ID PELANGGARAN</th>
                    <th>NAMA SISWA</th>
                    <th>TANGGAL PELANGGARAN</th>
                    <th>POTONGAN POIN</th>
                    <th>TINDAKAN</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @forelse($data as $i => $row)
                @if($jenis === 'siswa')
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_siswa }}</td>
                        <td>{{ $row->nisn }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->jenis_kelamin }}</td>
                        <td>{{ $row->kelas }}</td>
                        <td>{{ $row->alamat }}</td>
                        <td>{{ $row->no_hp }}</td>
                    </tr>
                @elseif($jenis === 'ajukan_konseling')
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_konseling }}</td>
                        <td>{{ $row->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_konseling)->format('d/m/Y') }}</td>
                        <td>{{ $row->keluhan }}</td>
                    </tr>
                @elseif($jenis === 'konseling')
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_data_konseling }}</td>
                        <td>{{ $row->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $row->masalah }}</td>
                        <td>{{ $row->solusi }}</td>
                        <td>{{ $row->guru_bk }}</td>
                    </tr>
                @elseif($jenis === 'monitoring')
                    @php
                        $textLower = strtolower($row->perkembangan ?? '');
                        $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_monitoring }}</td>
                        <td>{{ $row->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_monitoring)->format('d/m/Y') }}</td>
                        <td style="color: {{ $isBuruk ? '#dc2626' : '#16a34a' }}; font-weight: bold;">
                            {{ $row->perkembangan }} {{ ! $isBuruk ? '(+10 Poin)' : '' }}
                        </td>
                    </tr>
                @elseif($jenis === 'pelanggaran')
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->id_pelanggaran }}</td>
                        <td>{{ $row->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_pelanggaran)->format('d/m/Y') }}</td>
                        <td style="color: #dc2626; font-weight: bold;">-{{ $row->poin }} Poin</td>
                        <td>{{ $row->tindakan }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="10" style="padding: 25px; color: #6b7280;">Tidak ada data laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Footer (Sesuai Gambar Desain) -->
    <div class="footer-container">
        <div class="signature-box">
            Padang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
            Kepala Sekolah
            <div class="signature-space"></div>
            <strong>{{ $kepalaSekolah?->nama ?? '-' }}</strong><br>
            <span style="font-size: 10pt;">NIP. {{ $kepalaSekolah?->nip ?? '-' }}</span>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
