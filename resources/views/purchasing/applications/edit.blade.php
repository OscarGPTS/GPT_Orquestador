@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-slate-900">Revisión de Solicitud</h1>
            <p class="text-slate-600 mt-2">{{ $application->company_name }}</p>
        </div>

        <!-- Información resumida -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-6 border-b border-slate-200">
                <div>
                    <p class="text-sm text-slate-600 font-semibold">RFC</p>
                    <p class="text-slate-900 mt-1 font-mono">{{ $application->rfc }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">CLABE</p>
                    <p class="text-slate-900 mt-1 font-mono">{{ $application->bank_account_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Fecha</p>
                    <p class="text-slate-900 mt-1">{{ $application->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Tabs para las acciones -->
        <div class="space-y-6">
            <!-- Pestaña: Aprobar -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#CF0A2C] to-[#F9BE00] px-6 py-4 text-white font-bold">
                    ✓ Aprobar Solicitud
                </div>
                <form action="{{ route('purchasing.applications.approve', $application) }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Cadena de aprobación -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700 block mb-3">
                            Selecciona la cadena de aprobación *
                        </label>
                        <div class="space-y-3">
                            @foreach ($approvalChains as $key => $label)
                                <label class="flex items-start p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition" :key="$key">
                                    <input type="radio" name="approval_chain" value="{{ $key }}" required class="mt-1 w-4 h-4 text-[#CF0A2C] cursor-pointer" />
                                    <div class="ml-3">
                                        <p class="font-semibold text-slate-900">{{ $label }}</p>
                                        @if ($key === 'normal')
                                            <p class="text-sm text-slate-600 mt-1">Aprobación estándar para proveedores convencionales</p>
                                        @elseif ($key === 'special')
                                            <p class="text-sm text-slate-600 mt-1">Requiere revisión adicional o cumple requisitos especiales</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('approval_chain')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Notas (opcional)</label>
                        <textarea name="notes" rows="4" placeholder="Agrega notas sobre la aprobación..." class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]"></textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Aprobar Solicitud
                    </button>
                </form>
            </div>

            <!-- Pestaña: Rechazar -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-red-600 px-6 py-4 text-white font-bold">
                    ✕ Rechazar Solicitud
                </div>
                <form action="{{ route('purchasing.applications.reject', $application) }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Cadena de aprobación -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700 block mb-3">
                            Selecciona la cadena de aprobación *
                        </label>
                        <div class="space-y-3">
                            @foreach ($approvalChains as $key => $label)
                                <label class="flex items-start p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition" :key="$key">
                                    <input type="radio" name="approval_chain" value="{{ $key }}" required class="mt-1 w-4 h-4 text-red-600 cursor-pointer" />
                                    <div class="ml-3">
                                        <p class="font-semibold text-slate-900">{{ $label }}</p>
                                        @if ($key === 'normal')
                                            <p class="text-sm text-slate-600 mt-1">Rechazo estándar - No cumple requisitos básicos</p>
                                        @elseif ($key === 'special')
                                            <p class="text-sm text-slate-600 mt-1">Rechazo especial - Requiere análisis específico</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('approval_chain')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Motivo del rechazo -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Motivo del rechazo *</label>
                        <textarea name="rejection_reason" rows="4" required placeholder="Explica el motivo del rechazo..." class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600/20 focus:border-red-600"></textarea>
                        @error('rejection_reason')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        Rechazar Solicitud
                    </button>
                </form>
            </div>
        </div>

        <!-- Botón para volver -->
        <div class="mt-8">
            <a href="{{ route('purchasing.applications.show', $application) }}" class="text-slate-600 hover:text-slate-900 font-semibold">
                ← Volver a detalles
            </a>
        </div>
    </div>
</div>
@endsection
