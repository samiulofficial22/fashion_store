<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
   <div class="sidebar d-flex flex-column">
		<h4 class="text-center py-3 border-bottom">Admin Panel</h4>
		<a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
		<a href="#"><i class="bi bi-box"></i> Products</a>
		<a href="#"><i class="bi bi-bag"></i> Orders</a>
		<a href="#"><i class="bi bi-people"></i> Users</a>
		<form method="POST" action="{{ route('admin.logout') }}" class="mt-auto">
			@csrf
			<button class="btn btn-danger w-100 mt-3">Logout</button>
		</form>
	</div>

    {{-- Main Content --}}
    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
