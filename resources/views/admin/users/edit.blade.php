@extends('admin.layout')
@section('title', 'Edit User')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Edit User</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name*</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ $user->address }}</textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button class="btn btn-primary w-100">Update</button>
        </form>
    </div>
</div>
@endsection
