@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-slate-900">Solicitudes de Proveedores</h1>
                    <p class="text-slate-600 mt-2">Gestión y revisión de solicitudes pendientes y procesadas</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-[#CF0A2C]">{{ $applications->total() }}</p>
                    <p class="text-slate-600 text-sm">Total solicitudes</p>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('purchasing.applications.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Búsqueda -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Buscar (RFC o empresa)</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ej: ABC123456XYZ" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Estado</label>
                        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]">
                            <option value="">Todos</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <!-- Cadena de aprobación -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Cadena de Aprobación</label>
                        <select name="approval_chain" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]">
                            <option value="">Todos</option>
                            <option value="normal" {{ request('approval_chain') === 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="special" {{ request('approval_chain') === 'special' ? 'selected' : '' }}>Especial</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-[#CF0A2C] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#CF0A2C]/90 transition">
                            Filtrar
                        </button>
                        <a href="{{ route('purchasing.applications.index') }}" class="flex-1 bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-semibold hover:bg-slate-400 transition text-center">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Mensajes de éxito -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de solicitudes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if ($applications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Proveedor</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">RFC</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Estado</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Cadena</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Fecha</span>
                                </th>
                                <th class="px-6 py-4 text-center">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($applications as $app)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <!-- Proveedor -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#CF0A2C] to-red-600 flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold text-sm">{{ substr($app->company_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">{{ $app->company_name }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- RFC -->
                                    <td class="px-6 py-4 text-sm font-mono text-slate-700">
                                        {{ $app->rfc }}
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-4">
                                        @if ($app->status === 'pending')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 rounded-full bg-yellow-600 animate-pulse"></span>
                                                Pendiente
                                            </span>
                                        @elseif ($app->status === 'approved')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                                Aprobado
                                            </span>
                                        @elseif ($app->status === 'rejected')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                                Rechazado
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Cadena -->
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        @if ($app->approval_chain === 'normal')
                                            <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800">Normal</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold bg-purple-100 text-purple-800">Especial</span>
                                        @endif
                                    </td>

                                    <!-- Fecha -->
                                    <td class="px-6 py-4 text-sm text-slate-600 hidden lg:table-cell">
                                        <div>
                                            <p class="font-medium">{{ $app->created_at->format('d/m/Y') }}</p>
                                            <p class="text-xs text-slate-500">{{ $app->created_at->format('H:i') }}</p>
                                        </div>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('purchasing.applications.show', $app) }}" class="inline-flex items-center gap-1 bg-[#CF0A2C] hover:bg-[#CF0A2C]/90 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-150 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Ver</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-600 text-lg font-medium">No hay solicitudes</p>
                    <p class="text-slate-500 text-sm mt-2">Intenta con diferentes filtros o criterios de búsqueda</p>
                </div>
            @endif
        </div>

        <!-- Resumen de estadísticas -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-slate-600 text-sm font-medium">Total</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ $applications->total() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-slate-600 text-sm font-medium">Pendientes</p>
                <p class="text-2xl font-bold text-yellow-600 mt-2">{{ \App\Models\ProviderApplication::where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-slate-600 text-sm font-medium">Aprobadas</p>
                <p class="text-2xl font-bold text-green-600 mt-2">{{ \App\Models\ProviderApplication::where('status', 'approved')->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <p class="text-slate-600 text-sm font-medium">Rechazadas</p>
                <p class="text-2xl font-bold text-red-600 mt-2">{{ \App\Models\ProviderApplication::where('status', 'rejected')->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
