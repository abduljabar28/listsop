@extends('layouts.app')

@section('title', "Daftar SOP - {$workUnit}")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <div>
                <p class="text-uppercase text-primary mb-1 fw-semibold">Sistem SOP</p>
                <h1 class="mb-0">📋 Daftar SOP {{ $workUnit }}</h1>
                <p class="text-muted mb-0">Menampilkan SOP khusus untuk unit kerja {{ $workUnit }}.</p>
            </div>
            <a href="{{ route('list_sop.create') }}" class="btn btn-success btn-lg px-4">
                ➕ Buat SOP Baru
            </a>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group" aria-label="Unit Kerja">
                    <a href="{{ route('list_sop.index') }}" class="btn btn-outline-primary{{ request()->routeIs('list_sop.index') ? ' active' : '' }}">Semua Unit</a>
                    @foreach ($workUnits as $unit)
                        <a href="{{ route('list_sop.unit', ['workUnit' => \App\Models\ListSop::workUnitSlug($unit)]) }}" class="btn btn-outline-primary{{ $workUnit === $unit ? ' active' : '' }}">{{ $unit }}</a>
                    @endforeach
                </div>

                <div class="btn-group" role="group" aria-label="Per Page">
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 25, 'page' => 1]) }}" class="btn btn-outline-secondary{{ (int)request('per_page') === 25 ? ' active' : '' }}">25</a>
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 50, 'page' => 1]) }}" class="btn btn-outline-secondary{{ (int)request('per_page') === 50 ? ' active' : '' }}">50</a>
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 100, 'page' => 1]) }}" class="btn btn-outline-secondary{{ (int)request('per_page') === 100 ? ' active' : '' }}">100</a>
                </div>
            </div>
        </div>

        @if ($listSops->count())
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><a href="{{ \App\Models\ListSop::sortUrl('number', $sort, $direction) }}" style="text-decoration:none; color:inherit;">No{{ \App\Models\ListSop::sortIndicator('number', $sort, $direction) }}</a></th>
                                <th><a href="{{ \App\Models\ListSop::sortUrl('work_unit', $sort, $direction) }}" style="text-decoration:none; color:inherit;">Unit Kerja{{ \App\Models\ListSop::sortIndicator('work_unit', $sort, $direction) }}</a></th>
                                <th><a href="{{ \App\Models\ListSop::sortUrl('position_number', $sort, $direction) }}" style="text-decoration:none; color:inherit;">Nomor POS{{ \App\Models\ListSop::sortIndicator('position_number', $sort, $direction) }}</a></th>
                                <th><a href="{{ \App\Models\ListSop::sortUrl('position_name', $sort, $direction) }}" style="text-decoration:none; color:inherit;">Nama POS{{ \App\Models\ListSop::sortIndicator('position_name', $sort, $direction) }}</a></th>
                                <th><a href="{{ \App\Models\ListSop::sortUrl('date', $sort, $direction) }}" style="text-decoration:none; color:inherit;">Tanggal{{ \App\Models\ListSop::sortIndicator('date', $sort, $direction) }}</a></th>
                                <th>Keterangan</th>
                                <th>PIC</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listSops as $sop)
                                <tr>
                                    <td><strong>{{ $sop->number }}</strong></td>
                                    <td>{{ $sop->work_unit }}</td>
                                    <td>{{ $sop->position_number }}</td>
                                    <td>{{ $sop->position_name }}</td>
                                    <td>
                                        @if ($sop->date)
                                            <small class="text-muted">{{ $sop->date->format('d M Y') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($sop->description, 45) }}</td>
                                    <td>{{ $sop->pic ?? '-' }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('list_sop.show', $sop) }}" class="btn btn-info" title="Lihat">👁️</a>
                                            <a href="{{ route('list_sop.edit', $sop) }}" class="btn btn-warning" title="Ubah">✏️</a>
                                            <form action="{{ route('list_sop.destroy', $sop) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Hapus SOP ini?')">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ((int) request('per_page', 10) === 10 && $listSops->hasPages())
                <div class="mt-3 d-flex justify-content-end gap-2">
                    @if ($listSops->onFirstPage())
                        <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                    @else
                        <a href="{{ $listSops->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm">Previous</a>
                    @endif

                    @if ($listSops->hasMorePages())
                        <a href="{{ $listSops->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm">Next</a>
                    @else
                        <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
                    @endif
                </div>
            @endif

        @else
            <div class="alert alert-info text-center py-5 rounded-4" role="alert">
                <h4 class="alert-heading mb-3">📭 Tidak ada SOP untuk unit ini</h4>
                <p class="mb-3">Belum ada SOP yang tersedia untuk unit kerja {{ $workUnit }}.</p>
                <a href="{{ route('list_sop.create') }}" class="btn btn-success btn-lg px-4">Buat SOP Baru</a>
            </div>
        @endif
    </div>
</div>
@endsection
