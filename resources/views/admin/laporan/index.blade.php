@extends('layouts.app')
@section('title', 'Laporan BK')
@section('breadcrumb')
    <li class="breadcrumb-item">Laporan</li>
    <li class="breadcrumb-item active">
        @php
            $titles = [
                'siswa' => 'Input Data Siswa',
                'ajukan_konseling' => 'Laporan Ajukan Konseling',
                'konseling' => 'Laporan Input Data Konseling',
                'monitoring' => 'Laporan Input Data Monitoring',
                'pelanggaran' => 'Laporan Input Data Pelanggaran',
            ];
        @endphp
        {{ $titles[$selectedJenis] ?? 'Laporan' }}
    </li>
@endsection
@section('content')

@php
    $isKepalaSekolah = auth()->user()?->role === 'kepala_sekolah';
    $routePrefix = $isKepalaSekolah ? 'kepala-sekolah' : 'admin';
    $titleText = $titles[$selectedJenis] ?? 'Laporan Bimbingan Konseling';
@endphp

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>{{ $titleText }}</h4>
        <p class="text-muted mb-0">
            @if($isKepalaSekolah)
                Halaman lihat laporan {{ strtolower($titleText) }} untuk Kepala Sekolah.
            @else
                Halaman laporan {{ strtolower($titleText) }} sesuai desain perancangan.
            @endif
        </p>
    </div>
    @if(!$isKepalaSekolah)
    <div>
        <a href="{{ route("{$routePrefix}.laporan.cetak", ['jenis' => $jenisSlug ?? $selectedJenis, 'periode' => $selectedPeriode]) }}"
           target="_blank"
           class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-printer me-2"></i>Cetak / Print Laporan
        </a>
    </div>
    @endif
</div>

