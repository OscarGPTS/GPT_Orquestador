<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sitios - App Orchestrator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-brand-red to-red-700">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">App Orchestrator</span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-brand-red transition-colors">Dashboard</a>
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-yellow to-yellow-500 flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-900">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('google.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-red-50 text-brand-red hover:bg-red-100 transition-colors duration-200 font-medium text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Gestión de Sitios</h1>
                <p class="text-slate-600 mt-2">Monitorea el estado de tus aplicaciones</p>
            </div>
            <a href="{{ route('sites.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-brand-red to-red-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar Sitio
            </a>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Sites Grid -->
        @if($sites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sites as $site)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-300">
                        <!-- Status Badge -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($site->status === 'up') bg-green-100 text-green-700
                                @elseif($site->status === 'down') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                @if($site->status === 'up') ✓ Operativo
                                @elseif($site->status === 'down') ✗ Caído
                                @else ? Desconocido
                                @endif
                            </span>
                            <span class="text-xs text-slate-500">
                                @if($site->is_active)
                                    <span class="inline-flex items-center text-green-600">
                                        <span class="w-2 h-2 bg-green-600 rounded-full mr-1"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-slate-400">
                                        <span class="w-2 h-2 bg-slate-400 rounded-full mr-1"></span> Inactivo
                                    </span>
                                @endif
                            </span>
                        </div>

                        <!-- Site Info -->
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $site->name }}</h3>
                        <a href="{{ $site->url }}" target="_blank" class="text-sm text-brand-red hover:underline mb-3 block truncate">
                            {{ $site->url }}
                        </a>
                        
                        @if($site->description)
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $site->description }}</p>
                        @endif

                        <!-- Metrics -->
                        <div class="flex items-center gap-4 mb-4 text-sm text-slate-600">
                            @if($site->response_time)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $site->response_time }}ms
                                </div>
                            @endif
                            @if($site->last_checked_at)
                                <div class="flex items-center gap-1 text-xs">
                                    Revisado: {{ $site->last_checked_at->diffForHumans() }}
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                            <form action="{{ route('sites.check', $site) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors">
                                    Verificar
                                </button>
                            </form>
                            <a href="{{ route('sites.edit', $site) }}" 
                               class="flex-1 text-center px-3 py-2 bg-slate-50 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-medium transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('sites.destroy', $site) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-medium transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">No hay sitios registrados</h3>
                <p class="text-slate-600 mb-6">Comienza agregando tu primer sitio para monitorear</p>
                <a href="{{ route('sites.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-brand-red to-red-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Primer Sitio
                </a>
            </div>
        @endif
    </main>
</body>
</html>
