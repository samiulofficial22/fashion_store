<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .sidebar h4 {
            font-size: 1.4rem;
        }
        .sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .sidebar a i {
            font-size: 1.2rem;
            margin-right: 12px;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #495057;
            border-radius: 0.375rem;
        }
        .sidebar .mt-auto {
            margin-top: auto;
            padding: 20px;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Responsive: Mobile */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                width: 250px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.show {
                display: block;
            }
            .menu-toggle {
                display: inline-block;
            }
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
      <!-- Stack for CSS -->
    @stack('style')
</head>
<body>
    {{-- Mobile overlay --}}
    <div class="sidebar-overlay"></div>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h4 class="text-center py-3 border-bottom">Admin Panel</h4>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i><span class="link-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i><span class="link-text">Categories</span> 
        </a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i><span class="link-text">Products</span>
        </a> 
        <a href="#"><i class="bi bi-bag"></i> Orders</a>
        <a href="#"><i class="bi bi-people"></i> Users</a>
        <a href="#"><i class="bi bi-gear"></i> Settings</a>
        <a href="{{ route('admin.taxrate.index') }}" class="{{ request()->routeIs('admin.taxrate.*') ? 'active' : '' }}">
            <i class="bi bi-percent"></i><span class="link-text">Tax Rate Setting</span>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-auto">
            @csrf
            <button class="btn btn-danger w-100">Logout <i class="bi bi-box-arrow-right ms-2"></i></button>
        </form>
    </div>

    {{-- Main Content --}}
    <div class="content">
        {{-- Mobile menu toggle --}} 
        <span class="menu-toggle mb-3 d-inline-block d-lg-none">
            <i class="bi bi-list fs-2"></i>
        </span>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const toggle = document.querySelector('.menu-toggle');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>
    @stack('script')
</body>
</html>
