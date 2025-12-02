@extends('admin.layout')

@section('content')

<h3>Trash Sliders</h3>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.hometopslider.index') }}" class="btn btn-secondary mb-3">
    ← Back to Sliders
</a>

<div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Preview</th>
            <th>Title</th>
            <th>Deleted At</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($sliders as $slider)
        <tr>
            <td>{{ $slider->id }}</td>
            <td><img src="{{ asset('storage/'.$slider->image) }}" width="80"></td>
            <td>{{ $slider->title }}</td>
            <td>{{ $slider->deleted_at->diffForHumans() }}</td>

            <td>
                <a href="{{ route('admin.hometopslider.restore', $slider->id) }}"
                   class="btn btn-success btn-sm">Restore</a>

                <form action="{{ route('admin.hometopslider.forceDelete', $slider->id) }}"
                      method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Permanently delete?')"
                            class="btn btn-danger btn-sm">Delete Forever</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

{{ $sliders->links() }}

@endsection
