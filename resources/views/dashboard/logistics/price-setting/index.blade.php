@extends('dashboard.layouts.app', ['title' => 'Price Settings'])

@section('content')
    <div class="page-header">
        <h4 class="page-title">Price Settings</h4>
    </div>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <form action="{{ route('price-settings.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="base_fare" class="form-label">Base Fare</label>
            <input type="number" step="0.01" name="base_fare" class="form-control" value="{{ old('base_fare', $settings->base_fare ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="price_per_km" class="form-label">Price Per KM</label>
            <input type="number" step="0.01" name="price_per_km" class="form-control" value="{{ old('price_per_km', $settings->price_per_km ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="price_per_kg" class="form-label">Price Per KG</label>
            <input type="number" step="0.01" name="price_per_kg" class="form-control" value="{{ old('price_per_kg', $settings->price_per_kg ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="min_price" class="form-label">Minimum Price</label>
            <input type="number" step="0.01" name="min_price" class="form-control" value="{{ old('min_price', $settings->min_price ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
@endsection
