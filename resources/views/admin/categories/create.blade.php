@extends('admin.layout')

@section('title', 'Add Category')

@section('content')
<h2>Add Category</h2>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ old('status',1)==1?'selected':'' }}>Active</option>
            <option value="0" {{ old('status',1)==0?'selected':'' }}>Inactive</option>
        </select>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
