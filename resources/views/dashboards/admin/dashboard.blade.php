@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- â”€â”€ TÃ­tulo â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Panel de Administración</h1>
        <p class="text-slate-500 mt-1">Monitoreo en tiempo real de los sistemas conectados al orquestador</p>
    </div>

    {{-- â”€â”€ Tarjetas de estadÃ­sticas â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Total --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Sistemas Totales</p>
                    <p class="text-4xl font-bold text-slate-900 mt-1">{{ $totalSites ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Operativos --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Operativos</p>
                    <p class="text-4xl font-bold text-green-600 mt-1">{{ $sitesUp ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Caidos --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Sistemas Caídos</p>
                    <p class="text-4xl font-bold mt-1 {{ ($sitesDown ?? 0) > 0 ? 'text-red-600' : 'text-slate-900' }}">
                        {{ $sitesDown ?? 0 }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl {{ ($sitesDown ?? 0) > 0 ? 'bg-red-100' : 'bg-slate-100' }} flex items-center justify-center">
                    <svg class="w-6 h-6 {{ ($sitesDown ?? 0) > 0 ? 'text-red-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Tiempo de respuesta promedio --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Resp. Promedio</p>
                    <p class="text-4xl font-bold text-slate-900 mt-1">
                        {{ $avgResponseTime ?? '--' }}<span class="text-base font-normal text-slate-400"> ms</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- â”€â”€ Tabla de estado de servicios â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8">

        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Estado de Servicios</h2>
                <p class="text-sm text-slate-500">Última verificación por sistema</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('sites.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 font-medium text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar
                </a>
                <a href="{{ route('sites.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium text-sm transition-colors">
                    Ver todos
                </a>
            </div>
        </div>

        @if($sites->isEmpty())
            <div class="px-6 py-12 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                <p class="font-medium">No hay sitios registrados</p>
                <a href="{{ route('sites.create') }}" class="text-sm text-blue-600 hover:underline mt-1 inline-block">Agregar el primero</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3">Sistema</th>
                            <th class="px-6 py-3">URL</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Tiempo de Respuesta</th>
                            <th class="px-6 py-3">Última verificación</th>
                            <th class="px-6 py-3">Intervalo</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($sites as $site)
                            @php
                                $statusColor = match($site->status) {
                                    'up'   => ['badge' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500', 'label' => 'Operativo'],
                                    'down' => ['badge' => 'bg-red-100 text-red-700',     'dot' => 'bg-red-500',   'label' => 'Caído'],
                                    default => ['badge' => 'bg-slate-100 text-slate-500', 'dot' => 'bg-slate-400', 'label' => 'Desconocido'],
                                };
                                $rtColor = 'text-slate-700';
                                if ($site->response_time !== null) {
                                    if ($site->response_time > 1000)     $rtColor = 'text-red-600 font-semibold';
                                    elseif ($site->response_time > 500)  $rtColor = 'text-yellow-600 font-semibold';
                                    else                                  $rtColor = 'text-green-700';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors {{ ! $site->is_active ? 'opacity-50' : '' }}">

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full {{ $statusColor['dot'] }} {{ $site->status === 'up' ? 'animate-pulse' : '' }}"></span>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $site->name }}</p>
                                            @if(! $site->is_active)
                                                <span class="text-xs text-slate-400">(mantenimiento)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ $site->url }}" target="_blank"
                                       class="text-blue-600 hover:underline block max-w-[200px] truncate"
                                       title="{{ $site->url }}">
                                        {{ $site->url }}
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor['badge'] }}">
                                        {{ $statusColor['label'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($site->response_time !== null)
                                        <span class="font-mono {{ $rtColor }}">{{ number_format($site->response_time) }} ms</span>
                                    @else
                                        <span class="text-slate-300">â€”</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                    @if($site->last_checked_at)
                                        <span title="{{ $site->last_checked_at->format('d/m/Y H:i:s') }}">
                                            {{ $site->last_checked_at->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="text-slate-300">Sin verificar</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    @php $mins = ($site->check_interval ?? 300) / 60 @endphp
                                    {{ $mins >= 60 ? round($mins / 60).'h' : (int)$mins.' min' }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <form method="POST" action="{{ route('sites.check', $site) }}">
                                            @csrf
                                            <button type="submit" title="Verificar ahora"
                                                    class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('sites.edit', $site) }}" title="Editar"
                                           class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- â”€â”€ Accesos rÃ¡pidos â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('sites.index') }}"
           class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-blue-300 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Gestionar Sitios</p>
                <p class="text-sm text-slate-500">Ver, editar y eliminar sitios</p>
            </div>
        </a>

        <a href="{{ route('sites.create') }}"
           class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-green-300 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-slate-900 group-hover:text-green-600 transition-colors">Agregar Sistema</p>
                <p class="text-sm text-slate-500">Conectar nuevo servicio</p>
            </div>
        </a>

        <button onclick="location.reload()"
                class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-yellow-300 transition-all group flex items-center gap-4 w-full text-left">
            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-slate-900 group-hover:text-yellow-600 transition-colors">Refrescar</p>
                <p class="text-sm text-slate-500">Actualizar estado actual</p>
            </div>
        </button>
    </div>

</main>
@endsection
