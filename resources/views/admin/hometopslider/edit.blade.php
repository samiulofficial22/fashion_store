@extends('admin.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Home Top Slider</h5>
        <a href="{{ route('admin.hometopslider.index') }}" class="btn btn-light btn-sm">← Back</a>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.hometopslider.update', $hometopslider->id) }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Left Side --}}
                <div class="col-md-8">

                    <div class="mb-3">
                        <label class="form-label"><strong>Title</strong></label>
                        <input type="text" name="title" value="{{ $hometopslider->title }}" 
                               class="form-control @error('title') is-invalid @enderror">

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Subtitle</strong></label>
                        <input type="text" name="subtitle" value="{{ $hometopslider->subtitle }}" 
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Button Text</strong></label>
                        <input type="text" name="button_text" value="{{ $hometopslider->button_text }}" 
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Button Link</strong></label>
                        <input type="text" name="button_link" value="{{ $hometopslider->button_link }}" 
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Ordering</strong></label>
                        <input type="number" name="ordering" value="{{ $hometopslider->ordering }}" 
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $hometopslider->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $hometopslider->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="col-md-4">

                    <div class="mb-3">
                        <label class="form-label"><strong>Slider Image</strong></label>
                        <input type="file" name="image" class="form-control">

                        @if($hometopslider->image)
                            <div class="mt-2">
                                <p class="mb-1"><strong>Current Image:</strong></p>
                                <img src="{{ asset('storage/'.$hometopslider->image) }}" 
                                     class="img-fluid rounded shadow-sm" width="250">
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <button class="btn btn-success mt-3 px-4">Save Changes</button>

        </form>
    </div>
</div>

@endsection
