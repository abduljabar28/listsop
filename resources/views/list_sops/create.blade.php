@extends('layouts.app')

@section('title', 'Buat SOP')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-1">➕ Buat SOP Baru</h5>
                <p class="text-muted mb-0">Isi semua informasi yang dibutuhkan untuk membuat SOP baru.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('list_sop.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">No</label>
                        <input type="text" class="form-control form-control-lg" value="Akan dibuat otomatis" disabled>
                        <div class="form-text">Nomor akan dibuat secara otomatis dari data tabel saat SOP disimpan.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="work_unit" class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('work_unit') is-invalid @enderror" id="work_unit" name="work_unit" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($workUnits as $unit)
                                        <option value="{{ $unit }}" {{ old('work_unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                                @error('work_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor POS</label>
                                <input type="text" class="form-control form-control-lg" value="Otomatis dibuat setelah disimpan" disabled>
                                <div class="form-text">Format: 01/POLSUB/XX/VI/2026 berdasarkan Nomor dan Unit Kerja.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="position_name" class="form-label">Nama POS <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('position_name') is-invalid @enderror" id="position_name" name="position_name" value="{{ old('position_name') }}" placeholder="Masukkan nama POS" required>
                        @error('position_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control form-control-lg @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pic" class="form-label">PIC</label>
                                <input type="text" class="form-control form-control-lg @error('pic') is-invalid @enderror" id="pic" name="pic" value="{{ old('pic') }}" placeholder="Masukkan PIC">
                                @error('pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Masukkan keterangan">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            💾 Simpan SOP
                        </button>
                        <a href="{{ route('list_sop.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
