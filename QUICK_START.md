# 🚀 Instalación Rápida - App Orchestrator

## Requisitos
- PHP 8.2+
- Composer
- MySQL
- Node.js

## Pasos de Instalación

### 1. Instalar dependencias
```bash
cd c:\xampp\htdocs\app-orchestrator
composer install
npm install
```

### 2. Crear base de datos
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"
```

### 3. Configurar .env
```bash
# Copiar archivo de ejemplo
copy .env.example .env

# Generar clave
php artisan key:generate
```

### 4. Configurar Google OAuth
1. Ir a https://console.cloud.google.com/
2. Crear proyecto y habilitar Google+ API
3. Crear credenciales OAuth para aplicación web
4. Copiar Client ID y Secret
5. Agregar URI callback: `http://localhost:8000/auth/google/callback`
6. Actualizar `.env`:
```env
GOOGLE_CLIENT_ID=tu_id
GOOGLE_CLIENT_SECRET=tu_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

### 5. Ejecutar migraciones
```bash
php artisan migrate
```

### 6. Compilar assets
```bash
npm run build
```

### 7. Iniciar servidor
```bash
php artisan serve
```

Acceder a: **http://localhost:8000**

## 🎨 Personalización

### Colores de Marca
Edita `resources/css/app.css`:
```css
@theme {
    --color-brand-red: #CF0A2C;
    --color-brand-yellow: #F9BE00;
}
```

### Información de Empresa
Edita las vistas en `resources/views/`

## ✅ Prueba Rápida

1. Abre http://localhost:8000
2. Haz clic en "Iniciar sesión con Google"
3. Autoriza la aplicación
4. ¡Verás el dashboard!

## 🆘 Problemas Comunes

**Error: Database does not exist**
```bash
mysql -u root -e "CREATE DATABASE laravel;"
php artisan migrate
```

**Error: CSS no se carga**
```bash
npm run build
```

**Puerto 8000 en uso**
```bash
php artisan serve --port=8001
```

---
¡Listo para orquestar tus aplicaciones! 🎯
