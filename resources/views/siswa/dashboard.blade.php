@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-grid-1x2 me-2 text-primary"></i>Dashboard Siswa</h4>
    <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->nama }}. Ajukan konseling dan pantau riwayat Anda.</p>
</div>

@if (isset($riwayat) && $riwayat->isNotEmpty())
    @php $latestNotifId = $riwayat->first()->id_data_konseling; @endphp
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 d-none" id="alertBannerKonseling" role="alert" data-id="{{ $latestNotifId }}">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                <i class="bi bi-bell-fill fs-5"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-1"><i class="bi bi-check-circle-fill me-1"></i> Pengajuan Konseling Disetujui!</h6>
                <p class="mb-0 small text-secondary">
                    Guru BK <strong>{{ $riwayat->first()->guru_bk }}</strong> telah menyetujui konseling Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($riwayat->first()->tanggal)->format('d F Y') }}</strong>. Silakan hadir tepat waktu.
                </p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="tandaiSatuDibaca({{ $latestNotifId }})"></button>
    </div>
@endif

@php
    $tidakHadirRiwayat = isset($riwayat)
        ? $riwayat->filter(fn($r) => \Illuminate\Support\Str::contains(strtolower($r->solusi ?? ''), 'tidak hadir'))
        : collect();
@endphp
@if ($tidakHadirRiwayat->isNotEmpty())
    @php $firstAbsence = $tidakHadirRiwayat->first(); @endphp
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 d-none" id="alertBannerAbsence" role="alert" data-id="absence_{{ $firstAbsence->id_data_konseling }}">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-3 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                <i class="bi bi-envelope-exclamation-fill fs-5"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-1 text-danger"><i class="bi bi-person-x-fill me-1"></i>Peringatan Ketidakhadiran</h6>
                <p class="mb-0 small text-secondary">
                    Guru BK <strong>{{ $firstAbsence->guru_bk }}</strong> menyatakan Anda <strong>TIDAK HADIR</strong> pada sesi konseling tanggal <strong>{{ \Carbon\Carbon::parse($firstAbsence->tanggal)->format('d F Y') }}</strong>.
                    Catatan ketidakhadiran telah otomatis tercatat di Data Monitoring (-10 Poin). Silakan segera menemui Guru BK di ruang BK.
                </p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="tandaiAbsenceDibaca('absence_{{ $firstAbsence->id_data_konseling }}')"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Ajukan Konseling Form -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-plus-circle me-2"></i>Ajukan Konseling</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('siswa.ajukan-konseling') }}">
                    @csrf

                    <!-- Input tersembunyi untuk id_jadwal -->
                    <input type="hidden" name="id_jadwal" id="id_jadwal" value="">

                    <!-- Tombol Pilih Jadwal via Modal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jadwal Layanan BK <span class="text-muted fw-normal small">(Opsional)</span></label>

                        <div id="jadwal-terpilih" class="alert alert-primary py-2 px-3 d-none mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-calendar-check me-2"></i>
                                    <span id="teks-jadwal-terpilih" class="fw-semibold"></span>
                                </div>
                                <button type="button" class="btn-close btn-close-sm" onclick="batalJadwal()" title="Batalkan pilihan jadwal"></button>
                            </div>
                        </div>

                        <button type="button" id="btn-pilih-jadwal" class="btn btn-outline-primary w-100 py-2" data-bs-toggle="modal" data-bs-target="#modalPilihJadwal">
                            <i class="bi bi-calendar-event me-2"></i>Pilih dari Jadwal Layanan BK yang Tersedia
                        </button>
                        <small class="text-muted d-block mt-1">Jika jadwal dipilih, tanggal akan terisi otomatis.</small>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konseling <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_konseling" name="tanggal_konseling"
                            class="form-control form-control-lg @error('tanggal_konseling') is-invalid @enderror"
                            value="{{ old('tanggal_konseling') }}" required>
                        @error('tanggal_konseling')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="keluhan" class="form-label fw-semibold">Keluhan / Masalah <span class="text-danger">*</span></label>
                        <textarea id="keluhan" name="keluhan" rows="4"
                            class="form-control @error('keluhan') is-invalid @enderror"
                            placeholder="Ceritakan keluhan atau masalah yang ingin Anda konsultasikan..." required>{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-send me-2"></i>Kirim Pengajuan Konseling
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <!-- Riwayat Pengajuan Saya -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-clock-history me-2"></i>Pengajuan Saya</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $p)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ \Carbon\Carbon::parse($p->tanggal_konseling)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($p->keluhan, 50) }}</td>
                                <td>
                                    @if($p->isExpired())
                                        <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>Melewati Jadwal (Tidak Hadir)</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Diproses</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">Belum ada pengajuan konseling.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Jadwal Layanan BK yang Tersedia -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-calendar3 me-2"></i>Jadwal Layanan BK yang Tersedia</h5>
                <span class="badge bg-primary rounded-pill">{{ isset($jadwal) ? $jadwal->count() : 0 }} Jadwal</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Hari & Tanggal</th>
                                <th>Jam</th>
                                <th>Guru BK</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwal ?? [] as $j)
                            <tr>
                                <td class="ps-3 fw-semibold">
                                    {{ $j->hari }}, {{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d M Y') }}
                                </td>
                                <td><span class="badge bg-primary">{{ $j->jam }}</span></td>
                                <td>{{ $j->guru }}</td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-sm btn-success"
                                        data-id="{{ $j->id_jadwal }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('Y-m-d') }}"
                                        data-label="{{ $j->hari }}, {{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d M Y') }} — {{ $j->jam }} ({{ $j->guru }})"
                                        onclick="pilihJadwal(this)">
                                        <i class="bi bi-check-lg me-1"></i>Pilih
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-calendar-x fs-3 d-block mb-1 opacity-50"></i>
                                    Belum ada jadwal layanan BK yang tersedia saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Riwayat Konseling Selesai -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-success"><i class="bi bi-journal-check me-2"></i>Riwayat Konseling</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th>Masalah</th>
                                <th>Guru BK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                            @php $isAbsent = \Illuminate\Support\Str::contains(strtolower($r->solusi ?? ''), 'tidak hadir'); @endphp
                            <tr>
                                <td class="ps-3 fw-semibold">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($r->masalah, 50) }}</td>
                                <td>
                                    <span class="badge {{ $isAbsent ? 'bg-danger' : 'bg-info text-dark' }}">
                                        {{ $r->guru_bk }} {{ $isAbsent ? '(Tidak Hadir)' : '' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">Belum ada riwayat konseling.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Jadwal Layanan BK -->
<div class="modal fade" id="modalPilihJadwal" tabindex="-1" aria-labelledby="modalPilihJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="modalPilihJadwalLabel">
                    <i class="bi bi-calendar3 text-primary me-2"></i>Jadwal Layanan BK yang Tersedia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Hari</th>
                                <th>Tanggal Layanan</th>
                                <th>Jam</th>
                                <th>Guru BK</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwal as $j)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $j->hari }}</td>
                                <td>{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d M Y') }}</td>
                                <td><span class="badge bg-primary">{{ $j->jam }}</span></td>
                                <td class="fw-semibold text-dark">{{ $j->guru }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success"
                                        data-id="{{ $j->id_jadwal }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('Y-m-d') }}"
                                        data-label="{{ $j->hari }}, {{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d M Y') }} — {{ $j->jam }} ({{ $j->guru }})"
                                        onclick="pilihJadwal(this)">
                                        <i class="bi bi-check-lg me-1"></i>Pilih
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-calendar-x fs-2 d-block mb-1 opacity-50"></i>
                                    Tidak ada jadwal layanan BK yang tersedia saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function pilihJadwal(btn) {
        const id = btn.getAttribute('data-id');
        const tgl = btn.getAttribute('data-tanggal');
        const label = btn.getAttribute('data-label');

        document.getElementById('id_jadwal').value = id;
        document.getElementById('tanggal_konseling').value = tgl;

        document.getElementById('teks-jadwal-terpilih').textContent = label;
        document.getElementById('jadwal-terpilih').classList.remove('d-none');
        document.getElementById('btn-pilih-jadwal').textContent = '';
        document.getElementById('btn-pilih-jadwal').innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Ganti Jadwal Layanan BK';

        const modalEl = document.getElementById('modalPilihJadwal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    function batalJadwal() {
        document.getElementById('id_jadwal').value = '';
        document.getElementById('tanggal_konseling').value = '';
        document.getElementById('jadwal-terpilih').classList.add('d-none');
        document.getElementById('btn-pilih-jadwal').innerHTML = '<i class="bi bi-calendar-event me-2"></i>Pilih dari Jadwal Layanan BK yang Tersedia';
    }

    function tandaiAbsenceDibaca(id) {
        if (typeof getReadNotifIds === 'function') {
            let readIds = getReadNotifIds();
            if (!readIds.includes(id)) {
                readIds.push(id);
                saveReadNotifIds(readIds);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('alertBannerKonseling');
        if (banner) {
            const id = parseInt(banner.getAttribute('data-id'));
            if (typeof getReadNotifIds === 'function') {
                const readIds = getReadNotifIds();
                if (!readIds.includes(id)) {
                    banner.classList.remove('d-none');
                }
            } else {
                banner.classList.remove('d-none');
            }
        }

        const bannerAbsence = document.getElementById('alertBannerAbsence');
        if (bannerAbsence) {
            const id = bannerAbsence.getAttribute('data-id');
            if (typeof getReadNotifIds === 'function') {
                const readIds = getReadNotifIds();
                if (!readIds.includes(id)) {
                    bannerAbsence.classList.remove('d-none');
                }
            } else {
                bannerAbsence.classList.remove('d-none');
            }
        }
    });
</script>
@endpush
