<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Compras | App Orchestrator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-brand-red to-red-700">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">App Orchestrator</span>
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-yellow to-yellow-500 flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-900">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">Compras</p>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">
                Dashboard de <span class="bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">Compras</span>
            </h1>
            <p class="text-slate-600 text-lg">Gestión de solicitudes de proveedores</p>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total de solicitudes -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total de Solicitudes</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalApplications }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pendientes -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pendientes</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingApplications }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Aprobadas -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Aprobadas</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $approvedApplications }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Rechazadas -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Rechazadas</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $rejectedApplications }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cadenas de aprobación -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Cadena Normal -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cadena Normal</h3>
                <div class="flex items-center">
                    <p class="text-3xl font-bold text-indigo-600">{{ $normalChain }}</p>
                    <p class="text-gray-600 text-sm ml-3">solicitudes</p>
                </div>
                <p class="text-gray-500 text-sm mt-2">Aprobación estándar de proveedores</p>
            </div>

            <!-- Cadena Especial -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cadena Especial</h3>
                <div class="flex items-center">
                    <p class="text-3xl font-bold text-purple-600">{{ $specialChain }}</p>
                    <p class="text-gray-600 text-sm ml-3">solicitudes</p>
                </div>
                <p class="text-gray-500 text-sm mt-2">Aprobación con requisitos adicionales</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Solicitudes Pendientes -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-yellow-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Solicitudes Pendientes</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentPending as $application)
                        <a href="{{ route('purchasing.applications.show', ['application' => $application]) }}" class="block px-6 py-4 hover:bg-yellow-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $application->company_name }}</p>
                                    <p class="text-xs text-gray-600 mt-1">RFC: {{ $application->rfc }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Cadena: <span class="font-medium">{{ ucfirst($application->approval_chain) }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-600">{{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <p class="text-gray-500 text-sm">No hay solicitudes pendientes</p>
                        </div>
                    @endforelse
                </div>
                @if($pendingApplications > 0)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <a href="{{ route('purchasing.applications.index', ['status' => 'pending']) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                            Ver todas las pendientes →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Solicitudes Procesadas Recientemente -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Procesadas Recientemente</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentProcessed as $application)
                        <a href="{{ route('purchasing.applications.show', ['application' => $application]) }}" class="block px-6 py-4 hover:bg-blue-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $application->company_name }}</p>
                                    <p class="text-xs text-gray-600 mt-1">RFC: {{ $application->rfc }}</p>
                                    <div class="mt-1">
                                        @if($application->status === 'approved')
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Aprobada</span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Rechazada</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-600">{{ $application->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <p class="text-gray-500 text-sm">No hay solicitudes procesadas</p>
                        </div>
                    @endforelse
                </div>
                @if($rejectedApplications + $approvedApplications > 0)
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <a href="{{ route('purchasing.applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                            Ver todas las solicitudes →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('purchasing.applications.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    Ver todas las solicitudes
                </a>
                <a href="{{ route('purchasing.applications.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-medium">
                    Solicitudes pendientes
                </a>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                    Ir al dashboard principal
                </a>
            </div>
        </div>
    </main>

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
