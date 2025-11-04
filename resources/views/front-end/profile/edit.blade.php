@extends('layouts.frontend')
@section('title', 'My Profile')

@section('content')
<div class="container my-5">
    <h2>👤 My Profile</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Profile Image</label><br>
            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}" width="100" class="rounded-circle mb-2">
            <input type="file" name="avatar" class="form-control">
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="2">{{ auth()->user()->address }}</textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Update Profile</button>
    </form>
</div>
@endsection
