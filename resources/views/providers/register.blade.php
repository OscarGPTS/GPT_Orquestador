<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Proveedores - GPT Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 min-h-screen">
    <!-- Top Black Bar with Logo -->
    <header class="bg-black py-4 px-4 sm:px-6 lg:px-10 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-cente    r gap-3">
                <svg class="h-10 w-auto" viewBox="0 0 162.9 66.2" xmlns="http://www.w3.org/2000/svg">
                    <style>.st0{fill:#CF0A2C;}.st1{fill:#F9BE00;}</style>
                    <g>
                        <path class="st0" d="M148.7,3l-7.3,9.5h-13.1v27H117v-27h-11.7c-0.2-0.7-0.5-1.5-0.8-2.2c-0.9-2-2.3-3.6-4-5c-1.2-1-2.6-1.7-4-2.3H148.7z"/>
                        <path class="st0" d="M15.6,15.7c-0.6,0.6-1.1,1.3-1.5,2.1c-0.5,1.1-0.8,2.3-0.8,3.6c0,1.3,0.3,2.5,0.8,3.6c0.5,1.1,1.3,2,2.2,2.8c1,0.8,2.1,1.4,3.4,1.8c1.3,0.4,2.8,0.6,4.3,0.6h13.8v-5.3H19l6.8-8.1h23.4v22.8H24.1c-3.2,0-6.1-0.5-8.8-1.4c-2.7-0.9-5-2.2-7-3.9c-1.9-1.7-3.5-3.6-4.6-5.9c-0.3-0.5-0.5-1-0.7-1.6c0.2-0.5,0.4-1,0.7-1.5c1.1-2.2,2.6-4.1,4.6-5.7c1.9-1.6,4.3-2.8,7-3.7C15.4,15.8,15.5,15.8,15.6,15.7"/>
                        <path class="st0" d="M104,16.7c0,2-0.4,3.9-1.2,5.5c-0.8,1.7-2,3.1-3.5,4.2c-1.5,1.2-3.4,2.1-5.7,2.7c-2.2,0.7-4.8,1-7.6,1H66.9v9.3H55.6V20.8h31.5c1.7,0,3.1-0.4,4.1-1.1c1-0.8,1.4-1.8,1.4-3.1s-0.5-2.3-1.4-3c-1-0.7-2.3-1.1-4.1-1.1c-21,0-42,0-63,0c-5.9,0-12.4,1.8-17,5.5c-2,1.6-3.6,3.5-4.8,5.8c-0.2-0.9-0.2-1.9-0.2-2.9c0-2.7,0.6-5.1,1.7-7.3c1.1-2.2,2.6-4.1,4.6-5.7c1.9-1.6,4.3-2.8,7-3.7C18,3.4,21,3,24.1,3C44.8,3,65.4,3,86,3c2.8,0,5.4,0.3,7.6,1c2.2,0.7,4.1,1.6,5.6,2.8c1.5,1.2,2.7,2.6,3.5,4.3C103.6,12.8,104,14.6,104,16.7"/>
                        <path class="st1" d="M131.8,54.6h4.1c0,0.7,0.1,1.1,0.4,1.3c0.2,0.1,0.5,0.2,0.8,0.2c0.3,0,1.3,0,3,0.1c1.8,0,2.9,0,3.2,0c0.4,0,0.6-0.1,0.9-0.2c0.3-0.1,0.5-0.5,0.5-1c0-0.4-0.1-0.7-0.3-0.8c-0.2-0.1-0.7-0.2-1.3-0.2c-0.5,0-1.6,0-3.3-0.1c-1.7-0.1-2.8-0.1-3.4-0.1c-1,0-1.8-0.1-2.3-0.3c-0.5-0.2-1-0.4-1.3-0.8c-0.5-0.6-0.8-1.6-0.8-3c0-1.6,0.3-2.7,0.9-3.3c0.5-0.5,1.1-0.8,2.1-1c0.9-0.1,2.8-0.2,5.7-0.2c2,0,3.5,0.1,4.3,0.2c1.3,0.2,2.1,0.5,2.6,1.1c0.5,0.5,0.7,1.4,0.7,2.7c0,0.1,0,0.3,0,0.6h-4.1c0-0.4,0-0.6-0.1-0.8c0-0.1-0.1-0.3-0.3-0.3c-0.2-0.1-0.5-0.2-1-0.2c-0.5,0-1.4,0-2.9,0c-1.8,0-2.9,0.1-3.3,0.2c-0.4,0.1-0.6,0.4-0.6,0.9c0,0.5,0.2,0.8,0.6,0.9c0.3,0.1,1.8,0.2,4.5,0.3c2.2,0.1,3.7,0.1,4.5,0.2c0.8,0.1,1.4,0.3,1.8,0.5c0.5,0.3,0.9,0.7,1.1,1.3c0.2,0.5,0.3,1.3,0.3,2.3c0,1.3-0.2,2.3-0.5,2.9c-0.3,0.5-0.6,0.8-1.1,1c-0.5,0.2-1.1,0.4-2,0.5c-0.9,0.1-2.6,0.1-5.1,0.1c-2.1,0-3.6-0.1-4.6-0.2c-1-0.1-1.7-0.3-2.2-0.6c-0.5-0.3-0.9-0.7-1.1-1.2c-0.2-0.5-0.3-1.2-0.3-2.2V54.6z M113.4,45.4h15.3v3.2h-11.2v2h10.6v3h-10.6v2.2h11.2v3.3h-15.4V45.4z M105.5,53.8h4.2c0,0.7,0,1.1,0,1.3c0,1.1-0.2,1.9-0.5,2.5c-0.3,0.7-1,1.1-2.1,1.4c-1,0.2-2.8,0.4-5.3,0.4c-2.6,0-4.5-0.1-5.6-0.2c-1.1-0.1-2-0.3-2.5-0.6c-0.5-0.3-0.9-0.6-1.1-1.1c-0.2-0.4-0.4-1.1-0.5-1.8c-0.1-0.6-0.1-1.8-0.1-3.4c0-1.6,0-2.8,0.1-3.5c0.1-0.7,0.2-1.3,0.4-1.6c0.4-0.9,1.2-1.4,2.3-1.7c1.2-0.3,3.5-0.4,7.1-0.4c1.8,0,3.1,0,3.9,0.1c0.8,0.1,1.5,0.2,1.9,0.5c0.6,0.3,1.1,0.7,1.3,1.3c0.3,0.6,0.4,1.4,0.4,2.6c0,0.1,0,0.3,0,0.7h-4.2c0-0.5-0.1-0.8-0.1-0.9c0-0.2-0.1-0.3-0.2-0.4c-0.2-0.1-0.6-0.2-1.2-0.3c-0.7-0.1-1.6-0.1-3-0.1c-1.3,0-2.2,0-2.7,0.1c-0.5,0.1-0.9,0.2-1.1,0.3c-0.2,0.2-0.4,0.5-0.5,1c-0.1,0.5-0.1,1.2-0.1,2.3c0,1,0,1.8,0.1,2.2c0.1,0.4,0.3,0.7,0.5,0.9c0.2,0.2,0.6,0.3,1.1,0.4c0.5,0.1,1.4,0.1,2.7,0.1c1.6,0,2.7,0,3.2-0.1c0.5-0.1,0.9-0.2,1.1-0.4C105.4,55.3,105.5,54.7,105.5,53.8z M83.9,45.4h4.4v13.8h-4.4V45.4z M61,45.4h4.6l5,10.3h0.8l5-10.3h4.6l-6.7,13.8h-6.5L61,45.4z M45.7,52.2h5.9c1,0,1.6,0,1.8-0.1c0.2,0,0.4-0.1,0.5-0.2c0.2-0.1,0.3-0.3,0.4-0.5c0.1-0.2,0.1-0.6,0.1-1c0-0.4,0-0.8-0.1-1c-0.1-0.2-0.2-0.4-0.4-0.5c-0.1-0.1-0.3-0.1-0.5-0.1c-0.2,0-0.8,0-1.8,0h-5.9V52.2z M41.5,59.2V45.4h10.2c2.4,0,3.8,0,4.3,0.1c0.5,0,0.9,0.2,1.4,0.5c0.5,0.3,0.9,0.8,1.1,1.3c0.2,0.6,0.3,1.4,0.3,2.6c0,1-0.1,1.7-0.2,2.2c-0.1,0.5-0.4,0.8-0.7,1.1c-0.4,0.3-0.9,0.5-1.7,0.6c0.9,0.1,1.5,0.3,1.9,0.8c0.2,0.3,0.4,0.6,0.4,1c0.1,0.4,0.1,1.2,0.1,2.4v1.3h-4.1v-0.7c0-0.8,0-1.3-0.1-1.6c-0.1-0.3-0.2-0.6-0.3-0.8c-0.2-0.2-0.4-0.3-0.6-0.3c-0.3,0-0.8-0.1-1.7-0.1h-5.9v3.5H41.5z M22.6,45.4h15.3v3.2H26.8v2h10.6v3H26.8v2.2H38v3.3H22.6V45.4z M2.1,54.6h4.1c0,0.7,0.1,1.1,0.4,1.3c0.2,0.1,0.5,0.2,0.8,0.2c0.3,0,1.3,0,3,0.1c1.8,0,2.9,0,3.2,0c0.4,0,0.6-0.1,0.9-0.2c0.3-0.1,0.5-0.5,0.5-1c0-0.4-0.1-0.7-0.3-0.8c-0.2-0.1-0.7-0.2-1.3-0.2c-0.5,0-1.6,0-3.3-0.1c-1.7-0.1-2.8-0.1-3.4-0.1c-1,0-1.8-0.1-2.3-0.3c-0.5-0.2-1-0.4-1.3-0.8c-0.5-0.6-0.8-1.6-0.8-3c0-1.6,0.3-2.7,0.9-3.3c0.5-0.5,1.1-0.8,2.1-1c0.9-0.1,2.8-0.2,5.7-0.2c2,0,3.5,0.1,4.3,0.2c1.3,0.2,2.1,0.5,2.6,1.1c0.5,0.5,0.7,1.4,0.7,2.7c0,0.1,0,0.3,0,0.6h-4.1c0-0.4,0-0.6-0.1-0.8c0-0.1-0.1-0.3-0.3-0.3c-0.2-0.1-0.5-0.2-1-0.2c-0.5,0-1.4,0-2.9,0c-1.8,0-2.9,0.1-3.3,0.2c-0.4,0.1-0.6,0.4-0.6,0.9c0,0.5,0.2,0.8,0.6,0.9c0.3,0.1,1.8,0.2,4.5,0.3c2.2,0.1,3.7,0.1,4.5,0.2c0.8,0.1,1.4,0.3,1.8,0.5c0.5,0.3,0.9,0.7,1.1,1.3c0.2,0.5,0.3,1.3,0.3,2.3c0,1.3-0.2,2.3-0.5,2.9c-0.3,0.5-0.6,0.8-1.1,1c-0.5,0.2-1.1,0.4-2,0.5c-0.9,0.1-2.6,0.1-5.1,0.1c-2.1,0-3.6-0.1-4.6-0.2c-1-0.1-1.7-0.3-2.2-0.6C3,58.3,2.6,58,2.4,57.5c-0.2-0.5-0.3-1.2-0.3-2.2V54.6z"/>
                        <path class="st0" d="M158.4,11.4c-0.9,0.9-2,1.3-3.3,1.3c-1.3,0-2.5-0.5-3.4-1.4c-0.9-0.9-1.4-2-1.4-3.4c0-1.4,0.5-2.6,1.5-3.5c0.9-0.9,2-1.3,3.3-1.3c1.3,0,2.4,0.5,3.4,1.4c0.9,0.9,1.4,2.1,1.4,3.4C159.8,9.3,159.3,10.5,158.4,11.4z M152.2,5.2c-0.8,0.8-1.1,1.7-1.1,2.8c0,1.1,0.4,2,1.2,2.8c0.8,0.8,1.7,1.2,2.8,1.2c1.1,0,2-0.4,2.8-1.2c0.8-0.8,1.2-1.7,1.2-2.8c0-1.1-0.4-2-1.1-2.8C157,4.4,156.1,4,155,4C153.9,4,153,4.4,152.2,5.2z M152.9,10.6V5.3c0.3,0,0.8,0,1.5,0c0.7,0,1,0,1.1,0c0.4,0,0.8,0.1,1,0.3c0.5,0.3,0.7,0.7,0.7,1.3c0,0.4-0.1,0.8-0.4,1c-0.2,0.2-0.6,0.3-0.9,0.4c0.3,0.1,0.6,0.2,0.8,0.3c0.3,0.3,0.5,0.6,0.5,1.2v0.5c0,0.1,0,0.1,0,0.2c0,0.1,0,0.1,0,0.2l0,0.1h-1.3c0-0.2-0.1-0.4-0.1-0.7c0-0.3,0-0.5-0.1-0.6c-0.1-0.2-0.2-0.3-0.4-0.4c-0.1,0-0.3-0.1-0.5-0.1l-0.3,0h-0.3v1.9H152.9z M155.5,6.4c-0.2-0.1-0.5-0.1-0.8-0.1h-0.3v1.5h0.5c0.3,0,0.6-0.1,0.8-0.2c0.2-0.1,0.3-0.3,0.3-0.6C155.9,6.7,155.7,6.5,155.5,6.4z"/>
                    </g>
                </svg>
            </div>
            <div class="flex items-center gap-2 text-[#F9BE00] text-sm font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="hidden sm:inline">Portal de Proveedores</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
        <!-- Hero Section with 2 columns -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <!-- Left: Text Content -->
            <div class="space-y-6 order-2 lg:order-1">
                
                <h1 class="text-5xl sm:text-6xl font-black leading-tight text-black">
                    Únete a la red de
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#CF0A2C] via-[#F9BE00] to-[#CF0A2C]">proveedores GPT Services</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Completa el formulario con tus datos, adjunta tu documentación en PDF y nuestro equipo revisará tu solicitud en <strong class="text-[#CF0A2C]">24 a 48 horas</strong>.
                </p>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="w-10 h-10 rounded-lg bg-[#CF0A2C] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-black">Revisión rápida</p>
                            <p class="text-xs text-slate-500">Respuesta en 24-48h</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="w-10 h-10 rounded-lg bg-[#F9BE00] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-black">Documentos PDF</p>
                            <p class="text-xs text-slate-500">Hasta 5MB por archivo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Image -->
            <div class="relative order-1 lg:order-2 flex items-center justify-center">
                <!-- Blur circles behind -->
                <div class="absolute w-96 h-96 bg-gradient-to-br from-[#CF0A2C]/30 via-[#F9BE00]/30 to-transparent rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute w-80 h-80 bg-gradient-to-tl from-[#F9BE00]/20 via-[#CF0A2C]/20 to-transparent rounded-full blur-2xl" style="animation: pulse 3s ease-in-out infinite alternate;"></div>
                
                <!-- Image with circular mask and fade -->
                <div class="relative w-full max-w-md aspect-square">
                    <div class="absolute inset-0 bg-gradient-radial from-transparent via-transparent to-white rounded-full"></div>
                    <img src="{{ asset('assets/img/2mans.png') }}" alt="Profesionales GPT Services" class="relative w-full h-full object-cover rounded-full shadow-2xl" style="mask-image: radial-gradient(circle, black 60%, transparent 100%); -webkit-mask-image: radial-gradient(circle, black 60%, transparent 100%);" />
                </div>
            </div>
        </section>

            <!-- Form Card -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-red-100/40 overflow-hidden">
                <div class="bg-gradient-to-r from-[#CF0A2C] to-[#F9BE00] px-6 py-4 text-white font-bold">Formulario de registro</div>

                <div class="p-6 sm:p-8">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                            <p class="font-semibold mb-2">Por favor corrige los siguientes campos:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('providers.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase text-[#CF0A2C] tracking-wide">
                                <span class="h-1.5 w-6 rounded-full bg-[#CF0A2C]"></span> Información general
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">RFC *</label>
                                    <input type="text" name="rfc" value="{{ old('rfc') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Razón social *</label>
                                    <input type="text" name="company_name" value="{{ old('company_name') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Calle *</label>
                                    <input type="text" name="street" value="{{ old('street') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Número # *</label>
                                    <input type="text" name="number" value="{{ old('number') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Colonia *</label>
                                    <input type="text" name="neighborhood" value="{{ old('neighborhood') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Municipio *</label>
                                    <input type="text" name="municipality" value="{{ old('municipality') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Estado *</label>
                                    <input type="text" name="state" value="{{ old('state') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">País *</label>
                                    <input type="text" name="country" value="{{ old('country', 'México') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Código postal</label>
                                    <input type="text" name="cp" value="{{ old('cp') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Sitio web de la empresa</label>
                                    <input type="url" name="web_company" value="{{ old('web_company') }}" placeholder="https://" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase text-[#CF0A2C] tracking-wide">
                                <span class="h-1.5 w-6 rounded-full bg-[#CF0A2C]"></span> Cuenta bancaria
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Banco</label>
                                    <input type="text" name="bank" value="{{ old('bank') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Cuenta de banco</label>
                                    <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Clabe *</label>
                                    <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#CF0A2C]/20 focus:border-[#CF0A2C]" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase text-[#CF0A2C] tracking-wide">
                                <span class="h-1.5 w-6 rounded-full bg-[#CF0A2C]"></span> Documentación
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold text-black">Hoja de datos bancarios (PDF) *</label>
                                    <input type="file" name="bank_data_file" accept="application/pdf" required class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#F9BE00] file:text-black file:font-semibold hover:file:bg-[#F9BE00]/80 transition" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-black">Constancia de situación fiscal (PDF) *</label>
                                    <input type="file" name="tax_certificate_file" accept="application/pdf" required class="mt-2 block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#F9BE00] file:text-black file:font-semibold hover:file:bg-[#F9BE00]/80 transition" />
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 bg-slate-50 rounded-lg border border-slate-200 mt-2">
                                <svg class="w-5 h-5 text-[#CF0A2C] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-xs text-slate-600">Solo archivos PDF. Tamaño máximo <strong class="text-black">5 MB</strong> por archivo.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t-2 border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-[#CF0A2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-sm text-slate-600">Tu información se enviará de forma <strong class="text-black">segura</strong> al área de Compras.</p>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-black text-white font-bold shadow-lg hover:bg-[#CF0A2C] transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Enviar solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Trust Section -->
        <section class="bg-black text-white py-12 px-8 rounded-3xl shadow-2xl mt-6">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <h2 class="text-3xl font-black">¿Por qué trabajar con <span class="text-[#F9BE00]">GPT Services</span>?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="p-6 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition">
                        <div class="w-14 h-14 rounded-full bg-[#CF0A2C] flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Certificación ISO</h3>
                        <p class="text-sm text-slate-300">Cumplimos con estándares internacionales de calidad y gestión.</p>
                    </div>
                    <div class="p-6 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition">
                        <div class="w-14 h-14 rounded-full bg-[#F9BE00] flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Proceso ágil</h3>
                        <p class="text-sm text-slate-300">Revisión y respuesta en menos de 48 horas.</p>
                    </div>
                    <div class="p-6 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition">
                        <div class="w-14 h-14 rounded-full bg-[#CF0A2C] flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Seriedad garantizada</h3>
                        <p class="text-sm text-slate-300">Compromisos cumplidos y relaciones de largo plazo.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 px-4 mt-16">
        <div class="max-w-7xl mx-auto text-center text-sm">
            <p>&copy; 2025 GPT Services. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
