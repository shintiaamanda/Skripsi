@extends('layouts.app')
@section('title', 'Tampilan')
@section('breadcrumb')
    <li class="breadcrumb-item">Pengaturan</li>
    <li class="breadcrumb-item active">Tampilan</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-palette me-2 text-primary"></i>Pengaturan Tampilan</h4></div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <p class="text-muted">Sistem menggunakan tema standar Bootstrap 5 terintegrasi.</p>
    </div>
</div>
@endsection
