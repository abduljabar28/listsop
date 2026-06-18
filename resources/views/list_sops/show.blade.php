@extends('layouts.app')

@section('title', 'Detail SOP')

@section('content')
<div class="row gy-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $listSop->post_number }} — {{ $listSop->position_name }}</h5>
                    <p class="text-muted mb-0">Unit Kerja: {{ $listSop->work_unit }}</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">Detail SOP</span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                        <h6 class="text-muted text-uppercase small mb-2">Nomor POS</h6>
                        <p class="mb-0">{{ $listSop->position_number }}</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <h6 class="text-muted text-uppercase small mb-2">PIC</h6>
                        <p class="mb-0">{{ $listSop->pic ?? '-' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                        <h6 class="text-muted text-uppercase small mb-2">Tanggal</h6>
                        <p class="mb-0">{{ $listSop->date ? $listSop->date->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <h6 class="text-muted text-uppercase small mb-2">ID</h6>
                        <p class="mb-0">#{{ $listSop->id }}</p>
                    </div>
                </div>

                @if ($listSop->description)
                    <div class="mb-4">
                        <h6 class="text-muted text-uppercase small mb-2">Keterangan</h6>
                        <p class="card-text fs-6">{{ $listSop->description }}</p>
                    </div>
                @endif

                <div class="row text-muted small mt-4 pt-3 border-top">
                    <div class="col-md-6 mb-2">
                        <p class="mb-1"><strong>Dibuat:</strong> {{ $listSop->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p class="mb-0"><strong>Diperbarui:</strong> {{ $listSop->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex flex-column flex-sm-row gap-3">
            <a href="{{ route('list_sop.edit', $listSop) }}" class="btn btn-warning flex-grow-1">
                ✏️ Ubah
            </a>
            <form action="{{ route('list_sop.destroy', $listSop) }}" method="POST" class="flex-grow-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Hapus SOP ini secara permanen?')">
                    🗑️ Hapus
                </button>
            </form>
            <a href="{{ route('list_sop.index') }}" class="btn btn-secondary flex-grow-1">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0">⚡ Aksi Cepat</h6>
            </div>
            <div class="card-body p-4">
                <a href="{{ route('list_sop.edit', $listSop) }}" class="btn btn-warning w-100 mb-3">
                    ✏️ Ubah SOP
                </a>
                <a href="{{ route('list_sop.create') }}" class="btn btn-success w-100 mb-3">
                    ➕ Buat Baru
                </a>
                <a href="{{ route('list_sop.index') }}" class="btn btn-info w-100">
                    📋 Lihat Semua
                </a>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0">📌 Ringkasan</h6>
            </div>
            <div class="card-body p-4 small text-muted">
                <p class="mb-3"><strong>Unit Kerja:</strong> {{ $listSop->work_unit }}</p>
                <p class="mb-3"><strong>Nomor POS:</strong> {{ $listSop->position_number }}</p>
                <p class="mb-0"><strong>Nama POS:</strong> {{ $listSop->position_name }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
