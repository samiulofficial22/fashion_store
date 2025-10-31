@extends('admin.layout')

@section('title', 'Add Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">➕ Add New Product</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Please fix the following errors:
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                {{-- Name --}}
                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Price --}}
                <div class="col-md-4">
                    <label class="form-label">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-control" step="0.01">
                </div>

                {{-- Discount --}}
                <div class="col-md-4">
                    <label class="form-label">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount') }}" class="form-control" step="1" min="0" max="100">
                </div>

                {{-- Stock --}}
                <div class="col-md-4">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="form-control" min="0">
                </div>

                {{-- Size --}}
                <div class="col-md-6">
                    <label class="form-label">Available Sizes</label>
                    <input type="text" name="sizes" value="{{ old('sizes') }}" class="form-control" placeholder="e.g. S, M, L, XL">
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Thumbnail --}}
                <div class="col-md-6">
                    <label class="form-label">Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>

                {{-- Multiple Images --}}
                {{-- Multiple Images with Preview --}}
				<div class="col-md-12">
					<label class="form-label">Product Gallery Images</label>
					<input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
					<small class="text-muted">You can select multiple images (JPEG, PNG, WEBP)</small>

					<div class="mt-3 d-flex flex-wrap gap-2" id="image-preview"></div>
				</div>


                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Write product details...">{{ old('description') }}</textarea>
                </div>

                {{-- Meta Info --}}
                <div class="col-md-4">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control" placeholder="comma, separated, keywords">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description') }}" class="form-control">
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> Save Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')
<script>
    document.getElementById('images').addEventListener('change', function(event) {
        let preview = document.getElementById('image-preview');
        preview.innerHTML = ''; // clear old previews

        for (let file of event.target.files) {
            if (!file.type.startsWith('image/')) continue;

            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('border', 'rounded', 'shadow-sm');
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

