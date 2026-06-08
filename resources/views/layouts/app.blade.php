<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BiblioTech Cloud')</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* ── BiblioTech Cloud · Design System (Light Mode Redesign) ──────────────────────────── */

        body:not(.dark-theme) {
            background-color: #f8fafc !important;
            color: #1e293b !important;
        }

        /* Unified card surface — solid white, no blur, clean borders */
        body:not(.dark-theme) .glass-card {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.07) !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
            color: #1e293b !important;
        }

        /* Slightly elevated variant (modals, dropdowns) */
        body:not(.dark-theme) .card-elevated {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.09) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.04) !important;
            color: #1e293b !important;
        }

        /* ── FAQ Accordion ────────────────────────────────────────────── */
        .faq-item summary { list-style: none; user-select: none; cursor: pointer; }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-chevron { transition: transform 0.25s ease; flex-shrink: 0; }
        .faq-item[open] .faq-chevron { transform: rotate(180deg); }
        .faq-body { animation: faq-slide 0.2s ease-out; }
        @keyframes faq-slide {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Global style adjustments for Light Mode overrides */
        body:not(.dark-theme) .text-white, 
        body:not(.dark-theme) .text-gray-100 {
            color: #0f172a !important;
        }
        body:not(.dark-theme) .text-gray-200 {
            color: #1e293b !important;
        }
        body:not(.dark-theme) .text-gray-300 {
            color: #334155 !important;
        }
        body:not(.dark-theme) .text-gray-400 {
            color: #64748b !important;
        }
        body:not(.dark-theme) .text-gray-500 {
            color: #94a3b8 !important;
        }
        body:not(.dark-theme) .text-indigo-400 {
            color: #4f46e5 !important; /* Indigo-600 */
        }
        body:not(.dark-theme) .text-teal-400 {
            color: #0d9488 !important; /* Teal-600 */
        }
        body:not(.dark-theme) .text-amber-400 {
            color: #d97706 !important; /* Amber-600 */
        }
        body:not(.dark-theme) .text-emerald-400 {
            color: #059669 !important; /* Emerald-600 */
        }
        body:not(.dark-theme) .text-red-400 {
            color: #dc2626 !important; /* Red-600 */
        }
        body:not(.dark-theme) .border-white\/10, 
        body:not(.dark-theme) .border-white\/5,
        body:not(.dark-theme) .border-white\/20,
        body:not(.dark-theme) .border-white\/8,
        body:not(.dark-theme) .border-white\/12,
        body:not(.dark-theme) .border-white\/30,
        body:not(.dark-theme) .border-white\/25 {
            border-color: #e2e8f0 !important; /* Slate-200 */
        }
        body:not(.dark-theme) .divide-white\/5 > :not([hidden]) ~ :not([hidden]),
        body:not(.dark-theme) .divide-white\/10 > :not([hidden]) ~ :not([hidden]) {
            border-color: #f1f5f9 !important; /* Slate-100 */
        }

        /* Background overrides */
        body:not(.dark-theme) .bg-white\/5,
        body:not(.dark-theme) .bg-white\/10,
        body:not(.dark-theme) .bg-white\/8,
        body:not(.dark-theme) .bg-white\/01,
        body:not(.dark-theme) .bg-white\/\[0\.01\],
        body:not(.dark-theme) .bg-white\/\[0\.03\] {
            background-color: #f8fafc !important; /* Slate-50 */
        }

        body:not(.dark-theme) .bg-[#080c14],
        body:not(.dark-theme) .bg-[#0a0d16] {
            background-color: #f8fafc !important;
        }
        body:not(.dark-theme) .bg-[#111827] {
            background-color: #ffffff !important;
        }

        body:not(.dark-theme) .bg-indigo-500\/10 {
            background-color: #e0e7ff !important; /* Indigo-100 */
            color: #4f46e5 !important;
        }
        body:not(.dark-theme) .bg-teal-500\/10 {
            background-color: #ccfbf1 !important; /* Teal-100 */
            color: #0f766e !important;
        }
        body:not(.dark-theme) .bg-amber-500\/10 {
            background-color: #fef3c7 !important; /* Amber-100 */
            color: #b45309 !important;
        }
        body:not(.dark-theme) .bg-emerald-500\/10 {
            background-color: #d1fae5 !important; /* Emerald-100 */
            color: #047857 !important;
        }
        body:not(.dark-theme) .bg-red-500\/10 {
            background-color: #fee2e2 !important; /* Red-100 */
            color: #b91c1c !important;
        }

        /* Specific header active indicator colors */
        body:not(.dark-theme) .bg-white\/10 {
            background-color: #e0e7ff !important; /* Indigo active color background */
            color: #4f46e5 !important;
        }

        /* Text title headers and gradients */
        body:not(.dark-theme) .bg-gradient-to-r.from-white.to-gray-400 {
            background-image: linear-gradient(to right, #0f172a, #475569) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }
        body:not(.dark-theme) .bg-gradient-to-r.from-white.to-indigo-300 {
            background-image: linear-gradient(to right, #1e1b4b, #4f46e5) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }

        /* Shadow adjustments */
        body:not(.dark-theme) .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05) !important;
        }

        /* FAQ Styling */
        body:not(.dark-theme) .faq-item {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
        }
        body:not(.dark-theme) .faq-body {
            border-top: 1px solid #f1f5f9 !important;
        }

        /* Form Controls for light mode */
        body:not(.dark-theme) input[type="text"],
        body:not(.dark-theme) input[type="password"],
        body:not(.dark-theme) input[type="email"],
        body:not(.dark-theme) input[type="number"],
        body:not(.dark-theme) select,
        body:not(.dark-theme) textarea {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }
        body:not(.dark-theme) input[type="text"]:focus,
        body:not(.dark-theme) input[type="password"]:focus,
        body:not(.dark-theme) input[type="email"]:focus,
        body:not(.dark-theme) input[type="number"]:focus,
        body:not(.dark-theme) select:focus,
        body:not(.dark-theme) textarea:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
        }

        /* Keep primary button text color white */
        body:not(.dark-theme) .bg-gradient-to-r.from-indigo-500.to-indigo-600,
        body:not(.dark-theme) .bg-gradient-to-r.from-indigo-600.to-indigo-700,
        body:not(.dark-theme) .bg-indigo-600,
        body:not(.dark-theme) .bg-indigo-500,
        body:not(.dark-theme) .bg-red-500,
        body:not(.dark-theme) .bg-emerald-500 {
            color: #ffffff !important;
        }

        /* Toast container styling */
        body:not(.dark-theme) #toast-container .toast-item {
            background: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05) !important;
        }

        /* Adjust footer colors */
        body:not(.dark-theme) footer {
            background-color: #ffffff !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        /* ── Dark Mode Style System ────────────────────────────────────────── */
        body.dark-theme {
            background-color: #080c14 !important;
            color: #94a3b8 !important;
        }

        body.dark-theme .glass-card {
            background-color: #0d1423 !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #94a3b8 !important;
        }

        body.dark-theme .card-elevated {
            background-color: #10192b !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #94a3b8 !important;
        }

        body.dark-theme .faq-item {
            background-color: #0d1423 !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        body.dark-theme .faq-body {
            border-top-color: rgba(255, 255, 255, 0.06) !important;
        }

        body.dark-theme input[type="text"],
        body.dark-theme input[type="password"],
        body.dark-theme input[type="email"],
        body.dark-theme input[type="number"],
        body.dark-theme select,
        body.dark-theme textarea {
            background-color: #0d1423 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        body.dark-theme input[type="text"]:focus,
        body.dark-theme input[type="password"]:focus,
        body.dark-theme input[type="email"]:focus,
        body.dark-theme input[type="number"]:focus,
        body.dark-theme select:focus,
        body.dark-theme textarea:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
        }

        body.dark-theme #toast-container .toast-item {
            background-color: #0d1423 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-theme footer {
            background-color: #0a0d16 !important;
            border-top-color: rgba(255, 255, 255, 0.06) !important;
        }

        body.dark-theme header {
            background-color: #0a0d16 !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
            box-shadow: none !important;
        }

        body.dark-theme img[alt="Logo"],
        body.dark-theme img[alt="BiblioTech Cloud"] {
            filter: brightness(0) invert(1) !important;
        }

        /* Text color overrides for Dark Mode */
        body.dark-theme .text-slate-800,
        body.dark-theme .text-gray-800 {
            color: #f8fafc !important;
        }
        body.dark-theme .text-slate-700,
        body.dark-theme .text-slate-600,
        body.dark-theme .text-gray-700,
        body.dark-theme .text-gray-600 {
            color: #cbd5e1 !important;
        }
        body.dark-theme .text-slate-500,
        body.dark-theme .text-gray-500 {
            color: #94a3b8 !important;
        }
        body.dark-theme .text-slate-400,
        body.dark-theme .text-gray-400 {
            color: #64748b !important;
        }

        /* Background utility overrides for Dark Mode */
        body.dark-theme .bg-slate-50,
        body.dark-theme .bg-slate-100,
        body.dark-theme .bg-gray-50,
        body.dark-theme .bg-gray-100 {
            background-color: #0d1423 !important;
            color: #cbd5e1 !important;
        }

        body.dark-theme .bg-indigo-50 {
            background-color: rgba(99, 102, 241, 0.15) !important;
            color: #a5b4fc !important;
        }

        body.dark-theme .bg-red-50 {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #fca5a5 !important;
        }

        /* Border utility overrides for Dark Mode */
        body.dark-theme .border-slate-100,
        body.dark-theme .border-slate-200,
        body.dark-theme .border-slate-200\/50,
        body.dark-theme .border-gray-100,
        body.dark-theme .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
    </style>
    <script>
        // Check local storage or system preference to apply dark theme class immediately
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans text-slate-800 min-h-screen flex flex-col overflow-x-hidden">
    <script>
        // Apply class to body immediately to prevent style flashes
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.body.classList.add('dark-theme');
        }
    </script>

    <!-- Header / Light Clean Navbar -->
    @if(!Route::is('login') && !Route::is('register') && !Route::is('password.request') && !Route::is('password.reset'))
    <header class="sticky top-0 z-50 bg-white border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 py-3">

                <!-- Logo & Brand -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer flex-shrink-0">
                    <img src="{{ asset('images/Logo_large.png') }}" alt="Logo"
                        class="h-8 md:h-10 w-auto transition-transform duration-300 group-hover:rotate-[-2deg] group-hover:scale-105">
                </a>

                <!-- Navigation Links -->
                @auth
                    @php
                        $adminUser = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::find(1);
                        $adminId = $adminUser ? $adminUser->id : 1;
                    @endphp
                @endauth

                <!-- Desktop Nav (hidden on mobile) -->
                <nav class="hidden md:flex items-center gap-1">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Dashboard</a>
                            <a href="{{ route('admin.emprunts') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.emprunts') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Gérer Emprunts</a>
                            <a href="{{ route('admin.livres.create') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.livres.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Ajouter Livre</a>
                        @else
                            <a href="{{ route('membre.dashboard') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Dashboard</a>
                            <a href="{{ route('membre.livres') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.livres') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Livres</a>
                            <a href="{{ route('membre.mesEmprunts') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.mesEmprunts') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Mes Emprunts</a>
                            <a href="{{ route('membre.profil') }}"
                                class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.profil') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Mon Profil</a>
                        @endif
                    @endauth
                </nav>

                <!-- Right Controls: Notification + Avatar + Hamburger -->
                <div class="flex items-center gap-2">
                    @auth
                        <!-- Support Chat SVG Icon Button -->
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.chat') : route('membre.chat') }}"
                            class="relative p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition-all duration-200 cursor-pointer"
                            title="Support Chat"
                            id="nav-chat-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z">
                                </path>
                            </svg>
                            <span id="nav-unread-badge"
                                class="hidden absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white shadow-md shadow-red-500/30 animate-pulse">0</span>
                        </a>

                        <!-- Notification Bell -->
                        <div class="relative" id="notification-wrapper">
                            <button onclick="toggleNotifications()"
                                class="relative p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition-all duration-200 cursor-pointer"
                                title="Notifications">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0">
                                    </path>
                                </svg>
                                <span id="notif-count-badge"
                                    class="hidden absolute -top-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white shadow-md shadow-red-500/30 animate-pulse">0</span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown"
                                class="hidden absolute right-0 top-full mt-2 w-[340px] sm:w-[380px] max-h-[420px] card-elevated rounded-2xl shadow-2xl border border-slate-200 z-[999] overflow-hidden">
                                <div
                                    class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-indigo-500 to-teal-500">
                                </div>
                                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                                    <h4 class="font-outfit font-bold text-sm text-slate-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0">
                                            </path>
                                        </svg>
                                        Notifications
                                    </h4>
                                    <button onclick="markAllNotificationsRead()"
                                        class="text-[10px] font-semibold text-indigo-600 hover:text-indigo-700 transition cursor-pointer">Tout lire</button>
                                </div>
                                <div id="notification-list" class="overflow-y-auto max-h-[340px] p-2 space-y-1">
                                    <div class="text-center text-slate-400 text-xs py-6">Chargement...</div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Avatar / Icon Pill -->
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('membre.profil') }}"
                            class="flex items-center gap-2 p-1 rounded-full border border-slate-200 hover:border-indigo-500 hover:bg-slate-50 transition-all duration-200 cursor-pointer"
                            title="Mon Profil ({{ auth()->user()->name }})">
                            <img src="{{ asset(auth()->user()->image_profile ?? 'images/user_avatar.png') }}" alt="Avatar"
                                class="w-7 h-7 rounded-full object-cover">
                            @if(auth()->user()->isMembre())
                                <span class="hidden sm:inline-flex text-xs font-bold text-slate-700 px-1">{{ auth()->user()->points }} pts</span>
                            @else
                                <span class="hidden sm:inline-flex text-[9px] font-extrabold text-indigo-600 bg-indigo-50 border border-indigo-200/50 px-2 py-0.5 rounded uppercase tracking-wider">Admin</span>
                            @endif
                        </a>

                        <!-- Theme Toggle Button -->
                        <button onclick="toggleTheme()" 
                            class="flex items-center gap-2 px-2.5 py-1 rounded-full border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-white/5 transition-all duration-200 cursor-pointer mr-2"
                            title="Changer de thème">
                            <!-- Sun Icon -->
                            <svg class="w-3.5 h-3.5 text-amber-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.46 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486a1 1 0 01-1.414 0l-.707-.707a1 1 0 011.414-1.414l.707.707a1 1 0 010 1.414zM3 11a1 1 0 100-2H2a1 1 0 100 2h1z" clip-rule="evenodd" />
                            </svg>
                            
                            <!-- Switch Track -->
                            <span class="w-6.5 h-3.5 bg-slate-300 dark:bg-teal-400 rounded-full p-0.5 transition-colors duration-200 relative inline-block">
                                <span id="theme-toggle-dot" class="w-2.5 h-2.5 bg-white rounded-full block transform translate-x-0 dark:translate-x-2.5 transition-transform duration-200"></span>
                            </span>
                            
                            <!-- Moon Icon -->
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </button>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="hidden md:inline">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-red-50 transition-all duration-200 cursor-pointer"
                                title="Déconnexion">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Quitter</span>
                            </button>
                        </form>

                        <!-- Mobile hamburger -->
                        <button id="mobile-menu-btn" onclick="toggleMobileMenu()"
                            class="md:hidden p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition-all duration-200 cursor-pointer"
                            aria-label="Menu principal">
                            <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg id="close-menu-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('login') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="ml-2 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>

        @auth
        <!-- Mobile Navigation Drawer -->
        <div id="mobile-nav-drawer" class="hidden border-t border-slate-100 bg-white shadow-lg">
            <div class="px-4 py-2 pb-4 space-y-1">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Dashboard</a>
                    <a href="{{ route('admin.emprunts') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.emprunts') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Gérer Emprunts</a>
                    <a href="{{ route('admin.livres.create') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.livres.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Ajouter Livre</a>
                    <a href="{{ route('admin.chat') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('admin.chat') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Support Chat</a>
                @else
                    <a href="{{ route('membre.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Dashboard</a>
                    <a href="{{ route('membre.livres') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.livres') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Livres</a>
                    <a href="{{ route('membre.mesEmprunts') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.mesEmprunts') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Mes Emprunts</a>
                    <a href="{{ route('membre.profil') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.profil') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Mon Profil</a>
                    <a href="{{ route('membre.chat') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 cursor-pointer {{ Route::is('membre.chat') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50' }}">Support Chat</a>
                @endif
                <div class="pt-2 mt-1 border-t border-slate-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold text-red-500 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </header>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        @if(session('success'))
            <div
                class="alert flex items-center bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl mb-6 font-medium text-sm">
                <svg class="w-5 h-5 mr-2.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div
                class="alert flex items-start bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-6 font-medium text-sm">
                <svg class="w-5 h-5 mr-2.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <div class="flex-1">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ── FAQ Section (Placed before Footer) ────────────────────────── -->
    <section id="faq-section" class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-slate-200/50">
        <div class="mb-8">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 text-xs font-semibold uppercase tracking-wider mb-3">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path></svg>
                FAQ
            </span>
            <h3 class="font-outfit font-bold text-2xl text-slate-800 dark:text-white mb-2">Questions fréquentes</h3>
            <p class="text-slate-500 dark:text-gray-400 text-sm">Tout ce que vous devez savoir sur BiblioTech Cloud.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- FAQ 1 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Comment emprunter un livre ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    Naviguez vers l'onglet <strong class="text-slate-800 dark:text-gray-200">Livres</strong> depuis votre tableau de bord. Cliquez sur le bouton <strong class="text-slate-800 dark:text-gray-200">Emprunter</strong> sur la fiche du livre souhaité. Renseignez les dates d'emprunt et soumettez votre demande. L'administrateur valide ou refuse la demande — vous recevez une notification en temps réel.
                </div>
            </details>

            <!-- FAQ 2 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Quelle est la durée maximale d'un emprunt ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    La durée est définie individuellement par livre par l'administrateur (généralement <strong class="text-slate-800 dark:text-gray-200">14 jours</strong>). Lors de la demande d'emprunt, la date de retour maximale est calculée automatiquement selon la politique du livre sélectionné.
                </div>
            </details>

            <!-- FAQ 3 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Comment consulter mes emprunts en cours ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    Accédez à <strong class="text-slate-800 dark:text-gray-200">Mes Emprunts</strong> depuis la navigation principale. Vous y retrouvez l'historique complet de vos demandes avec leur statut (<span class="text-amber-400">En attente</span>, <span class="text-emerald-400">Accepté</span>, <span class="text-red-400">Refusé</span>) et les dates de retour.
                </div>
            </details>

            <!-- FAQ 4 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Comment fonctionne le système de notifications ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    BiblioTech Cloud utilise les <strong class="text-slate-800 dark:text-gray-200">WebSockets</strong> (Pusher / Reverb) pour les notifications en temps réel. Chaque action de l'administrateur (acceptation, refus d'emprunt) génère immédiatement une notification visible dans la cloche en haut à droite et un toast de confirmation.
                </div>
            </details>

            <!-- FAQ 5 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Comment modifier ma photo de profil ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    Rendez-vous dans <strong class="text-slate-800 dark:text-gray-200">Mon Profil</strong>. Cliquez sur <em>Changer l'avatar</em> sous votre photo actuelle et sélectionnez une image depuis votre appareil. L'image est hébergée sur <strong class="text-slate-800 dark:text-gray-200">Cloudinary</strong> et mise à jour instantanément sur l'ensemble de la plateforme.
                </div>
            </details>

            <!-- FAQ 6 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Un livre est indisponible — quand sera-t-il de retour ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    Dans le catalogue, les livres à 0 exemplaire affichent un bouton <strong class="text-slate-800 dark:text-gray-200">Infos Prêt</strong>. Cliquez dessus pour voir la liste des exemplaires empruntés et leurs <span class="text-teal-600">dates de retour prévues</span> — vous pouvez ainsi planifier votre demande en conséquence.
                </div>
            </details>

            <!-- FAQ 7 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Comment contacter l'administrateur ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    Utilisez le <strong class="text-slate-800 dark:text-gray-200">Support Chat</strong> accessible depuis la navigation principale ou le widget flottant en bas à droite. Les messages sont transmis en direct à l'administrateur via WebSockets. Vous recevrez une notification dès sa réponse.
                </div>
            </details>

            <!-- FAQ 8 -->
            <details class="faq-item bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/[0.07] rounded-xl overflow-hidden shadow-sm">
                <summary class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors duration-150">
                    <span class="font-semibold text-slate-800 dark:text-white text-sm">Que signifie le système de points et badges ?</span>
                    <svg class="faq-chevron w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="faq-body px-5 pb-5 pt-2 text-sm text-slate-600 dark:text-gray-400 leading-relaxed border-t border-slate-100 dark:border-white/[0.05]">
                    BiblioTech Cloud intègre un système de <strong class="text-slate-800 dark:text-gray-200">fidélité</strong> : chaque emprunt accepté rapporte des points. Les badges (Nouveau lecteur → Maître des livres) récompensent votre engagement. Suivez votre classement dans le tableau de bord et comparez-vous aux autres lecteurs de l'institution.
                </div>
            </details>

        </div>
    </section>

    <!-- ── Premium Footer ─────────────────────────────────────────────── -->
    <footer class="mt-auto border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

            <!-- Footer Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

                <!-- Brand Column -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/Logo_icon.png') }}" alt="BiblioTech Cloud" class="h-8 w-auto opacity-90">
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-5 max-w-xs">
                        Plateforme de gestion de bibliothèque conçue pour les établissements d'enseignement, les universités et les institutions culturelles.
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                        <span class="text-xs text-gray-500">Tous les services opérationnels</span>
                    </div>
                </div>

                <!-- Platform Links -->
                <div>
                    <h4 class="font-semibold text-white text-sm mb-4 tracking-wide">Plateforme</h4>
                    <ul class="space-y-2.5">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li><a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Tableau de bord</a></li>
                                <li><a href="{{ route('admin.emprunts') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Gestion des emprunts</a></li>
                                <li><a href="{{ route('admin.livres.create') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Ajouter un livre</a></li>
                                <li><a href="{{ route('admin.chat') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Support Chat</a></li>
                            @else
                                <li><a href="{{ route('membre.dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Tableau de bord</a></li>
                                <li><a href="{{ route('membre.livres') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Catalogue des livres</a></li>
                                <li><a href="{{ route('membre.mesEmprunts') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Mes emprunts</a></li>
                                <li><a href="{{ route('membre.profil') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Mon profil</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Créer un compte</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Support Column -->
                <div>
                    <h4 class="font-semibold text-white text-sm mb-4 tracking-wide">Support</h4>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="#faq-section" onclick="document.getElementById('faq-section').scrollIntoView({behavior:'smooth'}); return false;"
                                class="text-sm text-gray-400 hover:text-white transition-colors duration-200">
                                Questions fréquentes
                            </a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ auth()->user()->isAdmin() ? route('admin.chat') : route('membre.chat') }}"
                                    class="text-sm text-gray-400 hover:text-white transition-colors duration-200">
                                    Chat support en ligne
                                </a>
                            </li>
                        @endauth
                        <li><span class="text-sm text-gray-500 cursor-default">Documentation</span></li>
                        <li><span class="text-sm text-gray-500 cursor-default">Centre d'aide</span></li>
                    </ul>
                </div>

                <!-- System Stack -->
                <div>
                    <h4 class="font-semibold text-white text-sm mb-4 tracking-wide">Technologies</h4>
                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.357 4.557c.27 0 .54.01.806.03l-1.093.632c-.185.107-.284.316-.254.525l.363 2.506-1.832 1.058-1.832-1.058.363-2.506a.487.487 0 00-.254-.525L7.03 4.735A8.067 8.067 0 0112.357 4.557zm-6.47 2.49l.91.527-.286 1.978-1.633.943a8.025 8.025 0 011.009-3.448zm12.94 0a8.025 8.025 0 011.008 3.448l-1.632-.943-.287-1.978.91-.527zM5.003 10.53l1.437.83.001 2.115-1.282.74a8.026 8.026 0 01-.156-3.685zm13.994 0a8.026 8.026 0 01-.156 3.685l-1.282-.74v-2.115l1.438-.83zM8.574 15.3l1.83 1.057-.001 2.116-.91.526a8.067 8.067 0 01-2.468-2.756l1.549-.943zm6.852 0l1.549.943a8.067 8.067 0 01-2.468 2.756l-.91-.526v-2.116l1.829-1.057zm-3.79 2.186l1.093.632a8.067 8.067 0 01-3.37 0l1.094-.632 1.183.683 1.183-.683z"/>
                            </svg>
                            Laravel 11 · PHP 8.3
                        </li>
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                            SQLite · Eloquent ORM
                        </li>
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            WebSockets · Pusher / Reverb
                        </li>
                        <li class="flex items-center gap-2.5 text-sm text-gray-400">
                            <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>
                            </svg>
                            Cloudinary · Tailwind CSS
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ── Copyright Bar ──────────────────────────────────────── -->
            <div class="mt-12 pt-6 border-t border-white/[0.05] flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo_icon.png') }}" alt="Logo" class="h-5 w-auto opacity-40">
                    <span class="text-xs text-gray-600">© 2026. Tous droits réservés.</span>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-600">
                    <span>Version 2.0</span>
                    <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                    <span>Hackathon 2026</span>
                    <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                    <span>Développement Digital</span>
                </div>
            </div>
        </div>
    </footer>

    @auth
        <!-- Preloaded Audio Elements for Instant Playback -->
        <audio id="audio-message" src="{{ asset('audios/Jawbni asahbi.m4a.mp4') }}" preload="auto"></audio>
        <audio id="audio-accept" src="{{ asset('audios/Accepter.m4a.mp4') }}" preload="auto"></audio>
        <audio id="audio-refuse" src="{{ asset('audios/Refuser.m4a.mp4') }}" preload="auto"></audio>
        <audio id="audio-pending" src="{{ asset('audios/En attente.m4a.mp4') }}" preload="auto"></audio>

        <!-- Global JS Config & Real-Time Notifications -->
        <script src="https://js.pusher.com/8.0/pusher.min.js"></script>
        <script>
            const authId = {{ auth()->id() }};
            const isAdmin = {{ auth()->user()->isAdmin() ? 'true' : 'false' }};
            const adminId = {{ $adminId }};
            let globalPusher = null;
            let notifDropdownOpen = false;

            // ───────── Mobile Menu ─────────
            function toggleMobileMenu() {
                const drawer = document.getElementById('mobile-nav-drawer');
                const hamburger = document.getElementById('hamburger-icon');
                const closeIcon = document.getElementById('close-menu-icon');
                const isHidden = drawer.classList.contains('hidden');
                drawer.classList.toggle('hidden', !isHidden);
                hamburger.classList.toggle('hidden', isHidden);
                closeIcon.classList.toggle('hidden', !isHidden);
            }

            // ───────── Theme Toggle ─────────
            function toggleTheme() {
                const html = document.documentElement;
                const body = document.body;
                
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    body.classList.remove('dark-theme');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    body.classList.add('dark-theme');
                    localStorage.setItem('theme', 'dark');
                }
            }

            // Initialize global Pusher immediately so page-specific scripts can reuse it in DOMContentLoaded
            try {
                const isProductionPusher = '{{ config("broadcasting.default") }}' === 'pusher';
                const pusherKey = isProductionPusher ? '{{ config("broadcasting.connections.pusher.key") }}' : '{{ config("broadcasting.connections.reverb.key", "bibliotech-app-key") }}';
                const config = isProductionPusher ? {
                    cluster: '{{ config("broadcasting.connections.pusher.options.cluster", "eu") }}',
                    forceTLS: true
                } : {
                    wsHost: window.location.hostname,
                    wsPort: 8080,
                    wssPort: 8080,
                    forceTLS: false,
                    encrypted: false,
                    disableStats: true,
                    enabledTransports: ['ws', 'wss']
                };

                globalPusher = new Pusher(pusherKey, config);
            } catch (e) {
                console.error("Global Pusher init failed:", e);
            }

            // ───────── Chat Unread Badges ─────────
            async function updateUnreadBadges() {
                try {
                    const res = await fetch('/chat/unread-count');
                    const data = await res.json();
                    const total = data.total;

                    const navBadge = document.getElementById('nav-unread-badge');
                    if (navBadge) {
                        if (total > 0) {
                            navBadge.innerText = total;
                            navBadge.classList.remove('hidden');
                        } else {
                            navBadge.classList.add('hidden');
                        }
                    }

                    const widgetBadge = document.getElementById('widget-unread-badge');
                    if (widgetBadge) {
                        if (total > 0) {
                            widgetBadge.innerText = total;
                            widgetBadge.classList.remove('hidden');
                        } else {
                            widgetBadge.classList.add('hidden');
                        }
                    }

                    window.dispatchEvent(new CustomEvent('unreadCountUpdated', { detail: data }));
                } catch (e) {
                    console.error("Unread count fetch failed:", e);
                }
            }

            // ───────── Notification System ─────────
            async function updateNotifBadge() {
                try {
                    const res = await fetch('/notifications/unread-count');
                    const data = await res.json();
                    const badge = document.getElementById('notif-count-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.innerText = data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                } catch (e) { }
            }

            function toggleNotifications() {
                const dropdown = document.getElementById('notification-dropdown');
                notifDropdownOpen = !notifDropdownOpen;
                if (notifDropdownOpen) {
                    dropdown.classList.remove('hidden');
                    fetchNotifications();
                } else {
                    dropdown.classList.add('hidden');
                }
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                const wrapper = document.getElementById('notification-wrapper');
                if (wrapper && !wrapper.contains(e.target)) {
                    const dropdown = document.getElementById('notification-dropdown');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                        notifDropdownOpen = false;
                    }
                }
            });

            async function fetchNotifications() {
                const list = document.getElementById('notification-list');
                try {
                    const res = await fetch('/notifications');
                    const data = await res.json();
                    if (data.length === 0) {
                        list.innerHTML = `<div class="text-center text-gray-500 text-xs py-6">Aucune notification pour le moment.</div>`;
                        return;
                    }
                    list.innerHTML = '';
                    data.forEach(n => {
                        list.insertAdjacentHTML('beforeend', renderNotifItem(n));
                    });
                } catch (e) {
                    list.innerHTML = `<div class="text-center text-red-400 text-xs py-6">Erreur de chargement.</div>`;
                }
            }

            function renderNotifItem(n) {
                const iconMap = {
                    success: { bg: 'bg-emerald-500/10', text: 'text-emerald-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' },
                    error: { bg: 'bg-red-500/10', text: 'text-red-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' },
                    warning: { bg: 'bg-amber-500/10', text: 'text-amber-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>' },
                    info: { bg: 'bg-indigo-500/10', text: 'text-indigo-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>' },
                };
                const icon = iconMap[n.icon] || iconMap.info;
                const unreadDot = !n.is_read ? '<span class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 animate-pulse"></span>' : '';
                const opacity = n.is_read ? 'opacity-60' : '';

                return `
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-white/5 transition-all duration-150 cursor-default ${opacity}" onclick="markNotifRead(${n.id}, this)">
                            <div class="w-8 h-8 rounded-full ${icon.bg} ${icon.text} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">${icon.svg}</svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-white truncate">${escapeNotifHtml(n.title)}</span>
                                    ${unreadDot}
                                </div>
                                <p class="text-[11px] text-gray-400 mt-0.5 leading-relaxed">${escapeNotifHtml(n.message)}</p>
                                <span class="text-[9px] text-gray-500 mt-1 block">${n.time_ago}</span>
                            </div>
                        </div>
                    `;
            }

            function escapeNotifHtml(text) {
                return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            }

            async function markNotifRead(id, el) {
                try {
                    await fetch(`/notifications/${id}/mark-read`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    if (el) el.classList.add('opacity-60');
                    updateNotifBadge();
                } catch (e) { }
            }

            async function markAllNotificationsRead() {
                try {
                    await fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    updateNotifBadge();
                    fetchNotifications();
                } catch (e) { }
            }

            // ───────── Toast Notification ─────────
            function showToastNotification(notif) {
                const iconMap = {
                    success: {
                        color: 'border-emerald-500',
                        iconBg: 'bg-emerald-500/15',
                        icon: '<svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    },
                    error: {
                        color: 'border-red-500',
                        iconBg: 'bg-red-500/15',
                        icon: '<svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    },
                    warning: {
                        color: 'border-amber-500',
                        iconBg: 'bg-amber-500/15',
                        icon: '<svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>'
                    },
                    info: {
                        color: 'border-indigo-500',
                        iconBg: 'bg-indigo-500/15',
                        icon: '<svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>'
                    },
                };
                const style = iconMap[notif.icon] || iconMap.info;
                const toastId = 'toast-' + Date.now();

                const toastHtml = `
                        <div id="${toastId}" class="toast-item glass-card rounded-xl border-l-4 ${style.color} p-4 flex items-start gap-3 w-[340px] shadow-2xl transform translate-x-full transition-all duration-500 ease-out cursor-pointer" onclick="this.remove(); updateNotifBadge();">
                            <div class="w-8 h-8 rounded-full ${style.iconBg} flex items-center justify-center flex-shrink-0">${style.icon}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-bold text-white">${escapeNotifHtml(notif.title)}</div>
                                <div class="text-[11px] text-gray-300 mt-0.5 leading-relaxed">${escapeNotifHtml(notif.message)}</div>
                            </div>
                            <button class="text-gray-500 hover:text-white transition cursor-pointer flex-shrink-0 mt-0.5" onclick="event.stopPropagation(); document.getElementById('${toastId}').remove();">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    `;

                let container = document.getElementById('toast-container');
                if (!container) {
                    const div = document.createElement('div');
                    div.id = 'toast-container';
                    div.className = 'fixed top-24 right-6 z-[9999] flex flex-col gap-3';
                    document.body.appendChild(div);
                    container = div;
                }

                container.insertAdjacentHTML('beforeend', toastHtml);
                const toast = document.getElementById(toastId);

                // Animate in
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        toast.classList.remove('translate-x-full');
                        toast.classList.add('translate-x-0');
                    });
                });

                // Auto-remove after 6s
                setTimeout(() => {
                    if (toast) {
                        toast.classList.add('translate-x-full', 'opacity-0');
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 6000);
            }

            // ───────── Init ─────────
            document.addEventListener('DOMContentLoaded', () => {
                updateUnreadBadges();
                updateNotifBadge();

                // Set up subscriptions if globalPusher is initialized
                if (globalPusher) {
                    try {
                        // Chat channel
                        const globalChannel = globalPusher.subscribe('chat');
                        globalChannel.bind('App\\Events\\MessageSent', function (data) {
                            if (data.receiver_id === authId) {
                                // Play incoming message sound
                                const chatAudio = document.getElementById('audio-message');
                                if (chatAudio) {
                                    chatAudio.currentTime = 0;
                                    chatAudio.play().catch(e => console.log("Audio play blocked by browser autoplay policy:", e));
                                }

                                if (typeof activeUserId !== 'undefined' && activeUserId === data.sender_id) {
                                    return;
                                }
                                if (window.location.pathname === '/membre/chat') {
                                    return;
                                }
                                if (typeof widgetOpen !== 'undefined' && widgetOpen && data.sender_id === adminId) {
                                    appendWidgetMessage(data);
                                    fetch(`/chat/read/${adminId}`, {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                    });
                                    return;
                                }
                                updateUnreadBadges();
                            }
                        });

                        // Notifications channel
                        const notifChannel = globalPusher.subscribe('notifications');
                        notifChannel.bind('App\\Events\\NotificationSent', function (data) {
                            if (data.user_id === authId) {
                                // Play status audio based on type
                                let audioElement = null;
                                if (data.type === 'emprunt_accepted') {
                                    audioElement = document.getElementById('audio-accept');
                                } else if (data.type === 'emprunt_refused') {
                                    audioElement = document.getElementById('audio-refuse');
                                } else if (data.type === 'emprunt_reset' || data.type === 'new_borrow') {
                                    audioElement = document.getElementById('audio-pending');
                                }

                                // Show toast
                                showToastNotification(data);
                                // Update badge
                                updateNotifBadge();
                                // Update dropdown if open
                                if (notifDropdownOpen) {
                                    fetchNotifications();
                                }

                                if (audioElement) {
                                    audioElement.currentTime = 0;
                                    let reloadTriggered = false;
                                    const triggerReload = () => {
                                        if (!reloadTriggered) {
                                            reloadTriggered = true;
                                            window.location.reload();
                                        }
                                    };

                                    // Play audio and reload ONLY after it ends
                                    audioElement.play()
                                        .then(() => {
                                            audioElement.onended = triggerReload;
                                            // Fallback reload after 4 seconds if onended is delayed or backgrounded
                                            setTimeout(triggerReload, 4000);
                                        })
                                        .catch(e => {
                                            console.log("Audio play blocked by browser autoplay policy:", e);
                                            triggerReload();
                                        });
                                } else {
                                    window.location.reload();
                                }
                            }
                        });
                    } catch (e) {
                        console.error("Global Pusher subscription failed:", e);
                    }
                }

                // Poll notifications every 15 seconds as fallback
                setInterval(() => { updateNotifBadge(); }, 15000);
            });
        </script>

        @if(auth()->user()->isMembre())
            <!-- Floating Support Chat Widget for Members -->
            <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">

                <!-- Chat Window (hidden by default) -->
                <div id="chat-widget-window"
                    class="hidden w-[330px] sm:w-[360px] h-[400px] rounded-2xl glass-card flex flex-col shadow-2xl overflow-hidden mb-4 border border-white/10 relative transition-all duration-300">
                    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

                    <!-- Chat Header -->
                    <div class="px-5 py-3.5 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-bold text-xs border border-indigo-500/25">
                                AI
                            </div>
                            <div>
                                <h4 class="font-outfit font-bold text-xs text-white">Assistant BiblioTech</h4>
                                <div class="text-[9px] text-teal-400 flex items-center gap-1 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    En ligne (Chatbot)
                                </div>
                            </div>
                        </div>
                        <button onclick="toggleChatWidget()"
                            class="text-gray-400 hover:text-white transition-colors duration-150 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Admin Unread Message Notification Banner -->
                    <div id="widget-admin-notif-banner" class="hidden px-4 py-2 bg-indigo-500/10 border-b border-white/5 flex items-center justify-between text-[10px] text-gray-300">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            Vous avez des messages de l'administrateur.
                        </span>
                        <a href="{{ route('membre.chat') }}" class="font-bold text-indigo-400 hover:underline">Ouvrir le support</a>
                    </div>

                    <!-- Messages Container -->
                    <div id="widget-messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[#080c14]/20 text-xs animate-fade-in">
                    </div>

                    <!-- Input Form -->
                    <form id="widget-chat-form" onsubmit="handleWidgetSendMessage(event)"
                        class="p-3 border-t border-white/5 bg-white/[0.01] flex gap-2 items-center">
                        <input type="text" id="widget-message-input" placeholder="Posez une question à l'assistant..."
                            class="flex-1 px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition duration-150 text-xs">
                        <button type="submit"
                            class="p-2 rounded-xl text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-600/10 flex items-center justify-center transition-all duration-150 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Floating Trigger Button -->
                <button onclick="toggleChatWidget()"
                    class="w-14 h-14 rounded-full bg-gradient-to-r from-indigo-500 to-teal-500 text-white flex items-center justify-center shadow-lg hover:shadow-xl hover:shadow-indigo-500/25 hover:scale-105 transform transition-all duration-200 cursor-pointer group relative">
                    <svg class="w-6 h-6 group-hover:rotate-12 transition-transform duration-200" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z">
                        </path>
                    </svg>
                    <!-- Floating Unread Badge -->
                    <span id="widget-unread-badge"
                        class="hidden absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-md shadow-red-500/30">0</span>
                </button>
            </div>

            <!-- Scripts for Chat Widget -->
            <script>
                let widgetOpen = false;
                let botHistory = [];

                // Load history from sessionStorage
                if (sessionStorage.getItem('biblio_bot_history')) {
                    try {
                        botHistory = JSON.parse(sessionStorage.getItem('biblio_bot_history'));
                    } catch (e) {
                        botHistory = [];
                    }
                }

                // Listen for unreadCountUpdated to toggle the admin notification banner inside the widget
                window.addEventListener('unreadCountUpdated', (e) => {
                    const total = e.detail.total || 0;
                    const banner = document.getElementById('widget-admin-notif-banner');
                    if (banner) {
                        if (total > 0) {
                            banner.classList.remove('hidden');
                        } else {
                            banner.classList.add('hidden');
                        }
                    }
                });

                function toggleChatWidget() {
                    const windowEl = document.getElementById('chat-widget-window');
                    widgetOpen = !widgetOpen;

                    if (widgetOpen) {
                        windowEl.classList.remove('hidden');
                        renderBotChat();
                        // Update unread count immediately to refresh banner status
                        updateUnreadBadges();
                    } else {
                        windowEl.classList.add('hidden');
                    }
                }

                function saveBotHistory() {
                    sessionStorage.setItem('biblio_bot_history', JSON.stringify(botHistory));
                }

                function renderBotChat() {
                    const container = document.getElementById('widget-messages-container');
                    container.innerHTML = '';

                    if (botHistory.length === 0) {
                        botHistory.push({
                            id: 'welcome',
                            isBot: true,
                            message: "Bonjour ! Je suis l'assistant virtuel de BiblioTech. 🤖\nComment puis-je vous aider aujourd'hui ? Sélectionnez l'une des options ci-dessous ou posez-moi votre question directement.",
                            showOptions: true
                        });
                        saveBotHistory();
                    }

                    botHistory.forEach(msg => {
                        appendBotMessageHtml(msg);
                    });

                    container.scrollTop = container.scrollHeight;
                }

                function appendBotMessageHtml(msg) {
                    const container = document.getElementById('widget-messages-container');
                    const alignment = !msg.isBot ? 'justify-end' : 'justify-start';
                    const bubbleBg = !msg.isBot ? 'bg-indigo-600 text-white' : 'bg-white/5 border border-white/10 text-gray-200';
                    const roundedCorner = !msg.isBot ? 'rounded-br-none' : 'rounded-bl-none';

                    let optionsHtml = '';
                    if (msg.isBot && msg.showOptions) {
                        optionsHtml = `
                            <div class="flex flex-col gap-1.5 mt-3 chatbot-options-list">
                                <button onclick="handleBotOption('books')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Trouver/Rechercher un livre
                                </button>
                                <button onclick="handleBotOption('loans')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-teal-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Règles des emprunts
                                </button>
                                <button onclick="handleBotOption('profile')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Gérer mon profil
                                </button>
                                <button onclick="handleBotOption('alerts')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path></svg>
                                    Système d'alertes
                                </button>
                                <button onclick="handleBotOption('human')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-fuchsia-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path></svg>
                                    Contacter l'administrateur
                                </button>
                            </div>
                        `;
                    }

                    const timeStr = msg.time || new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

                    const msgHtml = `
                        <div class="flex ${alignment} w-full my-1 bot-msg-bubble">
                            <div class="max-w-[80%]">
                                <div class="px-3 py-2 rounded-xl ${roundedCorner} ${bubbleBg} shadow text-xs leading-relaxed break-words font-medium">
                                    ${escapeWidgetHtml(msg.message)}
                                    ${optionsHtml}
                                </div>
                                <div class="text-[9px] text-gray-500 mt-0.5 ${!msg.isBot ? 'text-right' : 'text-left'}">${timeStr}</div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', msgHtml);
                }

                function showTypingIndicator() {
                    const container = document.getElementById('widget-messages-container');
                    const indicatorHtml = `
                        <div id="bot-typing-indicator" class="flex justify-start w-full my-1">
                            <div class="max-w-[80%]">
                                <div class="px-3 py-2.5 rounded-xl rounded-bl-none bg-white/5 border border-white/10 text-gray-200 shadow text-xs flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 0ms"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 150ms"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 300ms"></span>
                                </div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', indicatorHtml);
                    container.scrollTop = container.scrollHeight;
                }

                function removeTypingIndicator() {
                    const el = document.getElementById('bot-typing-indicator');
                    if (el) el.remove();
                }

                function handleBotOption(option) {
                    document.querySelectorAll('.chatbot-options-list').forEach(list => {
                        list.classList.add('pointer-events-none', 'opacity-50');
                    });

                    let userMsgText = "";
                    let botReplyText = "";
                    let showMenuAfter = true;

                    switch (option) {
                        case 'books':
                            userMsgText = "Comment rechercher ou trouver un livre ?";
                            botReplyText = "📚 **Recherche & Disponibilité des Livres**\n\n1. Allez dans l'onglet **Livres** du menu principal.\n2. Saisissez votre recherche (titre, auteur, genre) dans la barre de recherche instantanée.\n3. **Indicateur de Stock** : Si un livre affiche **0 exemplaire restant**, un bouton bleu **'Infos Prêt'** apparaît. Cliquez dessus pour voir la date de retour prévue.";
                            break;
                        case 'loans':
                            userMsgText = "Quelles sont les règles d'emprunt ?";
                            botReplyText = "⏱️ **Règles et Durées d'Emprunts**\n\n• **Durée standard** : Un emprunt dure **14 jours**.\n• **Demande** : Cliquez sur le bouton 'Emprunter' sur la fiche du livre. L'administrateur reçoit votre demande.\n• **Validation** : Dès que l'administrateur accepte ou refuse, un badge de notification s'incrémente en haut à droite, et un 'toast' de confirmation apparaît.";
                            break;
                        case 'profile':
                            userMsgText = "Comment gérer mon profil ?";
                            botReplyText = "👤 **Gestion de votre Compte**\n\n• Pour mettre à jour vos informations, allez dans l'onglet **Mon Profil**.\n• Vous pouvez y téléverser une photo de profil personnalisée (elle est hébergée sur **Cloudinary**).\n• Vous pouvez également modifier votre mot de passe en toute sécurité depuis cet écran.";
                            break;
                        case 'alerts':
                            userMsgText = "Comment fonctionnent les alertes ?";
                            botReplyText = "🔔 **Notifications en Temps Réel**\n\n• **Cloche en haut à droite** : Elle affiche le nombre de notifications d'emprunts non lues.\n• **Toasts** : Des alertes de succès ou d'erreur glissent depuis le côté droit de l'écran en temps réel (propulsées par WebSockets).\n• **Badge de Chat** : Un point rouge s'affiche à côté de 'Support Chat' ou sur le widget flottant dès que l'administrateur vous envoie un message.";
                            break;
                        case 'human':
                            userMsgText = "Je souhaite parler à un administrateur.";
                            botReplyText = "💬 **Assistance Administrative**\n\nPour envoyer un message direct à l'administrateur, écrivez simplement votre question dans la zone de texte ci-dessous.\n\nVotre message sera enregistré dans sa console d'administration et il pourra prendre le relais en vous répondant directement sur la page **Support Chat**.";
                            showMenuAfter = false;
                            break;
                    }

                    const userMsg = {
                        id: 'msg-' + Date.now(),
                        isBot: false,
                        message: userMsgText,
                        time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                    };
                    botHistory.push(userMsg);
                    appendBotMessageHtml(userMsg);
                    saveBotHistory();

                    showTypingIndicator();
                    setTimeout(() => {
                        removeTypingIndicator();

                        const botReply = {
                            id: 'msg-' + (Date.now() + 1),
                            isBot: true,
                            message: botReplyText,
                            showOptions: showMenuAfter,
                            time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                        };
                        botHistory.push(botReply);
                        appendBotMessageHtml(botReply);
                        saveBotHistory();

                        const container = document.getElementById('widget-messages-container');
                        container.scrollTop = container.scrollHeight;
                    }, 800);
                }

                async function handleWidgetSendMessage(e) {
                    e.preventDefault();
                    const input = document.getElementById('widget-message-input');
                    const text = input.value.trim();
                    if (!text) return;
                    input.value = '';

                    const userMsg = {
                        id: 'msg-' + Date.now(),
                        isBot: false,
                        message: text,
                        time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                    };
                    botHistory.push(userMsg);
                    appendBotMessageHtml(userMsg);
                    saveBotHistory();

                    showTypingIndicator();

                    let matchedReply = "";
                    const lowerText = text.toLowerCase();
                    let showMenuAfter = true;

                    if (lowerText.includes('livre') || lowerText.includes('chercher') || lowerText.includes('trouver') || lowerText.includes('dispo') || lowerText.includes('stock')) {
                        matchedReply = "📚 **Recherche & Disponibilité des Livres**\n\n1. Allez dans l'onglet **Livres** du menu principal.\n2. Saisissez votre recherche (titre, auteur, genre) dans la barre de recherche instantanée.\n3. **Indicateur de Stock** : Si un livre affiche **0 exemplaire restant**, un bouton bleu **'Infos Prêt'** apparaît. Cliquez dessus pour voir la date de retour prévue.";
                    } else if (lowerText.includes('emprunt') || lowerText.includes('loan') || lowerText.includes('rendre') || lowerText.includes('retour') || lowerText.includes('durée')) {
                        matchedReply = "⏱️ **Règles et Durées d'Emprunts**\n\n• **Durée standard** : Un emprunt dure **14 jours**.\n• **Demande** : Cliquez sur le bouton 'Emprunter' sur la fiche du livre. L'administrateur reçoit votre demande.";
                    } else if (lowerText.includes('profil') || lowerText.includes('avatar') || lowerText.includes('photo') || lowerText.includes('modifier') || lowerText.includes('mot de passe')) {
                        matchedReply = "👤 **Gestion de votre Compte**\n\n• Pour mettre à jour vos informations, allez dans l'onglet **Mon Profil**.\n• Vous pouvez y téléverser une photo de profil personnalisée (Cloudinary) et modifier votre mot de passe.";
                    } else if (lowerText.includes('notif') || lowerText.includes('alerte') || lowerText.includes('cloche')) {
                        matchedReply = "🔔 **Notifications en Temps Réel**\n\n• **Cloche en haut à droite** : Affiche les notifications d'emprunts non lues.\n• **Toasts** : Des alertes de succès ou d'erreur s'affichent en haut à droite de votre écran lors d'actions système.";
                    } else {
                        try {
                            const res = await fetch('/chat/send', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    receiver_id: adminId,
                                    message: text
                                })
                            });
                        } catch (e) {
                            console.error(e);
                        }

                        matchedReply = "🤖 **BiblioTech AI Assistant**\n\nVotre message a bien été transmis en direct à l'administrateur ! Il pourra vous répondre directement.\n\nEn attendant, vous pouvez naviguer avec le menu ci-dessous.";
                    }

                    setTimeout(() => {
                        removeTypingIndicator();

                        const botReply = {
                            id: 'msg-' + (Date.now() + 1),
                            isBot: true,
                            message: matchedReply,
                            showOptions: showMenuAfter,
                            time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                        };
                        botHistory.push(botReply);
                        appendBotMessageHtml(botReply);
                        saveBotHistory();

                        const container = document.getElementById('widget-messages-container');
                        container.scrollTop = container.scrollHeight;
                    }, 1000);
                }

                function escapeWidgetHtml(text) {
                    if (!text) return '';
                    let escaped = text
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");

                    escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    escaped = escaped.replace(/\n/g, '<br>');
                    return escaped;
                }
            </script>
        @endif
    @endauth
</body>

</html>