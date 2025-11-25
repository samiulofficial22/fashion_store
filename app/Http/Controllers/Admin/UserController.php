<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Display list of users
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users', 'search'));
    }

    // Show user details
    public function show(User $user, Request $request)
    {
        // Filters
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $provider = $request->provider;
        $status = $request->status;

        // Order History with filters
        $orders = $user->orders()
            ->when($date_from, fn($q) => $q->whereDate('created_at', '>=', $date_from))
            ->when($date_to, fn($q) => $q->whereDate('created_at', '<=', $date_to))
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Example Logs
       

        return view('admin.users.show', compact(
            'user', 'orders',
            'date_from', 'date_to', 'provider', 'status'
        ));
    }


    // Show edit form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user info
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => ['nullable','email', Rule::unique('users')->ignore($user->id)],
            'phone'   => ['nullable','max:20', Rule::unique('users')->ignore($user->id)],
            'address' => 'nullable|string|max:500',
            'status'  => 'required|in:active,inactive',
        ]);

        $user->update($request->only('name','email','phone','address','status'));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
    
    public function exportPdf(User $user)
    {
        $orders = $user->orders()->get();

        $pdf = \PDF::loadView('admin.users.pdf.orders', compact('orders', 'user'));
        return $pdf->download("user_{$user->id}_orders.pdf");
    }
}
