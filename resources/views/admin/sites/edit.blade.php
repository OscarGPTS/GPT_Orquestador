<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sitio - App Orchestrator</title>
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('sites.index') }}" class="text-brand-red hover:text-red-700 flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Sitios
            </a>
            <h1 class="text-4xl font-bold text-slate-900">Editar Sitio</h1>
            <p class="text-slate-600 mt-2">Actualiza la información del sitio</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('sites.update', $site) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">
                        Nombre del Sitio <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $site->name) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all">
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
                           value="{{ old('url', $site->url) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all">
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
                              class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all">{{ old('description', $site->description) }}</textarea>
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
                           value="{{ old('check_interval', $site->check_interval) }}"
                           min="60"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all">
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
                               {{ old('is_active', $site->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-brand-red border-slate-300 rounded focus:ring-2 focus:ring-brand-red/20">
                        <span class="text-sm font-semibold text-slate-900">Sitio activo (monitorear automáticamente)</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-brand-red to-red-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                        Actualizar Sitio
                    </button>
                    <a href="{{ route('sites.index') }}" 
                       class="flex-1 text-center px-6 py-3 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl transition-colors font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
