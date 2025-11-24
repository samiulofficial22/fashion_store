@extends('front-end.layout')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">👤 Edit Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
            </div>
            
           <div class="col-md-6 mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Profile Photo</label>
                <div class="d-flex align-items-center gap-3">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" width="80" class="rounded-circle border">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar" width="80" class="rounded-circle border">
                    @endif
                    <input type="file" name="avatar" accept="image/*" class="form-control w-auto">
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary px-4">💾 Update Profile</button>
            </div>
        </div>
    </form>
</div>
@endsection
