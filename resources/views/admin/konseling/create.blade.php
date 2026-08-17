@extends('layouts.app')

@section('title', 'Tambah Konseling')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.konseling.index') }}">Data Konseling</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-chat-dots me-2 text-success"></i>Tambah Data Konseling</h4>
</div>

<div class="card" style="max-width:680px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.konseling.store') }}">
            @csrf
            <div class="row g-3">
                <!-- Pemilihan Siswa -->
                <div class="col-12">
                    <label for="id_siswa" class="form-label">Siswa <span class="text-danger">*</span></label>
                    <select id="id_siswa" name="id_siswa" class="form-select @error('id_siswa') is-invalid @enderror" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                        <option value="{{ $s->id_siswa }}" {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                            {{ $s->nama }} ({{ $s->kelas }})
                        </option>
                        @endforeach
                    </select>
                    @error('id_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    <!-- Tombol Modal Jadwal Layanan BK tepat di bawah Pemilihan Siswa -->
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary btn-sm w-100 py-2" data-bs-toggle="modal" data-bs-target="#modalPilihJadwal">
                            <i class="bi bi-calendar-event me-2"></i>Pilih dari Jadwal Layanan BK (Otomatis Isi Tanggal & Guru BK)
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="guru_bk" class="form-label">Guru BK <span class="text-danger">*</span></label>
                    <input type="text" id="guru_bk" name="guru_bk" class="form-control @error('guru_bk') is-invalid @enderror" value="{{ old('guru_bk', $guruBkNama ?? auth()->user()?->nama) }}" required readonly>
                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Terisi otomatis sesuai akun Guru BK yang login.</small>
                    @error('guru_bk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="masalah" class="form-label">Masalah <span class="text-danger">*</span></label>
                    <textarea id="masalah" name="masalah" rows="3" class="form-control @error('masalah') is-invalid @enderror" required placeholder="Tuliskan keluhan atau masalah siswa...">{{ old('masalah') }}</textarea>
                    @error('masalah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="solusi" class="form-label">Solusi <span class="text-danger">*</span></label>
                    <textarea id="solusi" name="solusi" rows="3" class="form-control @error('solusi') is-invalid @enderror" required placeholder="Tuliskan solusi atau hasil sesi konseling...">{{ old('solusi') }}</textarea>
                    @error('solusi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 d-flex gap-2 pt-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan Data Konseling</button>
                    <a href="{{ route('admin.konseling.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
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
                                        data-tanggal="{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('Y-m-d') }}"
                                        data-guru="{{ $j->guru }}"
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
        const tgl = btn.getAttribute('data-tanggal');
        const guru = btn.getAttribute('data-guru');

        document.getElementById('tanggal').value = tgl;
        document.getElementById('guru_bk').value = guru;

        const modalEl = document.getElementById('modalPilihJadwal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        }
    }
</script>
@endpush
