<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Seguro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-white via-slate-50 to-slate-100 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Elementos de fondo sutiles -->
    <div class="absolute -top-20 -right-10 w-64 h-64 bg-[#CF0A2C]/10 rounded-full blur-3xl opacity-60 -z-10"></div>
    <div class="absolute -bottom-24 -left-8 w-72 h-72 bg-[#F9BE00]/10 rounded-full blur-3xl opacity-60 -z-10"></div>

    <div class="w-full max-w-md z-10">
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8 md:p-10">
            <!-- Header con logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center mb-6">
                    <img src="{{ asset('assets/img/logo_gpt.svg') }}" alt="Logo" class="h-14 w-auto drop-shadow-md">
                </div>
                <p class="text-slate-600 text-sm">Acceso con cuenta corporativa</p>
            </div>

            <!-- Título -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">Iniciar sesión</h2>
                <p class="text-slate-500 text-sm">Usa tu cuenta de Google autorizada.</p>
            </div>

            <!-- Mensajes de estado -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl animate-pulse">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-400 text-sm font-medium">
                            {{ $errors->first() }}
                        </p>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 rounded-2xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-400 text-sm font-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-400 text-sm font-medium">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Botón de Google OAuth -->
            <a href="{{ route('google.redirect') }}" 
               class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-2xl bg-[#CF0A2C] hover:bg-[#b30a25] text-white font-semibold transition-all duration-200 shadow-lg hover:shadow-xl mb-6">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-base">Continuar con Google</span>
            </a>

        </div>
    </div>
</body>
</html>
