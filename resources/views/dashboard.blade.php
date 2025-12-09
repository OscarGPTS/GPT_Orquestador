<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - App Orchestrator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-brand-red to-red-700">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">App Orchestrator</span>
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-yellow to-yellow-500 flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-900">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <form action="{{ route('google.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-red-50 text-brand-red hover:bg-red-100 transition-colors duration-200 font-medium text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-2">
                Bienvenido, <span class="bg-gradient-to-r from-brand-red to-red-600 bg-clip-text text-transparent">{{ auth()->user()->name }}</span>
            </h1>
            <p class="text-slate-600 text-lg">Aquí puedes gestionar todas tus aplicaciones orquestadas</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Aplicaciones Activas</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Tareas en Ejecución</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Errores Recientes</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Tiempo de Actividad</p>
                        <p class="text-3xl font-bold text-slate-900 mt-2">100%</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @extends('layouts.app')
        @section('title', 'Dashboard')

        @section('content')
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Información de Cuenta</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-600 font-medium mb-1">Nombre</p>
                            <p class="text-slate-900 font-semibold">{{ auth()->user()->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-600 font-medium mb-1">Email</p>
                            <p class="text-slate-900 font-semibold break-all">{{ auth()->user()->email }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-600 font-medium mb-1">Miembro desde</p>
                            <p class="text-slate-900 font-semibold">{{ auth()->user()->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-sm text-slate-600 font-medium mb-2">Estado</p>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="text-sm text-green-600 font-semibold">En línea</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documentation Link -->
                <div class="bg-gradient-to-br from-brand-yellow/10 to-yellow-100/5 rounded-2xl border border-brand-yellow/30 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-3">¿Necesitas Ayuda?</h3>
                    <p class="text-slate-600 text-sm mb-4">Consulta nuestra documentación para aprender más sobre cómo usar App Orchestrator.</p>
                    <a href="#" class="inline-flex items-center gap-2 text-brand-red hover:text-red-700 font-semibold text-sm transition-colors">
                        Ver documentación
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
</main>
@endsection
