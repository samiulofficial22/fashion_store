@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<h2>Edit Category</h2>

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status', $category->status)==1?'selected':'' }}>Active</option>
            <option value="0" {{ old('status', $category->status)==0?'selected':'' }}>Inactive</option>
        </select>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
