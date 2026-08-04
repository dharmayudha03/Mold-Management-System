<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mold Management System') }} — {{ $header ?? 'Dashboard' }}</title>

    <!-- FontAwesome Free Local Asset & SVG Engine -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" />
    <script src="{{ asset('vendor/fontawesome-free/js/all.min.js') }}"></script>

    <!-- Custom styles for SB Admin 2 (Local downloaded asset) -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- TomSelect Searchable Dropdown CSS (Local Asset) -->
    <link href="{{ asset('vendor/tom-select/tom-select.css') }}" rel="stylesheet">

    <!-- Local Compiled CSS & JS (Vite Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ------------------------------------------------------------- */
        /* ULTRA-PREMIUM ENTERPRISE DESIGN SYSTEM (IRC INOAC SYSTEM)     */
        /* ------------------------------------------------------------- */
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            background-color: #f4f6f9 !important;
            color: #334155 !important;
        }

        /* TomSelect Dropdown Indicator Arrow */
        .ts-wrapper.single .ts-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 14px 10px !important;
            padding-right: 2.25rem !important;
            border-radius: 0.5rem !important;
        }

        /* TomSelect Dropdown Input Search Box */
        .ts-dropdown .dropdown-input-wrap {
            padding: 6px 8px !important;
            background-color: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            display: block !important;
        }
        .ts-dropdown .dropdown-input {
            width: 100% !important;
            padding: 8px 12px !important;
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
            color: #0f172a !important;
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.375rem !important;
            outline: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }
        .ts-dropdown .dropdown-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
            color: #0f172a !important;
            background-color: #ffffff !important;
        }

        /* Ensure all Bootstrap dropdown menus match user reference style */
        .table tbody tr {
            position: relative;
        }
        .table tbody tr:hover,
        .table tbody tr:focus-within,
        .table tbody tr:has(.show),
        .table tbody tr:has(.dropdown-menu.show) {
            z-index: 999 !important;
        }
        .dropdown.show,
        .dropdown:focus-within {
            z-index: 1000 !important;
            position: relative !important;
        }
        .dropdown-menu {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.06) !important;
            padding: 0.5rem !important;
            z-index: 1050 !important;
        }
        .dropdown-item {
            color: #1e293b !important;
            font-weight: 700 !important;
            border-radius: 0.625rem !important;
            padding: 0.5rem 0.875rem !important;
            display: flex !important;
            align-items: center !important;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: #f8fafc !important;
        }
        .dropdown-item.text-danger:hover, .dropdown-item.text-danger:focus {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
        }
        .dropdown-divider {
            border-top: 1px solid #f1f5f9 !important;
            margin: 0.375rem 0 !important;
        }

        /* Prevent table responsive dropdown vertical scrollbars */
        .card-body {
            overflow: visible !important;
        }
        .table-responsive {
            overflow-x: auto !important;
            overflow-y: visible !important;
        }
        .table-responsive .dropdown-menu {
            z-index: 1050 !important;
        }

        /* Clean TomSelect Single-Select Styles (Remove inner input box artifact) */
        .ts-wrapper.single .ts-control input,
        .ts-control input {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .ts-wrapper.single.has-items .ts-control > input {
            display: none !important;
        }
        .ts-wrapper .ts-control {
            border-radius: 0.5rem !important;
            min-height: 42px !important;
            display: flex !important;
            align-items: center !important;
            border-color: #cbd5e1 !important;
            background-color: #ffffff !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }
        .ts-dropdown {
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden !important;
            margin-top: 4px !important;
        }

        /* Global Ultra-Slim Sleek Scrollbars (Vertical & Horizontal) */
        ::-webkit-scrollbar {
            width: 5px !important;
            height: 5px !important;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc !important;
            border-radius: 9999px !important;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 9999px !important;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8 !important;
        }

        /* Sidebar Styling (Sticky & Deep Navy Dark Charcoal) */
        #accordionSidebar {
            background-color: #0f172a !important;
            background-image: none !important;
            border-right: 1px solid #1e293b !important;
            width: 15.5rem !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            overflow-y: auto !important;
            z-index: 1030 !important;
        }

        .sidebar-dark .nav-item .nav-link {
            color: #94a3b8 !important;
            font-weight: 700 !important;
            font-size: 0.85rem !important;
            padding: 0.75rem 1.15rem !important;
            margin: 0.15rem 0.75rem !important;
            border-radius: 0.75rem !important;
            transition: background-color 0.15s ease, color 0.15s ease !important;
            display: flex !important;
            align-items: center !important;
        }

        .sidebar-dark .nav-item .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
        }

        .sidebar-dark .nav-item.active .nav-link {
            color: #ffffff !important;
            font-weight: 800 !important;
            background: #2563eb !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;
        }

        .sidebar-heading {
            color: #64748b !important;
            font-size: 0.65rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.1em !important;
            text-transform: uppercase !important;
            padding: 0 1.25rem !important;
            margin-top: 1rem !important;
            margin-bottom: 0.4rem !important;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
            margin: 0.5rem 1rem !important;
        }

        /* Topbar 100% Fixed Header */
        #content-wrapper {
            margin-left: 15.5rem !important;
            padding-top: 4.5rem !important;
        }

        .topbar {
            height: 4.5rem;
            background-color: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03) !important;
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            left: 15.5rem !important;
            width: calc(100% - 15.5rem) !important;
            z-index: 1020 !important;
        }

        /* Sidebar Toggle Collapsed State */
        body.sidebar-collapsed #accordionSidebar {
            width: 0 !important;
            overflow: hidden !important;
            padding: 0 !important;
        }
        body.sidebar-collapsed #content-wrapper {
            margin-left: 0 !important;
        }
        body.sidebar-collapsed .topbar {
            left: 0 !important;
            width: 100% !important;
        }
        #accordionSidebar {
            transition: width 0.25s ease !important;
        }
        #content-wrapper {
            transition: margin-left 0.25s ease !important;
        }
        .topbar {
            transition: left 0.25s ease, width 0.25s ease !important;
        }

        /* Mobile overlay backdrop */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.45);
            z-index: 1025;
            backdrop-filter: blur(2px);
        }
        body.sidebar-mobile-open #sidebar-overlay {
            display: block;
        }

        /* Mobile: sidebar slides in from left */
        @media (max-width: 768px) {
            #accordionSidebar {
                position: fixed !important;
                left: -16rem !important;
                height: 100vh !important;
                width: 15.5rem !important;
                transition: left 0.25s ease !important;
                z-index: 1030 !important;
            }
            body.sidebar-mobile-open #accordionSidebar {
                left: 0 !important;
            }
            #content-wrapper {
                margin-left: 0 !important;
                padding-top: 4.5rem !important;
            }
            .topbar {
                left: 0 !important;
                width: 100% !important;
            }
            /* Reset collapsed state on mobile */
            body.sidebar-collapsed #accordionSidebar {
                width: 15.5rem !important;
                left: -16rem !important;
            }
            body.sidebar-collapsed.sidebar-mobile-open #accordionSidebar {
                left: 0 !important;
            }
            body.sidebar-collapsed #content-wrapper {
                margin-left: 0 !important;
            }
            body.sidebar-collapsed .topbar {
                left: 0 !important;
                width: 100% !important;
            }
        }

        /* High Contrast Typography */
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            color: #0f172a !important;
            font-weight: 800 !important;
        }

        /* Override legacy dark theme slate classes */
        .bg-slate-950, 
        .bg-slate-900, 
        .bg-slate-900\/60, 
        .bg-slate-900\/40, 
        .bg-slate-900\/50,
        .bg-slate-950\/80 {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        .border-slate-800, 
        .border-slate-800\/80, 
        .border-slate-800\/60, 
        .border-slate-700 {
            border-color: #e2e8f0 !important;
        }

        .divide-slate-800 > :not([hidden]) ~ :not([hidden]),
        .divide-slate-800\/60 > :not([hidden]) ~ :not([hidden]) {
            border-color: #f1f5f9 !important;
        }

        .text-slate-100, .text-slate-200 {
            color: #0f172a !important;
        }

        .text-slate-300, .text-slate-400 {
            color: #475569 !important;
        }

        .text-slate-500 {
            color: #64748b !important;
        }

        /* Cards & Containers */
        .card, .main-card-container {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1rem !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
        }

        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            padding: 1rem 1.25rem !important;
        }

        /* Standardized Grid Layout for Forms */
        .form-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 1.25rem !important;
            margin-bottom: 1.25rem !important;
        }

        .form-grid-3 {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 1.25rem !important;
            margin-bottom: 1.25rem !important;
        }

        .form-grid-2 {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 1.25rem !important;
            margin-bottom: 1.25rem !important;
        }

        .form-grid-1 {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 1.25rem !important;
            margin-bottom: 1.25rem !important;
        }

        @media (max-width: 992px) {
            .form-grid-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 768px) {
            .form-grid-4, .form-grid-3, .form-grid-2 {
                grid-template-columns: 1fr !important;
            }
        }

        /* Universal Form Control & Label Fix */
        .form-group-item {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }

        .form-group-item label, .form-group-item .form-label {
            display: block !important;
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            margin-bottom: 0.45rem !important;
            width: 100% !important;
        }

        .form-group-item .form-control,
        .form-group-item .form-select,
        .form-group-item .ts-wrapper {
            width: 100% !important;
        }

        /* Standardized Native Form Control Styling */
        .form-control,
        .form-select {
            height: 44px !important;
            min-height: 44px !important;
            max-height: 44px !important;
            background-color: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            padding: 0.45rem 0.85rem !important;
            box-sizing: border-box !important;
            line-height: 1.5 !important;
            box-shadow: none !important;
        }

        input:focus, select:focus, textarea:focus, .ts-wrapper.focus .ts-control {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
            outline: none !important;
        }

        /* TomSelect Wrapper Reset (Prevent Double Outer Box & Double Arrows) */
        .ts-wrapper,
        .ts-wrapper.form-select,
        .ts-wrapper.form-control {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            background-image: none !important;
            box-shadow: none !important;
            height: auto !important;
            min-height: 42px !important;
            width: 100% !important;
        }

        /* TomSelect Single Box Control */
        .ts-wrapper .ts-control {
            height: 42px !important;
            min-height: 42px !important;
            max-height: 42px !important;
            background-color: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            padding: 0.45rem 0.85rem !important;
            box-sizing: border-box !important;
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            box-shadow: none !important;
        }

        .ts-wrapper .ts-control input {
            color: #0f172a !important;
            font-weight: 600 !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Hide inner input box completely when an item is selected */
        .ts-wrapper.single.has-items:not(.focus) .ts-control input {
            opacity: 0 !important;
            width: 0 !important;
            position: absolute !important;
            pointer-events: none !important;
        }

        .ts-wrapper .ts-control .item {
            color: #0f172a !important;
            font-weight: 700 !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        .ts-wrapper .ts-control .placeholder {
            color: #94a3b8 !important;
            font-weight: 600 !important;
        }

        .ts-wrapper .ts-dropdown {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
            padding: 0.35rem 0 !important;
            z-index: 1060 !important;
        }

        .ts-wrapper .ts-dropdown .option {
            color: #334155 !important;
            padding: 0.55rem 0.85rem !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            background-color: #ffffff !important;
        }

        .ts-wrapper .ts-dropdown .option.active, 
        .ts-wrapper .ts-dropdown .option:hover {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            font-weight: 700 !important;
        }

        .btn-pill-action {
            border-radius: 0.75rem !important;
            font-weight: 700 !important;
            padding: 0.55rem 1.15rem !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
            transition: all 0.15s ease-in-out !important;
        }

        /* Table Styling */
        table {
            color: #334155 !important;
            margin-bottom: 0 !important;
        }

        thead tr, thead th {
            background-color: #f8fafc !important;
            color: #1e293b !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 0.75rem 0.85rem !important;
            white-space: nowrap !important;
        }

        tbody td {
            padding: 0.75rem 0.85rem !important;
            vertical-align: middle !important;
            white-space: nowrap !important;
        }

        tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* 3-Dots Dropdown Menu Fixes */
        .table-responsive {
            position: relative !important;
            overflow-x: auto !important;
        }

        .dropdown-menu.show {
            display: block !important;
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
            z-index: 1060 !important;
            min-width: 140px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
            background-color: #ffffff !important;
            padding: 0.4rem 0 !important;
        }

        .dropdown-item {
            font-size: 0.825rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 700 !important;
            color: #334155 !important;
            display: flex !important;
            align-items: center !important;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        .dropdown-item.text-danger:hover {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Top Loading Progress Bar (Instant 0ms click feedback) -->
    <div id="top-loading-bar" style="position: fixed; top: 0; left: 0; height: 3px; width: 0%; background: #2563eb; z-index: 99999; transition: width 0.2s ease; display: none;"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.navigation')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column bg-light min-vh-100 w-100">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Fixed Navigation Header -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">

                    <!-- Sidebar Toggle Button (Desktop: collapse sidebar, Mobile: open sidebar) -->
                    <button id="sidebarToggleBtn" class="btn btn-link rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;color:#64748b;" title="Toggle Sidebar">
                        <i class="fas fa-bars" style="font-size:1.1rem;"></i>
                    </button>

                    <!-- Page Title Header in Topbar -->
                    <div class="d-flex align-items-center gap-2">
                        @isset($header)
                            <h1 class="h4 mb-0 text-gray-800 font-weight-extrabold tracking-tight">{{ $header }}</h1>
                        @else
                            <h1 class="h4 mb-0 text-gray-800 font-weight-extrabold tracking-tight">Dashboard Overview</h1>
                        @endisset
                    </div>

                    <!-- Topbar Navbar Right -->
                    <ul class="navbar-nav ml-auto align-items-center">

                        <!-- Company Name Badge (Pill Badge) -->
                        <li class="nav-item d-none d-md-block mr-2">
                            <span class="badge bg-white text-gray-900 border px-3.5 py-2 font-weight-extrabold shadow-xs d-inline-flex align-items-center gap-2" style="border-radius: 50rem; font-size: 0.75rem; letter-spacing: 0.05em; border-color: #e2e8f0 !important;">
                                <i class="fas fa-building text-danger"></i> PT. IRC INOAC INDONESIA
                            </span>
                        </li>

                        @if(request()->routeIs('dashboard'))
                        <!-- Live Auto-Refresh Badge -->
                        <li class="nav-item d-none d-md-block mr-3">
                            <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 px-3.5 py-2 font-weight-bold shadow-xs d-inline-flex align-items-center gap-1.5" style="border-radius: 50rem; background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0 !important; font-size: 0.75rem; letter-spacing: 0.05em;">
                                <span class="spinner-grow spinner-grow-sm text-emerald-500" role="status" style="width: 7px; height: 7px; color: #10b981;"></span> Live (3s)
                            </span>
                        </li>
                        @endif

                        <!-- Notifications Bell -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell text-gray-500 text-lg"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- User Profile Card -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2.5" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="img-profile rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-weight-extrabold shadow-sm" style="width: 38px; height: 38px; font-size: 15px;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="d-none d-lg-block text-left">
                                    <div class="text-xs font-weight-extrabold text-gray-800 leading-tight">
                                        {{ Auth::user()->name ?? 'User Administrator' }}
                                    </div>
                                    <div class="text-[10px] text-success font-weight-bold leading-tight mt-0.5">
                                        <i class="fas fa-circle text-[7px] mr-1"></i> {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}
                                    </div>
                                </div>
                            </a>
                            <!-- User Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in border-0 mt-2 p-2" aria-labelledby="userDropdown" style="border-radius: 0.75rem;">
                                <div class="dropdown-header text-gray-500 font-weight-bold">
                                    {{ Auth::user()->email ?? '' }}
                                </div>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger font-weight-bold rounded-lg">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid px-4 py-3">

                    <!-- Flash Success Notification -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 rounded-xl" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Flash Error Notification -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 border-0 rounded-xl" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 border-0 rounded-xl">
                            <strong>Harap perbaiki kesalahan berikut:</strong>
                            <ul class="mb-0 mt-1 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Main View Content -->
                    {{ $slot }}

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white border-top text-gray-500 py-3 mt-auto shadow-sm">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto font-weight-bold text-xs text-gray-500">
                        <span>PT. IRC INOAC INDONESIA &copy; Mold Management System {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded-circle bg-primary text-white shadow-lg" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay"></div>

    <!-- Local Downloaded SB Admin 2 Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    
    <!-- TomSelect Searchable Dropdown JS (Local Asset) -->
    <script src="{{ asset('vendor/tom-select/tom-select.complete.min.js') }}"></script>

    <script>
        // Sidebar Toggle Logic
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebarOverlay   = document.getElementById('sidebar-overlay');
        const isMobile = () => window.innerWidth <= 768;

        // Restore sidebar state from localStorage (desktop only)
        if (!isMobile() && localStorage.getItem('sidebar_collapsed') === '1') {
            document.body.classList.add('sidebar-collapsed');
        }

        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function () {
                if (isMobile()) {
                    // Mobile: slide in/out
                    document.body.classList.toggle('sidebar-mobile-open');
                } else {
                    // Desktop: collapse/expand
                    document.body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar_collapsed',
                        document.body.classList.contains('sidebar-collapsed') ? '1' : '0'
                    );
                }
            });
        }

        // Close sidebar on overlay click (mobile)
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function () {
                document.body.classList.remove('sidebar-mobile-open');
            });
        }

        // Close sidebar when navigating on mobile
        window.addEventListener('resize', function () {
            if (!isMobile()) {
                document.body.classList.remove('sidebar-mobile-open');
            }
        });

        // Fast restore of sidebar scroll position
        const sidebar = document.getElementById('accordionSidebar');
        if (sidebar) {
            const savedScroll = localStorage.getItem('sidebar_scroll_pos');
            if (savedScroll !== null) {
                sidebar.scrollTop = parseInt(savedScroll, 10);
            }
            sidebar.addEventListener('scroll', function() {
                localStorage.setItem('sidebar_scroll_pos', sidebar.scrollTop);
            }, { passive: true });
        }

        // Instant top loading bar on link clicks
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && link.href.startsWith(window.location.origin) && !link.target && !link.href.includes('#')) {
                const bar = document.getElementById('top-loading-bar');
                if (bar) {
                    bar.style.display = 'block';
                    bar.style.width = '40%';
                    setTimeout(() => { bar.style.width = '80%'; }, 80);
                }
            }
        });

        // Universal Teleporting Fixed Dropdown Menu (100% Bulletproof Stacking & Positioning)
        function closeAllDropdowns() {
            document.querySelectorAll('.dropdown-menu.show').forEach(m => {
                m.classList.remove('show');
                if (m._origParent && m.parentElement !== m._origParent) {
                    m._origParent.appendChild(m);
                }
                m.removeAttribute('style');
            });
            document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
        }

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-bs-toggle="dropdown"], [data-toggle="dropdown"]');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                const parent = btn.closest('.dropdown');
                if (!parent) return;
                let menu = parent.querySelector('.dropdown-menu');
                if (!menu && parent._activeMenu) menu = parent._activeMenu;
                if (!menu) return;

                const isOpen = menu.classList.contains('show');

                closeAllDropdowns();

                if (!isOpen) {
                    const bRect = btn.getBoundingClientRect();

                    menu._origParent = parent;
                    parent._activeMenu = menu;
                    document.body.appendChild(menu);

                    menu.classList.add('show');
                    parent.classList.add('show');

                    requestAnimationFrame(() => {
                        const mH = menu.offsetHeight || 120;
                        const mW = menu.offsetWidth || 180;
                        let top  = bRect.bottom + 6;
                        let left = bRect.right - mW;

                        if (top + mH > window.innerHeight - 8) {
                            top = bRect.top - mH - 6;
                        }
                        if (left < 8) left = 8;

                        menu.style.cssText = `position:fixed!important;top:${top}px!important;left:${left}px!important;z-index:9999999!important;transform:none!important;background:#ffffff!important;background-color:#ffffff!important;border:1px solid #e2e8f0!important;border-radius:1rem!important;box-shadow:0 10px 25px -5px rgba(0,0,0,0.18),0 8px 10px -6px rgba(0,0,0,0.1)!important;padding:0.5rem!important;opacity:1!important;visibility:visible!important;min-width:170px!important;`;
                    });
                }
            } else {
                if (!e.target.closest('.dropdown-menu')) {
                    closeAllDropdowns();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Live Clock Updater
            function updateClock() {
                const now = new Date();
                const hours   = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const clockEl = document.getElementById('live-clock');
                if (clockEl) {
                    clockEl.textContent = `${hours}:${minutes}:${seconds}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Init Bootstrap Tooltips globally
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    new bootstrap.Tooltip(el, { trigger: 'hover' });
                });
            }
        });
    </script>
</body>
</html>

