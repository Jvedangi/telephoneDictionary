
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Styles for SaaS Look -->
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-light: #eef2ff;
            --primary-dark: #4f46e5;
        }
        body {
            background-color: #f9fafb;
            font-family: "Inter", sans-serif;
        }
        .wrapper {
            display: flex;
            width: 100%;
        }
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            transition: all 0.3s;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        #sidebar.collapsed {
            margin-left: -260px;
        }
        #content {
            width: calc(100% - var(--sidebar-width));
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            top: 0;
            right: 0;
        }
        #content.full-width {
            width: 100%;
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .sidebar-header h3 {
            color: #111827;
            font-weight: 700;
        }
        .components {
            padding: 20px;
        }
        .components a {
            padding: 12px 15px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            color: #4b5563;
            display: block;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
        }
        .components a:hover, .components a.active {
            color: var(--primary-dark);
            background: var(--primary-light);
        }
        .components a i {
            margin-right: 15px;
            font-size: 1.2rem;
            vertical-align: middle;
        }
        .main-content {
            padding: 2rem;
        }
        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
        }
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        }
        .stat-card {
            background: linear-gradient(135deg, var(--bs-white), var(--bs-light));
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        .footer {
            background: #fff;
            padding: 1rem 2rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -260px;
            }
            #sidebar.collapsed {
                margin-left: 0;
            }
            #content {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="bi bi-journal-bookmark-fill me-2"></i> PhoneBook</h3>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Contacts
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact-groups.index') }}" class="{{ request()->routeIs('contact-groups.*') ? 'active' : '' }}">
                        <i class="bi bi-collection-fill"></i> Groups
                    </a>
                </li>
                <li>
                    <a href="{{ route('import-export.index') }}" class="{{ request()->routeIs('import-export.*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-down-up"></i> Import / Export
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light top-navbar">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell-fill fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">No new notifications</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="https://i.pravatar.cc/40?u={{ Auth::user()->id }}" alt="" width="32" height="32" class="rounded-circle me-2">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                                                Logout
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="main-content">
                {{ $slot }}
            </div>

            <footer class="footer mt-auto py-3">
                <div class="container-fluid text-center">
                    <span>© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            sidebarCollapse.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('full-width');
            });
        });
    </script>
</body>
</html>
