@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-slate-900">Gestión de Solicitudes de Proveedores</h1>
            <p class="text-slate-600 mt-2">Revisa y aprueba las solicitudes de nuevos proveedores</p>
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
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cadena de aprobación -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Cadena de Aprobación</label>
                        <select name="approval_chain" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]">
                            <option value="">Todos</option>
                            @foreach ($approvalChains as $key => $label)
                                <option value="{{ $key }}" {{ request('approval_chain') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
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
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">RFC</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Empresa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Estado</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Cadena</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Fecha</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($applications as $app)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-sm font-mono text-slate-900">{{ $app->rfc }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-900">{{ $app->company_name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($app->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 rounded-full bg-yellow-600"></span>
                                                Pendiente
                                            </span>
                                        @elseif ($app->status === 'approved')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                                Aprobado
                                            </span>
                                        @elseif ($app->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                                Rechazado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($app->approval_chain === 'normal')
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Normal</span>
                                        @elseif ($app->approval_chain === 'special')
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Especial</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $app->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('purchasing.applications.show', $app) }}" class="inline-block bg-[#CF0A2C] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#CF0A2C]/90 transition text-sm">
                                            @if ($app->status === 'pending')
                                                Ver y Decidir
                                            @else
                                                Ver Detalle
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-600 text-lg">No hay solicitudes que coincidan con los filtros</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
