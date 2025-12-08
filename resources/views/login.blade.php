<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - App Orchestrator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Elementos decorativos de fondo -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-red/5 rounded-full blur-3xl opacity-20 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-yellow/5 rounded-full blur-3xl opacity-20 -z-10"></div>

    <div class="w-full max-w-md z-10">
        <!-- Header con logo/marca -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-red to-red-700 shadow-2xl mb-6 transform hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">App Orchestrator</h1>
            <p class="text-slate-400 text-sm">Orquesta tus aplicaciones de manera eficiente</p>
        </div>

        <!-- Tarjeta de login -->
        <div class="bg-slate-800/50 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-700/50 p-8 md:p-10 transform hover:shadow-2xl transition-shadow duration-300">
            <!-- Título -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Bienvenido</h2>
                <p class="text-slate-400 text-sm">Inicia sesión con tu cuenta de Google para continuar</p>
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
               class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-2xl bg-gradient-to-r from-brand-red to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-2xl mb-6 group relative overflow-hidden">
                <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12 relative z-10" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-base relative z-10">Iniciar sesión con Google</span>
            </a>

            <!-- Línea divisora con texto -->
            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-600/30"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-slate-800/50 text-slate-400 text-xs uppercase tracking-wider font-semibold">Seguridad OAuth 2.0</span>
                </div>
            </div>

            <!-- Información de seguridad -->
            <div class="bg-brand-yellow/10 border border-brand-yellow/30 rounded-2xl p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-brand-yellow mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Tu información está protegida. Usamos <strong>OAuth 2.0</strong> estándar de la industria para garantizar la seguridad máxima de tus datos.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-slate-500 text-xs leading-relaxed">
                Al iniciar sesión, aceptas nuestros
                <a href="#" class="text-brand-red hover:text-red-400 transition-colors underline">Términos de Servicio</a>
                y
                <a href="#" class="text-brand-red hover:text-red-400 transition-colors underline">Política de Privacidad</a>
            </p>
        </div>

        <!-- Información adicional -->
        <div class="mt-6 text-center hidden sm:block">
            <p class="text-slate-600 text-xs flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                Conexión segura verificada
            </p>
        </div>
    </div>
</body>
</html>