{{-- Card Filter Periode --}}
<div class="card shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route("{$routePrefix}.laporan.{$jenisSlug}") }}" class="row align-items-center g-3">
            <div class="col-auto">
                <label for="periode" class="col-form-label fw-semibold"><i class="bi bi-funnel me-1 text-primary"></i>Filter Periode:</label>
            </div>
            <div class="col-auto">
                <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
                    <option value="semua"   {{ $selectedPeriode === 'semua'   ? 'selected' : '' }}>Semua Waktu</option>
                    <option value="bulanan" {{ $selectedPeriode === 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahunan" {{ $selectedPeriode === 'tahunan' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>
            <div class="col-auto ms-auto text-muted small">
                Total Data: <strong class="text-dark fs-6">{{ $preview ? $preview->count() : 0 }}</strong>
            </div>
        </form>
    </div>
</div>

@if($isKepalaSekolah)
    {{-- Tampilan Laporan Resmi Cetak (Khusus Kepala Sekolah - Read Only) --}}
    <div class="card shadow-sm border-0 p-4 p-md-5 mb-4" style="background: #fff; font-family: 'Times New Roman', Times, serif; color: #000;">
        {{-- Kop Surat Laporan --}}
        <table class="w-100 mb-0" style="border-collapse: collapse;">
            <tr>
                <td style="width: 140px; height: 60px; border: 1px solid #000; padding: 8px 12px; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('images/logo-smk3.jpg') }}" alt="Logo SMK N 3 Padang" style="height: 75px; width: auto;">
                </td>
                <td style="border: 1px solid #000; padding: 8px 12px; text-align: center; vertical-align: middle;">
                    <div style="font-size: 13pt; font-weight: bold; text-transform: uppercase; margin-bottom: 4px;">BIMBINGAN KONSELING DAN MONITORING</div>
                    <div style="font-size: 13pt; font-weight: bold; text-transform: uppercase;">SMK NEGERI 3 PADANG</div>
                </td>
            </tr>
        </table>
        <div style="font-size: 12pt; font-weight: normal; text-align: center; padding: 6px; border: 1px solid #000; border-top: none; margin-bottom: 20px;">
            {{ $titleText }}
        </div>

        {{-- Tabel Data Laporan Cetak --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0" style="border: 1px solid #000; width: 100%;">
                <thead style="background-color: #d1d5db; color: #000; font-weight: bold; text-transform: uppercase; font-size: 10.5pt;">
                    @if($selectedJenis === 'siswa')
                        <tr>
                            <th style="border: 1px solid #000;">No.</th>
                            <th style="border: 1px solid #000;">ID SISWA</th>
                            <th style="border: 1px solid #000;">NISN</th>
                            <th style="border: 1px solid #000;">NAMA</th>
                            <th style="border: 1px solid #000;">JENIS KELAMIN</th>
                            <th style="border: 1px solid #000;">KELAS</th>
                            <th style="border: 1px solid #000;">ALAMAT</th>
                            <th style="border: 1px solid #000;">NO HP</th>
                        </tr>
                    @elseif($selectedJenis === 'ajukan_konseling')
                        <tr>
                            <th style="border: 1px solid #000;">No.</th>
                            <th style="border: 1px solid #000;">ID KONSELING</th>
                            <th style="border: 1px solid #000;">NAMA SISWA</th>
                            <th style="border: 1px solid #000;">TANGGAL KONSELING</th>
                            <th style="border: 1px solid #000;">KELUHAN</th>
                        </tr>
                    @elseif($selectedJenis === 'konseling')
                        <tr>
                            <th style="border: 1px solid #000;">No.</th>
                            <th style="border: 1px solid #000;">ID DATA KONSELING</th>
                            <th style="border: 1px solid #000;">NAMA SISWA</th>
                            <th style="border: 1px solid #000;">TANGGAL</th>
                            <th style="border: 1px solid #000;">MASALAH</th>
                            <th style="border: 1px solid #000;">SOLUSI</th>
                            <th style="border: 1px solid #000;">GURU BK</th>
                        </tr>
                    @elseif($selectedJenis === 'monitoring')
                        <tr>
                            <th style="border: 1px solid #000;">No.</th>
                            <th style="border: 1px solid #000;">ID MONITORING</th>
                            <th style="border: 1px solid #000;">NAMA SISWA</th>
                            <th style="border: 1px solid #000;">TANGGAL MONITORING</th>
                            <th style="border: 1px solid #000;">PERKEMBANGAN</th>
                        </tr>
                    @elseif($selectedJenis === 'pelanggaran')
                        <tr>
                            <th style="border: 1px solid #000;">No.</th>
                            <th style="border: 1px solid #000;">ID PELANGGARAN</th>
                            <th style="border: 1px solid #000;">NAMA SISWA</th>
                            <th style="border: 1px solid #000;">TANGGAL PELANGGARAN</th>
                            <th style="border: 1px solid #000;">POTONGAN POIN</th>
                            <th style="border: 1px solid #000;">TINDAKAN</th>
                        </tr>
                    @endif
                </thead>
                <tbody style="font-size: 10.5pt; color: #000;">
                    @forelse($preview as $i => $row)
                        @if($selectedJenis === 'siswa')
                            <tr>
                                <td style="border: 1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border: 1px solid #000;">{{ $row->id_siswa }}</td>
                                <td style="border: 1px solid #000;">{{ $row->nisn }}</td>
                                <td style="border: 1px solid #000;">{{ $row->nama }}</td>
                                <td style="border: 1px solid #000;">{{ $row->jenis_kelamin }}</td>
                                <td style="border: 1px solid #000;">{{ $row->kelas }}</td>
                                <td style="border: 1px solid #000;">{{ $row->alamat }}</td>
                                <td style="border: 1px solid #000;">{{ $row->no_hp }}</td>
                            </tr>
                        @elseif($selectedJenis === 'ajukan_konseling')
                            <tr>
                                <td style="border: 1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border: 1px solid #000;">{{ $row->id_konseling }}</td>
                                <td style="border: 1px solid #000;">{{ $row->siswa?->nama ?? '-' }}</td>
                                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($row->tanggal_konseling)->format('d/m/Y') }}</td>
                                <td style="border: 1px solid #000;">{{ $row->keluhan }}</td>
                            </tr>
                        @elseif($selectedJenis === 'konseling')
                            <tr>
                                <td style="border: 1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border: 1px solid #000;">{{ $row->id_data_konseling }}</td>
                                <td style="border: 1px solid #000;">{{ $row->siswa?->nama ?? '-' }}</td>
                                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                                <td style="border: 1px solid #000;">{{ $row->masalah }}</td>
                                <td style="border: 1px solid #000;">{{ $row->solusi }}</td>
                                <td style="border: 1px solid #000;">{{ $row->guru_bk }}</td>
                            </tr>
                        @elseif($selectedJenis === 'monitoring')
                            @php
                                $textLower = strtolower($row->perkembangan ?? '');
                                $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
                            @endphp
                            <tr>
                                <td style="border: 1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border: 1px solid #000;">{{ $row->id_monitoring }}</td>
                                <td style="border: 1px solid #000;">{{ $row->siswa?->nama ?? '-' }}</td>
                                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($row->tanggal_monitoring)->format('d/m/Y') }}</td>
                                <td style="border: 1px solid #000; color: {{ $isBuruk ? '#dc2626' : '#16a34a' }}; font-weight: bold;">
                                    {{ $row->perkembangan }} {{ ! $isBuruk ? '(+10 Poin)' : '' }}
                                </td>
                            </tr>
                        @elseif($selectedJenis === 'pelanggaran')
                            <tr>
                                <td style="border: 1px solid #000;">{{ $i + 1 }}</td>
                                <td style="border: 1px solid #000;">{{ $row->id_pelanggaran }}</td>
                                <td style="border: 1px solid #000;">{{ $row->siswa?->nama ?? '-' }}</td>
                                <td style="border: 1px solid #000;">{{ \Carbon\Carbon::parse($row->tanggal_pelanggaran)->format('d/m/Y') }}</td>
                                <td style="border: 1px solid #000; color: #dc2626; font-weight: bold;">-{{ $row->poin }} Poin</td>
                                <td style="border: 1px solid #000;">{{ $row->tindakan }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="10" style="border: 1px solid #000; padding: 25px; color: #6b7280;">Tidak ada data laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tanda Tangan Footer --}}
        <div class="d-flex justify-content-end mt-4 pt-2">
            <div class="text-center" style="width: 250px; font-size: 11pt; color: #000;">
                Padang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                Kepala Sekolah
                <div style="height: 70px;"></div>
                <strong>{{ $kepalaSekolah?->nama ?? '-' }}</strong><br>
                <span style="font-size: 10pt;">NIP. {{ $kepalaSekolah?->nip ?? '-' }}</span>
            </div>
        </div>
    </div>
