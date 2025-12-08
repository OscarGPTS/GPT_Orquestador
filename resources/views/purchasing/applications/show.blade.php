@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-slate-900">Detalle de Solicitud</h1>
                <p class="text-slate-600 mt-2">{{ $application->company_name }} ({{ $application->rfc }})</p>
            </div>
            <a href="{{ route('purchasing.applications.index') }}" class="text-[#CF0A2C] hover:text-[#CF0A2C]/70 font-semibold">← Volver</a>
        </div>

        <!-- Estado actual -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Estado</p>
                    <p class="text-lg mt-2">
                        @if ($application->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 rounded-full bg-yellow-600"></span>
                                Pendiente
                            </span>
                        @elseif ($application->status === 'approved')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                Aprobado
                            </span>
                        @elseif ($application->status === 'rejected')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                Rechazado
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Cadena de Aprobación</p>
                    <p class="text-lg mt-2">
                        @if ($application->approval_chain === 'normal')
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">Normal</span>
                        @elseif ($application->approval_chain === 'special')
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">Especial</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Fecha de solicitud</p>
                    <p class="text-lg mt-2 text-slate-900">{{ $application->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Información general -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Información General
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-slate-600 font-semibold">RFC</p>
                    <p class="text-slate-900 mt-1">{{ $application->rfc }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Razón Social</p>
                    <p class="text-slate-900 mt-1">{{ $application->company_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-semibold">Domicilio</p>
                    <p class="text-slate-900 mt-1">
                        {{ $application->street }} #{{ $application->number }}, {{ $application->neighborhood }}<br>
                        {{ $application->municipality }}, {{ $application->state }}, {{ $application->country }}
                        @if ($application->cp)
                            {{ $application->cp }}
                        @endif
                    </p>
                </div>
                @if ($application->web_company)
                    <div>
                        <p class="text-sm text-slate-600 font-semibold">Sitio Web</p>
                        <p class="text-slate-900 mt-1">
                            <a href="{{ $application->web_company }}" target="_blank" class="text-[#CF0A2C] hover:underline">{{ $application->web_company }}</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información bancaria -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Información Bancaria
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($application->bank)
                    <div>
                        <p class="text-sm text-slate-600 font-semibold">Banco</p>
                        <p class="text-slate-900 mt-1">{{ $application->bank }}</p>
                    </div>
                @endif
                @if ($application->bank_account)
                    <div>
                        <p class="text-sm text-slate-600 font-semibold">Cuenta Bancaria</p>
                        <p class="text-slate-900 mt-1">{{ $application->bank_account }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-slate-600 font-semibold">CLABE</p>
                    <p class="text-slate-900 mt-1 font-mono">{{ $application->bank_account_number }}</p>
                </div>
            </div>
        </div>

        <!-- Documentos -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Documentos
            </h2>
            <div class="space-y-3">
                @if ($application->bank_data_file_path)
                    <a href="{{ route('purchasing.applications.download', [$application, 'bank_data']) }}" class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-[#CF0A2C]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm3 0a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm3 0a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm-9-7a1 1 0 01-1-1V7a1 1 0 012 0v1a1 1 0 01-1 1zM4 5a2 2 0 012-2h6a2 2 0 012 2v1a1 1 0 110 2H4a1 1 0 110-2V5z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-slate-900">Hoja de datos bancarios</p>
                                <p class="text-sm text-slate-600">PDF</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                @endif

                @if ($application->tax_certificate_file_path)
                    <a href="{{ route('purchasing.applications.download', [$application, 'tax_certificate']) }}" class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200 hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-[#CF0A2C]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm3 0a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm3 0a1 1 0 01-1-1V9a1 1 0 012 0v6.5a1 1 0 01-1 1zm-9-7a1 1 0 01-1-1V7a1 1 0 012 0v1a1 1 0 01-1 1zM4 5a2 2 0 012-2h6a2 2 0 012 2v1a1 1 0 110 2H4a1 1 0 110-2V5z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-slate-900">Constancia de situación fiscal</p>
                                <p class="text-sm text-slate-600">PDF</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Formulario de decisión -->
        @if ($application->status === 'pending')
            <div class="bg-white rounded-lg shadow-md p-6 border-2 border-slate-200">
                <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Decisión de Solicitud
                </h3>
                
                <form id="decisionForm" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Cadena de aprobación -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-3 block">Cadena de Aprobación *</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="approval_chain" value="normal" class="w-4 h-4 text-[#CF0A2C]" required>
                                <div>
                                    <p class="font-semibold text-slate-900">Normal</p>
                                    <p class="text-xs text-slate-600">Aprobación estándar de proveedores</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="approval_chain" value="special" class="w-4 h-4 text-[#CF0A2C]" required>
                                <div>
                                    <p class="font-semibold text-slate-900">Especial</p>
                                    <p class="text-xs text-slate-600">Requiere revisión adicional</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Notas / Motivo -->
                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block">Notas o Motivo</label>
                        <textarea name="notes" rows="4" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" placeholder="Agrega comentarios, notas de aprobación o motivo de rechazo..."></textarea>
                        <p class="text-xs text-slate-500 mt-1">Este campo es opcional para aprobaciones pero obligatorio para rechazos</p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                        <button type="button" onclick="submitDecision('approve')" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Aprobar Proveedor
                        </button>
                        
                        <button type="button" onclick="submitDecision('reject')" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Rechazar Proveedor
                        </button>
                    </div>
                </form>
            </div>

            <script>
                function submitDecision(action) {
                    const form = document.getElementById('decisionForm');
                    const notes = form.querySelector('[name="notes"]').value.trim();
                    const chain = form.querySelector('[name="approval_chain"]:checked');
                    
                    // Validar que se haya seleccionado cadena
                    if (!chain) {
                        alert('Por favor selecciona una cadena de aprobación');
                        return;
                    }
                    
                    // Validar notas para rechazo
                    if (action === 'reject' && !notes) {
                        alert('El motivo del rechazo es obligatorio');
                        return;
                    }
                    
                    // Confirmar rechazo
                    if (action === 'reject' && !confirm('¿Estás seguro de rechazar esta solicitud?')) {
                        return;
                    }
                    
                    // Cambiar la acción del formulario
                    if (action === 'approve') {
                        form.action = "{{ route('purchasing.applications.approve', $application) }}";
                        // Renombrar campo notes a approval_notes
                        form.querySelector('[name="notes"]').name = 'approval_notes';
                    } else {
                        form.action = "{{ route('purchasing.applications.reject', $application) }}";
                        // Renombrar campo notes a rejection_reason
                        form.querySelector('[name="notes"]').name = 'rejection_reason';
                    }
                    
                    form.submit();
                }
            </script>
        @elseif ($application->status === 'approved')
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-green-900 mb-1">Solicitud Aprobada</h3>
                        <p class="text-green-800 text-sm">Esta solicitud fue aprobada el {{ $application->updated_at->format('d/m/Y H:i') }}</p>
                        @if ($application->approval_notes)
                            <p class="text-green-800 text-sm mt-2"><strong>Notas:</strong> {{ $application->approval_notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @elseif ($application->status === 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-900 mb-1">Solicitud Rechazada</h3>
                        <p class="text-red-800 text-sm">Esta solicitud fue rechazada el {{ $application->updated_at->format('d/m/Y H:i') }}</p>
                        @if ($application->rejection_reason)
                            <p class="text-red-800 text-sm mt-2"><strong>Motivo:</strong> {{ $application->rejection_reason }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
