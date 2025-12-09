@extends('layouts.app')
@section('title', 'Dashboard - Compras')

@section('content')
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

        <!-- Tabla de Solicitudes Pendientes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Solicitudes Pendientes
                    </h2>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $pendingApplications }} pendientes</span>
                </div>
            </div>

            @if ($pendingList->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white border-b border-slate-200">
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Proveedor</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">RFC</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Cadena</span>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Solicitado</span>
                                </th>
                                <th class="px-6 py-4 text-center">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Acción</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($pendingList as $app)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <!-- Proveedor -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-red to-red-600 flex items-center justify-center flex-shrink-0">
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

                                    <!-- Cadena -->
                                    <td class="px-6 py-4">
                                        @if ($app->approval_chain === 'normal')
                                            <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800">Normal</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold bg-purple-100 text-purple-800">Especial</span>
                                        @endif
                                    </td>

                                    <!-- Fecha -->
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div>
                                            <p class="font-medium">{{ $app->created_at->format('d/m/Y') }}</p>
                                            <p class="text-xs text-slate-500">{{ $app->created_at->format('H:i') }}</p>
                                        </div>
                                    </td>

                                    <!-- Acción -->
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('purchasing.applications.show', $app) }}" class="inline-flex items-center gap-1 bg-brand-red hover:bg-brand-red/90 text-white px-3 py-2 rounded-lg font-semibold transition-colors duration-150 text-sm">
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
                    {{ $pendingList->links() }}
                </div>

                <!-- Botón Ver Historial -->
                <div class="px-6 py-4 border-t border-slate-200 bg-white flex justify-center">
                    <a href="{{ route('purchasing.applications.index') }}" class="inline-flex items-center gap-2 bg-brand-red hover:bg-brand-red/90 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ver Historial de Solicitudes
                    </a>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-600 text-lg font-medium">No hay solicitudes pendientes</p>
                    <p class="text-slate-500 text-sm mt-2">¡Excelente! Todas las solicitudes han sido procesadas</p>
                </div>
            @endif
        </div>
</main>
@endsection
