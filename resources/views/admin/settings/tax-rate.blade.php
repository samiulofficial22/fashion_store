@extends('admin.layout')

@section('title', 'Tax Rate Setting')

@section('content')
<div class="container py-4">
    <h2>🧾 Tax Rate Setting</h2>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.taxrate.update') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3" style="max-width: 250px;">
            <label class="form-label">Tax Rate (%)</label>
            <input type="number" step="0.01" name="tax_rate"
                   value="{{ old('tax_rate', $setting->tax_rate ?? 2.00) }}"
                   class="form-control">
            <small class="text-muted">Enter percentage (e.g. 5 for 5%)</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Tax Rate</button>
    </form>
</div>
@endsection
