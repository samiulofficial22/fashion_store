@extends('admin.layout')

@section('title', 'Users')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Users <span style="font-weight: normal; font-size: 0.8em;">({{ $users->total() }})</span></h4>

        <form class="d-flex" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" 
                   value="{{ $search }}" placeholder="Search users...">
            <button class="btn btn-dark btn-sm ms-2">Search</button>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <!--<th>Status</th>-->
                    <th width="150">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>

                    <td>
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" width="40" height="40" class="rounded-circle">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" width="40" height="40" class="rounded-circle">
                        @endif
                    </td>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email ?? 'N/A' }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>

                    <!--<td>
                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>-->

                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this user?')" 
                                    class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-3">No users found</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="card-footer">
        {{ $users->links() }}
    </div>

</div>
@endsection
