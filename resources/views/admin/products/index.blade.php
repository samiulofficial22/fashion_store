@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0">
        🛍️ Products <small class="text-muted fs-6">({{ $products->total() }})</small>
    </h2>

    <div class="d-flex gap-2">
        {{-- 🔍 Search --}}
        <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control form-control-sm me-2"
                placeholder="Search product...">
            <button class="btn btn-outline-primary btn-sm" type="submit">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        {{-- ➕ Add Product --}}
        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Discount Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key => $product)
                        <tr>
                            <td class="text-center fw-semibold text-muted">
                                {{ $products->firstItem() + $key }}
                            </td>

                            {{-- Thumbnail --}}
                            <td class="text-center">
                                <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/60x60?text=No+Img' }}"
                                     alt="thumb" width="55" height="55"
                                     class="rounded shadow-sm border">
                            </td>

                            {{-- Name --}}
                            <td class="fw-semibold">{{ $product->name }}</td>

                            {{-- Category --}}
                            <td class="text-muted">{{ $product->category->name ?? '—' }}</td>

                            {{-- Price --}}
                            <td class="text-success fw-semibold">${{ number_format($product->price, 2) }}</td>

                            {{-- Discount --}}
                            <td class="text-center">
                                @if(!empty($product->discount))
                                    <span class="badge bg-success">{{ $product->discount }}%</span>
                                @else
                                    <span class="badge bg-secondary">0%</span>
                                @endif
                            </td>

                            {{-- Discount Price --}}
                            <td class="fw-semibold text-info text-center">
                                ${{ number_format($product->discount_price ?? $product->price, 2) }}
                            </td>

                            {{-- Stock --}}
                            <td class="text-center">
                                @if($product->stock > 0)
                                    <span class="badge bg-info text-dark">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                <span class="badge {{ $product->status == 'active' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.show', $product->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <i class="bi bi-box"></i> No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="card-footer bg-light border-top py-3">
            <div class="d-flex justify-content-end">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    @endif
</div>

@endsection
