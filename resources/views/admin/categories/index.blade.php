@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $cat)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->slug }}</td>
            <td>{{ $cat->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $categories->links() }}
@endsection
