<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCTC Eduforest - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; font-family: 'Montserrat', sans-serif; }

        body { background-color: #eef8f1; margin: 0; padding: 0; color: #334155; height: 100vh; overflow: hidden; }

        .dashboard-container { display: flex; height: 100vh; width: 100vw; }


.left-column {
    width: 245px !important;
    min-width: 245px !important;
    max-width: 245px !important;
    height: 100vh !important;
    background:
        radial-gradient(circle at 28% 8%, rgba(255,255,255,0.9), transparent 34%),
        linear-gradient(180deg, #d8f3e4 0%, #c9eed9 48%, #eefaf3 100%) !important;
    border-right: 0 !important;
    box-shadow: 18px 0 45px rgba(45, 106, 79, 0.12) !important;
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden !important;
}

.logo-area {
    width: 100% !important;
    min-height: 210px !important;
    padding: 2rem 0.8rem 1.2rem !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    background: transparent !important;
    border: 0 !important;
    box-shadow: none !important;
}

.logo-area img {
    display: block !important;
    width: 165px !important;
    max-width: 165px !important;
    height: auto !important;
    object-fit: contain !important;
    margin: 0 auto !important;
    filter: drop-shadow(0 12px 18px rgba(15, 23, 42, 0.12)) !important;
}

.sidebar-premium {
    flex: 1 !important;
    background: transparent !important;
    border: 0 !important;
    box-shadow: none !important;
    padding: 0.8rem 0.9rem 1.3rem !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
}

.nav-container {
    display: flex !important;
    flex-direction: column !important;
    gap: 0.72rem !important;
    width: 100% !important;
    border: 0 !important;
}

.nav-item {
    width: 100% !important;
    min-height: 52px !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.78rem !important;
    padding: 0 0.9rem !important;
    border-radius: 18px !important;
    border: 1px solid rgba(255, 255, 255, 0.52) !important;
    background: rgba(255, 255, 255, 0.43) !important;
    color: #173b2b !important;
    text-decoration: none !important;
    font-size: 0.82rem !important;
    font-weight: 900 !important;
    letter-spacing: 0 !important;
    box-shadow: 0 10px 24px rgba(45, 106, 79, 0.075) !important;
    transition: all 0.22s ease !important;
}

.nav-item i {
    width: 20px !important;
    min-width: 20px !important;
    text-align: center !important;
    color: #2f855a !important;
    font-size: 0.95rem !important;
}

.nav-item span {
    display: inline-block !important;
    white-space: normal !important;
    line-height: 1.15 !important;
}

.nav-item:hover {
    transform: translateY(-1px) !important;
    background: rgba(255, 255, 255, 0.78) !important;
    box-shadow: 0 14px 30px rgba(45, 106, 79, 0.14) !important;
}

.nav-item.active {
    background: linear-gradient(135deg, #2f855a 0%, #246b47 100%) !important;
    color: #ffffff !important;
    border-color: rgba(255, 255, 255, 0.42) !important;
    box-shadow: 0 18px 36px rgba(47, 133, 90, 0.34) !important;
}

.nav-item.active i {
    color: #ffffff !important;
}

.logout-container {
    margin-top: 1rem !important;
    padding-top: 1rem !important;
    border-top: 0 !important;
}

.logout-container form {
    margin: 0 !important;
}

.logout-btn {
    width: 100% !important;
    min-height: 52px !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.78rem !important;
    padding: 0 0.9rem !important;
    border-radius: 18px !important;
    border: 1px solid rgba(254, 202, 202, 0.85) !important;
    background: rgba(255, 255, 255, 0.82) !important;
    color: #991b1b !important;
    font-size: 0.84rem !important;
    font-weight: 900 !important;
    cursor: pointer !important;
    box-shadow: 0 16px 34px rgba(185, 28, 28, 0.14) !important;
    transition: all 0.22s ease !important;
}

.logout-btn i {
    color: #b91c1c !important;
    width: 20px !important;
    text-align: center !important;
}

.logout-btn:hover {
    transform: translateY(-1px) !important;
    background: #fff5f5 !important;
    box-shadow: 0 20px 40px rgba(185, 28, 28, 0.22) !important;
}

.left-column a,
.left-column a:visited,
.left-column a:hover {
    text-decoration: none !important;
}
        .right-column { flex: 1; display: flex; flex-direction: column; height: 100%; overflow: hidden; }

        .header-premium {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            background-color: #ffffff;
        }
        .header-title { font-size: 1.35rem; font-weight: 700; color: #1e293b; margin: 0; }
        .header-user { font-weight: 700; color: #046307; }
        .header-date { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }

        .content-workspace {
            flex: 1;
            background-color: #f8fafc;
            overflow-y: auto;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            border-left: 1px solid #e2e8f0;
            border-top: 1px solid #e2e8f0;
            scroll-behavior: smooth;
        }

        .card-premium { background: #ffffff; border-radius: 1.5rem; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(148, 163, 184, 0.05); padding: 2rem; scroll-margin-top: 2rem; }
        .card-title { font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 0.5rem; }
        .card-subtitle { color: #64748b; font-size: 0.85rem; margin-top: 0; margin-bottom: 1.5rem; }

        .grid-premium { display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; }
        .sub-card-form { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1.25rem; padding: 1.5rem; }
        .sub-card-title { font-size: 0.95rem; font-weight: 600; color: #334155; margin-top: 0; margin-bottom: 1.25rem; }

        .table-responsive { overflow-x: auto; border-radius: 1rem; border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; text-align: left; background: #fff; font-size: 0.9rem; }
        th { background: #f8fafc; color: #475569; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.25rem; }
        td { padding: 1.25rem; border-bottom: 1px solid #f1f5f9; color: #475569; vertical-align: middle; }

        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.375rem; text-transform: uppercase; }
        input[type="date"], input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.75rem; font-size: 0.875rem; color: #1e293b; background: #fff; }

        .btn-flex-group { display: flex; gap: 0.75rem; margin-top: 1.25rem; flex-wrap: wrap; }
        .btn-premium { border: none; padding: 0.75rem 1.25rem; font-size: 0.85rem; font-weight: 600; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-premium-emerald { background-color: #046307; color: white; box-shadow: 0 4px 12px rgba(4, 99, 7, 0.2); }
        .btn-premium-red { background-color: #ef4444; color: white; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2); }
        .btn-premium-outline { background-color: #fff; color: #046307; border: 1px solid #bbf7d0; }

        .btn-action-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 0.5rem 1rem; font-size: 0.75rem; font-weight: 600; border-radius: 0.5rem; cursor: pointer; }
        .btn-action-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; padding: 0.5rem 1rem; font-size: 0.75rem; font-weight: 600; border-radius: 0.5rem; cursor: pointer; }
        .btn-inline-delete { background: none; border: none; color: #ef4444; font-size: 0.8rem; font-weight: 600; cursor: pointer; padding: 0.25rem 0.5rem; border-radius: 0.375rem; }

        .badge-category { background: #f0fdf4; color: #166534; font-weight: 700; font-size: 0.75rem; padding: 0.25rem 0.625rem; border-radius: 2rem; border: 1px solid #bbf7d0; display: inline-block; }
        .condition-item { display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 1.25rem; border-radius: 1rem; margin-bottom: 0.75rem; font-size: 0.85rem; font-weight: 500; border: 1px solid transparent; }
        .condition-item.booked { background-color: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .condition-item.holiday { background-color: #fff5f5; border-color: #fed7d7; color: #9b1c1c; }
        .ux-notice-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.25rem; margin-top: 1rem; font-size: 0.8rem; line-height: 1.6; color: #475569; display: flex; flex-direction: column; gap: 0.25rem; }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        .stat-card { background: #ffffff; border-radius: 1.5rem; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 4px 20px rgba(148,163,184,0.05); padding: 1.75rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .stat-icon { width: 2.75rem; height: 2.75rem; border-radius: 0.9rem; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: #0f172a; }
        .stat-label { font-size: 0.8rem; color: #64748b; font-weight: 500; }

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .grid-premium { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="dashboard-container">

        <div class="left-column">
            <div class="logo-area">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_outline.png"
                    alt="Edu-Forest Logo"
                    style="height: 180px; width: auto; object-fit: contain;">
            </div>

            <div class="sidebar-premium">
                <nav class="nav-container">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.slots.index') }}" class="nav-item {{ request()->routeIs('admin.slots.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i> <span>Calendar Availability</span>
                    </a>
                    <a href="{{ route('admin.clients') }}" class="nav-item {{ request()->routeIs('admin.clients') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> <span>Registered Clients</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice"></i> <span>Booking Request</span>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-receipt"></i> <span>Payment Verification</span>
                    </a>
                    <a href="{{ route('admin.account-setting') }}" class="nav-item {{ request()->routeIs('admin.account-setting') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i> <span>Account Setting</span>
                    </a>
                </nav>

                <div class="logout-container">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="right-column">
            <header class="header-premium">
                <h1 class="header-title">
                    @yield('page-title', 'Welcome Back, Admin')@if(!View::hasSection('page-title')), <span class="header-user">{{ Auth::user()->full_name ?? session('admin_name', 'Admin') }}</span>@endif
                </h1>
                <span class="header-date">{{ now()->format('l, d F Y') }}</span>
            </header>

            <div class="content-workspace" id="workspace">
                @if(session('success'))
                    <div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:1rem 1.5rem; border-radius:1rem; font-weight:600; font-size:0.875rem;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:1rem 1.5rem; border-radius:1rem; font-weight:600; font-size:0.875rem;">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('scripts')
</body>
</html>