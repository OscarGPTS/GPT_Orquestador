<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App Orchestrator')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-brand-red to-red-700">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">App Orchestrator</span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-yellow to-yellow-500 flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-900">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form action="{{ route('google.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-red-50 text-brand-red hover:bg-red-100 transition-colors duration-200 font-medium text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-600 text-sm">© 2025 App Orchestrator. Todos los derechos reservados.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-600 hover:text-brand-red transition-colors text-sm">Términos</a>
                    <a href="#" class="text-slate-600 hover:text-brand-red transition-colors text-sm">Privacidad</a>
                    <a href="#" class="text-slate-600 hover:text-brand-red transition-colors text-sm">Contacto</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
