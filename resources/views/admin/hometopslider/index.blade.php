@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h3 class="">Home Top Sliders</h3>
    <a href="{{ route('admin.hometopslider.create') }}" class="btn btn-primary btn-sm ">+ Add New Slider</a>
</div>
<hr>


@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-end">
    <a href="{{ route('admin.hometopslider.trash') }}" class="btn btn-warning btn-sm mb-3">
        <i class="bi bi-trash"></i>  Trash ({{ $trashed }})
    </a>
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Preview</th>
            <th>Title</th>
            <th>Status</th>
            <th>Ordering</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($sliders as $slider)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><img src="{{ asset('storage/'.$slider->image) }}" width="80"></td>
            <td>{{ $slider->title }}</td>

            <td>
                @if($slider->status == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>

            <td>{{ $slider->ordering }}</td>

            <td>
                <a href="{{ route('admin.hometopslider.edit', $slider->id) }}" 
                   class="btn btn-info btn-sm"><i class="bi bi-pencil"></i></a>

                <form action="{{ route('admin.hometopslider.destroy', $slider->id) }}"
                      method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Move to trash?')" 
                            class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

{{ $sliders->links() }}

@endsection
