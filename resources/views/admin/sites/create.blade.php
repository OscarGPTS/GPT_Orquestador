@extends('layouts.app')
@section('title', 'Agregar Sitio')

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('sites.index') }}" class="text-brand-red hover:text-red-700 flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Sitios
            </a>
            <h1 class="text-4xl font-bold text-slate-900">Agregar Nuevo Sitio</h1>
            <p class="text-slate-600 mt-2">Completa la información del sitio a monitorear</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('sites.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">
                        Nombre del Sitio <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all"
                           placeholder="Ej: IT Satech Energy">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL -->
                <div class="mb-6">
                    <label for="url" class="block text-sm font-semibold text-slate-900 mb-2">
                        URL <span class="text-red-500">*</span>
                    </label>
                    <input type="url" 
                           id="url" 
                           name="url" 
                           value="{{ old('url') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all"
                           placeholder="https://ejemplo.com">
                    @error('url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-slate-900 mb-2">
                        Descripción
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all"
                              placeholder="Descripción breve del sitio">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Check Interval -->
                <div class="mb-6">
                    <label for="check_interval" class="block text-sm font-semibold text-slate-900 mb-2">
                        Intervalo de Verificación (segundos) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="check_interval" 
                           name="check_interval" 
                           value="{{ old('check_interval', 300) }}"
                           min="60"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all"
                           placeholder="300">
                    <p class="mt-2 text-xs text-slate-600">Mínimo 60 segundos (1 minuto)</p>
                    @error('check_interval')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mb-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-brand-red border-slate-300 rounded focus:ring-2 focus:ring-brand-red/20">
                        <span class="text-sm font-semibold text-slate-900">Sitio activo (monitorear automáticamente)</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-brand-red to-red-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                        Guardar Sitio
                    </button>
                    <a href="{{ route('sites.index') }}" 
                       class="flex-1 text-center px-6 py-3 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl transition-colors font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection
