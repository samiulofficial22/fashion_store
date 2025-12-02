@extends('admin.layout')

@section('content')

<h3>Home Top Sliders</h3>

<a href="{{ route('admin.hometopslider.create') }}" class="btn btn-primary mb-3">+ Add New</a>

<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Status</th>
            <th>Ordering</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sliders as $slider)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><img src="{{ asset('storage/'.$slider->image) }}" width="120"></td>
            <td>{{ $slider->title }}</td>
            <td>{{ $slider->status ? 'Active' : 'Inactive' }}</td>
            <td>{{ $slider->ordering }}</td>

            <td>
                <a href="{{ route('admin.hometopslider.edit', $slider->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('admin.hometopslider.destroy', $slider->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Trash</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
