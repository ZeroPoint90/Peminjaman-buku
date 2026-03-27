@extends('layout.admin')

@section('content')
<div class="container">
    <h2>Pengaturan</h2>

    <div class="card p-4 mt-3">
        <h5>Tema Tampilan</h5>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input"
                   type="checkbox"
                   id="themeToggle"
                   {{ auth()->user()->theme == 'dark' ? 'checked' : '' }}>
            <label class="form-check-label">
                Aktifkan Dark Mode
            </label>
        </div>
    </div>
</div>
@endsection