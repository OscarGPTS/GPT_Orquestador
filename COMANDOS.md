# 📝 Comandos Útiles - App Orchestrator

## 🚀 Instalación y Setup

```bash
# Clonar/navegar al proyecto
cd c:\xampp\htdocs\app-orchestrator

# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install

# Generar clave de aplicación
php artisan key:generate

# Crear base de datos
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"

# Ejecutar migraciones
php artisan migrate

# Compilar assets Tailwind
npm run build

# O para desarrollo con hot reload
npm run dev
```

## 🔧 Desarrollo

```bash
# Iniciar servidor local
php artisan serve

# En otra terminal, compilar assets en modo watch
npm run dev

# Abrir en navegador
http://localhost:8000
```

## 🗄️ Base de Datos

```bash
# Crear base de datos
mysql -u root -e "CREATE DATABASE laravel;"

# Ejecutar todas las migraciones
php artisan migrate

# Rollback última migración
php artisan migrate:rollback

# Rollback y ejecutar de nuevo
php artisan migrate:refresh

# Ejecutar seeders (si existen)
php artisan db:seed
```

## 🔐 Artisan Commands

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan optimize

# Ver información de la app
php artisan about
```

## 📦 Composer Commands

```bash
# Actualizar todas las dependencias
composer update

# Instalar una nueva dependencia
composer require nombre/paquete

# Remover una dependencia
composer remove nombre/paquete

# Ver dependencias instaladas
composer show

# Validar composer.json
composer validate
```

## 🎨 Frontend Commands

```bash
# Compilar assets una sola vez
npm run build

# Compilar en modo desarrollo
npm run dev

# Limpiar node_modules y reinstalar
npm ci
```

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Ejecutar tests con coverage
php artisan test --coverage

# Ejecutar solo tests de Feature
php artisan test --testsuite=Feature

# Ejecutar solo tests de Unit
php artisan test --testsuite=Unit
```

## 🐛 Debugging

```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# En Windows, ver logs
Get-Content storage/logs/laravel.log -Tail 100 -Wait

# Limpiar logs
php artisan logs:clear

# Ver información del servidor
php artisan server:status
```

## 🚀 Deployment

```bash
# Instalar solo dependencias de producción
composer install --no-dev --optimize-autoloader

# Build final para producción
npm run build

# Migrar base de datos
php artisan migrate --force

# Cache de configuración
php artisan config:cache

# Cache de rutas
php artisan route:cache

# Cache de vistas
php artisan view:cache
```

## 🔍 Verificación

```bash
# Verificar sintaxis PHP de un archivo
php -l app/Http/Controllers/GoogleController.php

# Ejecutar composer validate
composer validate

# Verificar estructura
php artisan tinker

# Listar migraciones ejecutadas
php artisan migrate:status
```

## 📊 Información Útil

```bash
# Ver versión de Laravel
php artisan --version

# Ver versión de PHP
php --version

# Ver variables de entorno
php artisan config:show

# Ver todo lo relacionado a app
php artisan config:show app
```

## 🆘 Solución de Problemas

### Error: "The database does not exist"
```bash
mysql -u root -e "CREATE DATABASE laravel;"
php artisan migrate
```

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
```

### Limpiar todo y empezar de nuevo
```bash
php artisan migrate:refresh --seed
```

### Puerto 8000 en uso
```bash
php artisan serve --port=8001
```

## 🎯 Workflow Típico

```bash
# 1. Navegar al proyecto
cd c:\xampp\htdocs\app-orchestrator

# 2. Crear una rama para nueva feature
git checkout -b feature/nueva-funcionalidad

# 3. Actualizar dependencias si es necesario
composer install
npm install

# 4. Iniciar servidor
php artisan serve

# 5. En otra terminal, compilar assets
npm run dev

# 6. Hacer cambios, probar
# ...

# 7. Cuando esté listo, compilar para producción
npm run build

# 8. Commitear cambios
git add .
git commit -m "Nueva funcionalidad implementada"

# 9. Push y crear PR
git push origin feature/nueva-funcionalidad
```

## 💡 Tips Útiles

- Usar `php artisan tinker` para probar código rápidamente
- Usar `php artisan make:*` para generar archivos
- Revisar `storage/logs/laravel.log` para errores
- Usar `dd()` o `dump()` para debugging
- Limpiar cache frecuentemente durante desarrollo
- Usar `.env.local` para configuración local

## 📚 Documentación Referencia

- Laravel Docs: https://laravel.com/docs
- Socialite: https://laravel.com/docs/socialite
- Tailwind: https://tailwindcss.com/docs
- Blade: https://laravel.com/docs/blade

---

**Última actualización**: Diciembre 8, 2025
