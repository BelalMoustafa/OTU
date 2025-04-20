<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OTU</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-bg: #1e1e2d;
            --secondary-bg: #151521;
            --card-bg: #1e1e2d;
            --accent-color: #00e1b4;
            --accent-hover: #0bc6a0;
            --text-primary: #ffffff;
            --text-secondary: #92929f;
            --border-color: rgba(255, 255, 255, 0.07);
            --shadow-color: rgba(0, 0, 0, 0.25);
            --card-pattern: radial-gradient(rgba(255, 255, 255, 0.03) 8%, transparent 8%);
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-primary);
            background-image: 
                radial-gradient(rgba(0, 225, 180, 0.02) 2px, transparent 2px),
                radial-gradient(rgba(0, 225, 180, 0.02) 2px, transparent 2px);
            background-size: 50px 50px;
            background-position: 0 0, 25px 25px;
            transition: all 0.3s ease;
            overflow-x: hidden;
            min-height: 100vh;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            background: var(--secondary-bg);
            padding: 1.5rem 1.2rem;
            transition: all 0.5s ease;
            box-shadow: -5px 0 15px var(--shadow-color);
            z-index: 1000;
            overflow-y: auto;
            background-size: 30px 30px;
            background-image: var(--card-pattern);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(100%);
                width: 260px;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0 !important;
            }
            
            .toggle-sidebar {
                display: flex !important;
            }
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            padding: 0.7rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
            font-size: 0.9rem;
            letter-spacing: 0.2px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 3px;
            height: 100%;
            background: var(--accent-color);
            transform: scaleY(0);
            transition: transform 0.3s, width 0.3s;
            transform-origin: bottom;
            z-index: -1;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            transform: scaleY(1);
            width: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: var(--text-primary);
            background: transparent;
            transform: translateX(-3px);
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-left: 12px;
            color: var(--accent-color);
            transition: all 0.3s;
            font-size: 1rem;
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            transform: scale(1.1);
        }

        /* Main Content */
        .main-content {
            margin-right: 260px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        /* Full width content for auth pages */
        .auth-content {
            margin-right: 0 !important;
            padding: 2.5rem;
        }

        /* Card Styles */
        .card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 18px;
            box-shadow: 0 5px 20px var(--shadow-color);
            margin-bottom: 1.8rem;
            color: var(--text-primary);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            background-size: 30px 30px;
            background-image: var(--card-pattern);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px var(--shadow-color);
        }

        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1.35rem 1.75rem;
            border-radius: 18px 18px 0 0 !important;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        }

        .card-body {
            padding: 1.75rem;
        }

        /* Button Styles */
        .btn {
            padding: 0.7rem 1.6rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
            z-index: -1;
        }

        .btn:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            font-size: 0.85rem;
        }

        .btn-lg {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }

        /* Table Styles */
        .table {
            border-radius: 12px;
            overflow: hidden;
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .table thead th {
            background-color: rgba(0, 225, 180, 0.05);
            color: var(--text-secondary);
            border-bottom: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 1.5rem;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 225, 180, 0.05);
            transform: translateY(-2px);
        }

        .table > :not(caption) > * > * {
            padding: 1.25rem 1.5rem;
            border-color: var(--border-color);
        }

        /* Badge Styles */
        .badge {
            padding: 0.65em 1.1em;
            border-radius: 8px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .badge.bg-primary {
            background-color: var(--accent-color) !important;
            color: #000;
        }

        /* Brand Styles */
        .navbar-brand {
            color: var(--text-primary) !important;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        }

        .navbar-brand i {
            font-size: 2rem;
            color: var(--accent-color);
            filter: drop-shadow(0 0 8px rgba(0, 225, 180, 0.5));
        }

        /* Auth pages brand */
        .auth-brand {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .auth-brand i {
            font-size: 3.5rem;
            color: var(--accent-color);
            filter: drop-shadow(0 0 10px rgba(0, 225, 180, 0.5));
            margin-bottom: 1rem;
        }

        .auth-brand h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-brand p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Progress Bar Styles */
        .progress {
            height: 10px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            overflow: hidden;
            margin: 0.8rem 0;
        }

        .progress-bar {
            background-color: var(--accent-color);
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent
            );
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Chart Styles */
        .activity-chart {
            height: 300px;
            margin-top: 1rem;
            filter: drop-shadow(0 5px 5px rgba(0, 0, 0, 0.2));
        }

        /* Utility Classes */
        .bg-primary {
            background-color: var(--accent-color) !important;
        }

        .text-primary {
            color: var(--accent-color) !important;
        }

        .bg-primary-soft {
            background-color: rgba(0, 225, 180, 0.1);
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        .fs-sm {
            font-size: 0.85rem;
        }

        .fs-lg {
            font-size: 1.15rem;
        }

        .fw-medium {
            font-weight: 500;
        }

        .rounded-xl {
            border-radius: 1rem !important;
        }

        .shadow-sm {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .shadow-lg {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        /* List Group Styles */
        .list-group-item {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            padding: 1.25rem 1.5rem;
        }

        .list-group-item:hover {
            background-color: rgba(0, 225, 180, 0.05);
            transform: translateX(-5px);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            background-color: var(--secondary-bg);
            border-color: var(--border-color);
            border-radius: 12px;
            box-shadow: 0 5px 15px var(--shadow-color);
            padding: 0.85rem 0;
            animation: fadeIn 0.3s;
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 0.85rem 1.75rem;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 225, 180, 0.1);
            color: var(--text-primary);
            transform: translateX(-5px);
        }

        /* Link Styles */
        .btn-link {
            color: var(--accent-color);
            text-decoration: none;
        }

        .btn-link:hover {
            color: var(--accent-hover);
        }

        a {
            color: var(--accent-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        a:hover {
            color: var(--accent-hover);
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0 0 1.5rem 0;
        }

        .breadcrumb-item {
            position: relative;
            padding-left: 0.85rem;
            font-size: 1rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--accent-color);
            content: ">";
            opacity: 0.5;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        /* Form Control Styles */
        .form-control, .form-select {
            background-color: var(--secondary-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 0.85rem 1.2rem;
            transition: all 0.3s;
            height: auto;
            font-size: 1rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--secondary-bg);
            border-color: var(--accent-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 225, 180, 0.25);
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.85rem;
            font-size: 1rem;
            letter-spacing: 0.2px;
        }
        
        .input-group-text {
            background-color: var(--secondary-bg);
            border-color: var(--border-color);
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 0.85rem 1.2rem;
        }
        
        .form-group {
            margin-bottom: 1.75rem;
        }
        
        /* Calendar Styles */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.65rem;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .calendar-day:hover {
            background-color: rgba(0, 225, 180, 0.1);
            transform: scale(1.1);
        }
        
        .calendar-day.active {
            background-color: var(--accent-color);
            color: #000;
            box-shadow: 0 5px 10px rgba(0, 225, 180, 0.4);
        }
        
        .calendar-day.highlight {
            background-color: rgba(0, 225, 180, 0.2);
        }

        /* Mobile Toggle */
        .toggle-sidebar {
            position: fixed;
            top: 15px;
            right: 15px;
            width: 50px;
            height: 50px;
            background: var(--accent-color);
            border-radius: 50%;
            display: none;
            justify-content: center;
            align-items: center;
            color: #000;
            font-size: 1.35rem;
            box-shadow: 0 3px 10px rgba(0, 225, 180, 0.5);
            z-index: 1010;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-sidebar:hover {
            transform: scale(1.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s;
        }

        /* Avatar Styles */
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .avatar-sm {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        .avatar-lg {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        .avatar-title {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Pagination Styles */
        .pagination {
            margin-bottom: 0;
            gap: 0.3rem;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            transition: all 0.3s;
            min-width: 40px;
            text-align: center;
        }

        .page-link:hover {
            background-color: rgba(0, 225, 180, 0.1);
            border-color: var(--border-color);
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #000;
            box-shadow: 0 3px 5px rgba(0, 225, 180, 0.4);
        }

        .page-item.disabled .page-link {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-secondary);
            opacity: 0.5;
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .alert-info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }

        /* Spacing Helpers */
        .section-gap {
            margin-bottom: 2.5rem;
        }

        .section-header {
            margin-bottom: 1.75rem;
        }

        /* Container Styles */
        .container-fluid {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Card Stats */
        .stats-card {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            width: 210px;
            height: 210px;
            background: var(--accent-color);
            border-radius: 50%;
            opacity: 0.1;
            top: -40px;
            right: -40px;
            z-index: -1;
        }

        .stats-card .icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background-color: rgba(0, 225, 180, 0.1);
            color: var(--accent-color);
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .main-content {
                padding: 1.75rem;
            }
            .auth-content {
                padding: 1.75rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .main-content,
            .auth-content {
                padding: 1.5rem;
            }
            
            .card {
                margin-bottom: 1.5rem;
                border-radius: 15px;
            }
            
            .card-header {
                padding: 1.25rem 1.5rem;
                border-radius: 15px 15px 0 0 !important;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .container-fluid {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
            
            .btn {
                padding: 0.65rem 1.35rem;
            }
            
            .breadcrumb {
                padding: 0 0 1.25rem 0;
            }
            
            .stats-card .icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
                margin-bottom: 1.25rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .main-content,
            .auth-content {
                padding: 1.25rem;
            }
            
            .card {
                margin-bottom: 1.25rem;
            }
            
            .card-header {
                padding: 1.15rem 1.35rem;
            }
            
            .card-body {
                padding: 1.35rem;
            }
            
            .table > :not(caption) > * > * {
                padding: 1rem 1.25rem;
            }
            
            .list-group-item {
                padding: 1.15rem 1.35rem;
            }
            
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .breadcrumb-item {
                font-size: 0.9rem;
            }
            
            .form-control, .form-select, .input-group-text {
                padding: 0.75rem 1rem;
            }
        }
    </style>
</head>
<body>
    @php
        $isAuthPage = request()->is('login') || request()->is('register') || request()->is('password/*') || request()->is('forgot-password');
    @endphp

    <!-- Toggle Sidebar Button for Mobile -->
    @if(!$isAuthPage)
    <div class="toggle-sidebar">
        <i class="fas fa-bars"></i>
    </div>
    @endif

    <!-- Sidebar -->
    @if(!$isAuthPage)
    <nav class="sidebar">
        <a class="navbar-brand mb-3" href="{{ url('/') }}">
            <i class="fas fa-graduation-cap"></i>
        </a>

        <ul class="nav flex-column">
            <li class="nav-item fade-in" style="animation-delay: 0.1s">
                <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    الرئيسية
                </a>
            </li>
            
            @if(auth()->check() && auth()->user()->hasRole('Admin'))
            <!-- Admin Links -->
            <li class="nav-item fade-in" style="animation-delay: 0.2s">
                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    المستخدمين
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.25s">
                <a class="nav-link {{ request()->is('groups*') ? 'active' : '' }}" href="{{ route('groups.index') }}">
                    <i class="fas fa-user-friends"></i>
                    المجموعات
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.3s">
                <a class="nav-link {{ request()->routeIs('admin.courses') || request()->is('admin/courses*') ? 'active' : '' }}" href="{{ route('admin.courses') }}">
                    <i class="fas fa-book"></i>
                    المقررات
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.35s">
                <a class="nav-link {{ request()->is('admin/schedules*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    الجداول
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.4s">
                <a class="nav-link {{ request()->is('admin/requests*') ? 'active' : '' }}" href="{{ route('admin.requests') }}">
                    <i class="fas fa-clipboard-list"></i>
                    الطلبات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.45s">
                <a class="nav-link {{ request()->is('admin/attendance*') ? 'active' : '' }}" href="{{ route('admin.attendance') }}">
                    <i class="fas fa-user-check"></i>
                    الحضور
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.5s">
                <a class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}" href="{{ route('admin.messages') }}">
                    <i class="fas fa-envelope"></i>
                    الرسائل
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.55s">
                <a class="nav-link {{ request()->is('admin/fees*') ? 'active' : '' }}" href="{{ route('admin.fees') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    الرسوم
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.6s">
                <a class="nav-link {{ request()->is('admin/grades*') ? 'active' : '' }}" href="{{ route('admin.grades.reports') }}">
                    <i class="fas fa-chart-bar"></i>
                    تقارير الدرجات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.65s">
                <a class="nav-link {{ request()->is('admin/exams/reports*') ? 'active' : '' }}" href="{{ route('admin.exams.reports') }}">
                    <i class="fas fa-file-alt"></i>
                    تقارير الاختبارات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.7s">
                <a class="nav-link {{ request()->is('admin/locations*') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                    <i class="fas fa-map-marker-alt"></i>
                    إعدادات المواقع
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.75s">
                <a class="nav-link {{ request()->routeIs('notifications*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                    <i class="fas fa-bell"></i>
                    الإشعارات
                </a>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->hasRole('Teacher'))
            <!-- Teacher Links -->
            <li class="nav-item fade-in" style="animation-delay: 0.2s">
                <a class="nav-link {{ request()->routeIs('courses.teacher') || request()->is('teacher/courses*') ? 'active' : '' }}" href="{{ route('courses.teacher') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    مقرراتي
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.25s">
                <a class="nav-link {{ request()->is('teacher/messages*') ? 'active' : '' }}" href="{{ route('teacher.messages') }}">
                    <i class="fas fa-envelope"></i>
                    الرسائل
                    @php
                        $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-auto">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.3s">
                <a class="nav-link {{ request()->is('teacher/grades*') ? 'active' : '' }}" href="{{ route('teacher.grades.index') }}">
                    <i class="fas fa-clipboard-check"></i>
                    إدارة الدرجات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.35s">
                <a class="nav-link {{ request()->is('teacher/exams') || request()->is('teacher/exams/create') || request()->is('teacher/exams/*/edit') ? 'active' : '' }}" href="{{ route('teacher.exams.index') }}">
                    <i class="fas fa-file-alt"></i>
                    إدارة الاختبارات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.4s">
                <a class="nav-link {{ request()->is('teacher/exams/grading*') ? 'active' : '' }}" href="{{ route('teacher.exams.grading') }}">
                    <i class="fas fa-pen"></i>
                    تصحيح الاختبارات
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.42s">
                <a class="nav-link {{ request()->is('teacher/location-attendance*') ? 'active' : '' }}" href="{{ route('teacher.location-attendance.index') }}">
                    <i class="fas fa-map-marker-alt"></i>
                    تسجيل الحضور المكاني
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.45s">
                <a class="nav-link {{ request()->routeIs('notifications*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                    <i class="fas fa-bell"></i>
                    الإشعارات
                </a>
            </li>
            @endif
            
            @if(auth()->check() && auth()->user()->hasRole('Student'))
            <!-- Student Links -->
            <li class="nav-item fade-in" style="animation-delay: 0.2s">
                <a class="nav-link {{ request()->routeIs('courses.student') || request()->is('student/courses*') ? 'active' : '' }}" href="{{ route('courses.student') }}">
                    <i class="fas fa-book-reader"></i>
                    المقررات
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.25s">
                <a class="nav-link {{ request()->routeIs('student.schedule') || request()->is('student/schedule*') ? 'active' : '' }}" href="{{ route('student.schedule') }}">
                    <i class="fas fa-calendar-alt"></i>
                    الجدول
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.3s">
                <a class="nav-link {{ request()->is('student/requests*') ? 'active' : '' }}" href="{{ route('student.requests') }}">
                    <i class="fas fa-file-alt"></i>
                    الطلبات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.35s">
                <a class="nav-link {{ request()->is('student/messages*') ? 'active' : '' }}" href="{{ route('student.messages') }}">
                    <i class="fas fa-inbox"></i>
                    الوارد
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.4s">
                <a class="nav-link {{ request()->is('student/fees*') ? 'active' : '' }}" href="{{ route('student.fees') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    الرسوم
                </a>
            </li>
            
            <li class="nav-item fade-in" style="animation-delay: 0.42s">
                <a class="nav-link {{ request()->is('student/location-attendance*') ? 'active' : '' }}" href="{{ route('student.location-attendance.index') }}">
                    <i class="fas fa-map-marker-alt"></i>
                    تسجيل الحضور المكاني
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.45s">
                <a class="nav-link {{ request()->routeIs('notifications*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                    <i class="fas fa-bell"></i>
                    الإشعارات
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.5s">
                <a class="nav-link {{ request()->is('student/grades*') ? 'active' : '' }}" href="{{ route('student.grades.index') }}">
                    <i class="fas fa-graduation-cap"></i>
                    درجاتي
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.55s">
                <a class="nav-link {{ request()->is('student/exams') || request()->is('student/exams/*/take') ? 'active' : '' }}" href="{{ route('student.exams.index') }}">
                    <i class="fas fa-file-alt"></i>
                    الاختبارات الإلكترونية
                </a>
            </li>

            <li class="nav-item fade-in" style="animation-delay: 0.6s">
                <a class="nav-link {{ request()->is('student/exams/results*') ? 'active' : '' }}" href="{{ route('student.exams.results') }}">
                    <i class="fas fa-poll"></i>
                    نتائج الاختبارات
                </a>
            </li>
            @endif
            
            <li class="nav-item mt-auto fade-in" style="animation-delay: 0.7s">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-end">
                        <i class="fas fa-sign-out-alt"></i>
                        خروج
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    @endif

    <!-- Main Content -->
    <main class="{{ $isAuthPage ? 'auth-content' : 'main-content' }} fade-in">
        @if($isAuthPage)
        <div class="auth-brand">
            <i class="fas fa-graduation-cap"></i>
            <h1>OTU</h1>
            <p>نظام إدارة الجامعة</p>
        </div>
        @endif
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle Sidebar for Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-sidebar');
            const sidebar = document.querySelector('.sidebar');
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                
                // Close sidebar when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && e.target !== toggleBtn && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
            
            // Add animation classes to cards
            document.querySelectorAll('.card').forEach(function(card, index) {
                card.classList.add('fade-in');
                card.style.animationDelay = (0.1 * (index + 1)) + 's';
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