@else
    {{-- Tabel Preview Laporan (Khusus Guru BK) --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 fw-bold border-bottom">
            <i class="bi bi-table me-2 text-primary"></i>Preview Tabel {{ $titleText }}
        </div>
        <div class="card-body p-0">

            @if($preview === null || $preview->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:3rem;opacity:0.25;display:block;margin-bottom:0.75rem;"></i>
                    <p class="mb-0">Tidak ada data untuk periode yang dipilih.</p>
                </div>

            {{-- 1. Input Data Siswa --}}
            @elseif($selectedJenis === 'siswa')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-3">No.</th>
                                <th>ID SISWA</th>
                                <th>NISN</th>
                                <th>NAMA</th>
                                <th>JENIS KELAMIN</th>
                                <th>KELAS</th>
                                <th>ALAMAT</th>
                                <th>NO HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview as $loop_index => $row)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $loop_index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $row->id_siswa }}</td>
                                <td>{{ $row->nisn }}</td>
                                <td class="fw-semibold">{{ $row->nama }}</td>
                                <td>{{ $row->jenis_kelamin }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $row->kelas }}</span></td>
                                <td>{{ $row->alamat }}</td>
                                <td>{{ $row->no_hp }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            {{-- 2. Laporan Ajukan Konseling --}}
            @elseif($selectedJenis === 'ajukan_konseling')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-3">No.</th>
                                <th>ID KONSELING</th>
                                <th>NAMA SISWA</th>
                                <th>TANGGAL KONSELING</th>
                                <th>KELUHAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview as $loop_index => $row)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $loop_index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $row->id_konseling }}</td>
                                <td>{{ $row->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_konseling)->format('d/m/Y') }}</td>
                                <td>{{ $row->keluhan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            {{-- 3. Laporan Input Data Konseling --}}
            @elseif($selectedJenis === 'konseling')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-3">No.</th>
                                <th>ID DATA KONSELING</th>
                                <th>NAMA SISWA</th>
                                <th>TANGGAL</th>
                                <th>MASALAH</th>
                                <th>SOLUSI</th>
                                <th>GURU BK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview as $loop_index => $row)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $loop_index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $row->id_data_konseling }}</td>
                                <td>{{ $row->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $row->masalah }}</td>
                                <td>{{ $row->solusi }}</td>
                                <td><span class="badge bg-info text-dark">{{ $row->guru_bk }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            {{-- 4. Laporan Input Data Monitoring --}}
            @elseif($selectedJenis === 'monitoring')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-3">No.</th>
                                <th>ID MONITORING</th>
                                <th>NAMA SISWA</th>
                                <th>TANGGAL MONITORING</th>
                                <th>PERKEMBANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview as $loop_index => $row)
                            @php
                                $textLower = strtolower($row->perkembangan ?? '');
                                $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
                            @endphp
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $loop_index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $row->id_monitoring }}</td>
                                <td>{{ $row->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_monitoring)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="{{ $isBuruk ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                        {{ $row->perkembangan }}
                                    </span>
                                    @if(! $isBuruk)
                                        <span class="badge bg-success ms-1" style="font-size:0.65rem;">+10 Poin</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            {{-- 5. Laporan Input Data Pelanggaran --}}
            @elseif($selectedJenis === 'pelanggaran')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-3">No.</th>
                                <th>ID PELANGGARAN</th>
                                <th>NAMA SISWA</th>
                                <th>TANGGAL PELANGGARAN</th>
                                <th>POTONGAN POIN</th>
                                <th>TINDAKAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview as $loop_index => $row)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $loop_index + 1 }}</td>
                                <td class="fw-semibold text-primary">{{ $row->id_pelanggaran }}</td>
                                <td>{{ $row->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pelanggaran)->format('d/m/Y') }}</td>
                                <td><span class="badge bg-danger">-{{ $row->poin }} Poin</span></td>
                                <td>{{ $row->tindakan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>
@endif

@endsection

