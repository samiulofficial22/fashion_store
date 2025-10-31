@extends('admin.layout')

@section('title', 'Product Details')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0 rounded-3 overflow-hidden">
        {{-- Header --}}
        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(90deg, #0061f2, #00a6ff);">
            <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Product Details</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm shadow-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- Main Body --}}
        <div class="card-body">
            <div class="row g-4">
                {{-- Thumbnail --}}
                <div class="col-lg-4 col-md-5 text-center">
                    <div class="border rounded-3 p-3 bg-light">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                             alt="Thumbnail" class="img-fluid rounded shadow-sm mb-2" 
                             style="max-height: 300px; object-fit: cover;">
                    </div>
                    <h5 class="mt-3 text-primary fw-bold">{{ $product->name }}</h5>
                    <p class="text-muted small mb-1">Slug: {{ $product->slug }}</p>
                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                {{-- Product Info --}}
                <div class="col-lg-8 col-md-7">
                    <div class="border rounded-3 p-4 bg-white shadow-sm h-100">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">📦 Basic Information</h5>
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p><strong>Stock:</strong> {{ $product->stock }} pcs</p>

                        <div class="mt-3">
                            <h6 class="text-success fw-bold">💰 Price Details</h6>
                            <p class="mb-1"><strong>Regular Price:</strong> ৳{{ number_format($product->price, 2) }}</p>
                            <p class="mb-1"><strong>Discount Price:</strong> 
                                <span class="text-danger fw-semibold">৳{{ number_format($product->discount_price, 2) }}</span>
                            </p>
                            @if($product->discount_price < $product->price)
                                <p><span class="badge bg-warning text-dark">Discount Applied</span></p>
                            @endif
                        </div>

                        @if($product->description)
                            <hr>
                            <h6 class="fw-bold text-primary">📝 Description</h6>
                            <div class="p-3 rounded bg-light border small">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Gallery --}}
            <div class="mt-5">
                <h5 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-images me-2"></i>Product Gallery</h5>
                <div class="row g-3">
                    @forelse($product->images as $img)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="position-relative gallery-img">
                                <img src="{{ asset('storage/' . $img->image_path) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="height: 150px; width: 100%; object-fit: cover;">
                            </div>
                        </div>
                    @empty
                        <p class="text-muted ms-3">No gallery images uploaded.</p>
                    @endforelse
                </div>
            </div>

            {{-- Meta Info --}}
            <div class="mt-5">
                <h5 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-search me-2"></i>SEO Meta Information</h5>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Meta Title:</strong><br> {{ $product->meta_title ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Meta Keywords:</strong><br> {{ $product->meta_keywords ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Meta Description:</strong><br> {{ $product->meta_description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Extra Style --}}
@push('styles')
<style>
.gallery-img img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.gallery-img img:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}
</style>
@endpush
@endsection
