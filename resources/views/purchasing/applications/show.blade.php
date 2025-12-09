@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-slate-900">Detalle de Solicitud</h1>
                <p class="text-slate-600 mt-2">{{ $application->company_name }} • RFC: <span class="font-mono">{{ $application->rfc }}</span></p>
            </div>
            <a href="{{ route('purchasing.applications.index') }}" class="text-[#CF0A2C] hover:text-[#CF0A2C]/70 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver
            </a>
        </div>

        <!-- Estado actual -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-slate-600 font-semibold uppercase tracking-wider">Estado</p>
                    <p class="text-lg mt-2">
                        @if ($application->status === 'pending')
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 rounded-full bg-yellow-600 animate-pulse"></span>
                                Pendiente
                            </span>
                        @elseif ($application->status === 'approved')
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                Aprobado
                            </span>
                        @elseif ($application->status === 'rejected')
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                Rechazado
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold uppercase tracking-wider">Cadena</p>
                    <p class="text-lg mt-2">
                        @if ($application->approval_chain === 'normal')
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">Normal</span>
                        @elseif ($application->approval_chain === 'special')
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">Especial</span>
                        @else
                            <span class="text-slate-600 text-sm">—</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold uppercase tracking-wider">Solicitud</p>
                    <p class="text-lg mt-2 text-slate-900 font-medium">{{ $application->created_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-slate-500">{{ $application->created_at->format('H:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold uppercase tracking-wider">Última actualización</p>
                    <p class="text-lg mt-2 text-slate-900 font-medium">{{ $application->updated_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-slate-500">{{ $application->updated_at->format('H:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información de la solicitud (2 columnas) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Información general -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información General
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">RFC</p>
                            <p class="text-slate-900 mt-2 font-mono font-bold">{{ $application->rfc }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">Razón Social</p>
                            <p class="text-slate-900 mt-2 font-semibold">{{ $application->company_name }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">Domicilio</p>
                            <p class="text-slate-900 mt-2">
                                {{ $application->street }} #{{ $application->number }}<br>
                                {{ $application->neighborhood }}, {{ $application->municipality }}<br>
                                {{ $application->state }}, {{ $application->country }}
                                @if ($application->cp)
                                    <br>CP: {{ $application->cp }}
                                @endif
                            </p>
                        </div>
                        @if ($application->web_company)
                            <div class="md:col-span-2">
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">Sitio Web</p>
                                <p class="text-slate-900 mt-2">
                                    <a href="{{ $application->web_company }}" target="_blank" class="text-[#CF0A2C] hover:underline font-medium">{{ $application->web_company }} ↗</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información bancaria -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información Bancaria
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($application->bank)
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">Banco</p>
                                <p class="text-slate-900 mt-2 font-semibold">{{ $application->bank }}</p>
                            </div>
                        @endif
                        @if ($application->bank_account)
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">Cuenta</p>
                                <p class="text-slate-900 mt-2 font-mono">{{ $application->bank_account }}</p>
                            </div>
                        @endif
                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-600 font-semibold uppercase tracking-wider">CLABE Interbancaria</p>
                            <p class="text-slate-900 mt-2 font-mono font-bold tracking-wider">{{ $application->bank_account_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Documentos con Preview -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Documentos Adjuntos
                    </h2>
                    
                    @if ($application->bank_data_file_path || $application->tax_certificate_file_path)
                        <div class="space-y-4">
                            <!-- Documento 1: Datos Bancarios -->
                            @if ($application->bank_data_file_path)
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between cursor-pointer" onclick="togglePreview('bank-data-preview')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 3a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V3z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">Hoja de Datos Bancarios</p>
                                                <p class="text-xs text-slate-600">PDF</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-slate-600 transform transition-transform" id="bank-data-toggle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="bank-data-preview" class="hidden bg-white p-4">
                                        <div class="bg-slate-100 rounded-lg p-4 mb-4" style="height: 400px; overflow: auto;">
                                            <embed src="{{ asset('storage/' . $application->bank_data_file_path) }}" type="application/pdf" width="100%" height="100%">
                                        </div>
                                        <a href="{{ route('purchasing.applications.download', [$application, 'bank_data']) }}" class="inline-flex items-center gap-2 bg-[#CF0A2C] hover:bg-[#CF0A2C]/90 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Documento 2: Constancia Fiscal -->
                            @if ($application->tax_certificate_file_path)
                                <div class="border border-slate-200 rounded-lg overflow-hidden">
                                    <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between cursor-pointer" onclick="togglePreview('tax-cert-preview')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 3a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V3z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">Constancia de Situación Fiscal</p>
                                                <p class="text-xs text-slate-600">PDF</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-slate-600 transform transition-transform" id="tax-cert-toggle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="tax-cert-preview" class="hidden bg-white p-4">
                                        <div class="bg-slate-100 rounded-lg p-4 mb-4" style="height: 400px; overflow: auto;">
                                            <embed src="{{ asset('storage/' . $application->tax_certificate_file_path) }}" type="application/pdf" width="100%" height="100%">
                                        </div>
                                        <a href="{{ route('purchasing.applications.download', [$application, 'tax_certificate']) }}" class="inline-flex items-center gap-2 bg-[#CF0A2C] hover:bg-[#CF0A2C]/90 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-slate-600 font-medium">No hay documentos adjuntos</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Panel de decisión (1 columna) -->
            <div>
                @if ($application->status === 'pending')
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Decisión
                        </h3>
                        
                        <form id="decisionForm" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Cadena de aprobación -->
                            <div>
                                <label class="text-sm font-semibold text-slate-700 mb-3 block">Cadena de Aprobación *</label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#CF0A2C] has-[:checked]:bg-red-50">
                                        <input type="radio" name="approval_chain" value="normal" class="w-4 h-4 text-[#CF0A2C]" required>
                                        <div>
                                            <p class="font-semibold text-slate-900 text-sm">Normal</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-[#CF0A2C] has-[:checked]:bg-red-50">
                                        <input type="radio" name="approval_chain" value="special" class="w-4 h-4 text-[#CF0A2C]" required>
                                        <div>
                                            <p class="font-semibold text-slate-900 text-sm">Especial</p>
                                        </div>
                                    </label>
                                </div>
                            </div>


                            <!-- Botones -->
                            <div class="space-y-3 pt-4 border-t border-slate-200">
                                <button type="button" onclick="submitDecision('approve')" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Aprobar
                                </button>
                                
                                <button type="button" onclick="submitDecision('reject')" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Rechazar
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif ($application->status === 'approved')
                    <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 sticky top-8">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-green-900 mb-2">Aprobada</h3>
                                <p class="text-green-800 text-sm mb-4">{{ $application->updated_at->format('d/m/Y \a \l\a\s H:i A') }}</p>
                                @if ($application->approval_notes)
                                    <div class="bg-white rounded p-3 mt-3">
                                        <p class="text-xs font-semibold text-slate-700 mb-1">Notas:</p>
                                        <p class="text-sm text-slate-900">{{ $application->approval_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif ($application->status === 'rejected')
                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6 sticky top-8">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-red-900 mb-2">Rechazada</h3>
                                <p class="text-red-800 text-sm mb-4">{{ $application->updated_at->format('d/m/Y \a \l\a\s H:i A') }}</p>
                                @if ($application->rejection_reason)
                                    <div class="bg-white rounded p-3 mt-3">
                                        <p class="text-xs font-semibold text-slate-700 mb-1">Motivo:</p>
                                        <p class="text-sm text-slate-900">{{ $application->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function togglePreview(id) {
        const element = document.getElementById(id);
        const toggle = element.previousElementSibling.querySelector('[id*="-toggle"]');
        element.classList.toggle('hidden');
        toggle.style.transform = element.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    function submitDecision(action) {
        const form = document.getElementById('decisionForm');
        const chain = form.querySelector('[name="approval_chain"]:checked');
        
        if (!chain) {
            alert('Por favor selecciona una cadena de aprobación');
            return;
        }
        
        if (action === 'reject' && !confirm('¿Estás seguro de rechazar esta solicitud?')) {
            return;
        }
        
        if (action === 'approve') {
            form.action = "{{ route('purchasing.applications.approve', $application) }}";
        } else {
            form.action = "{{ route('purchasing.applications.reject', $application) }}";
        }
        
        form.submit();
    }
</script>
@endsection
