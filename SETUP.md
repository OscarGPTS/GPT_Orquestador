# App Orchestrator - Guía de Configuración

## 📋 Descripción

App Orchestrator es una aplicación Laravel que permite orquestar otras aplicaciones usando autenticación OAuth 2.0 con Google. Incluye una interfaz moderna y responsiva construida con Tailwind CSS.

## 🚀 Requisitos Previos

- PHP 8.2 o superior
- Composer
- MySQL/MariaDB
- Node.js y npm
- Git

## 📦 Instalación y Configuración

### 1. Clonar o descargar el repositorio

```bash
cd c:\xampp\htdocs\app-orchestrator
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Generar clave de aplicación

```bash
php artisan key:generate
```

### 5. Configurar la base de datos

Edita el archivo `.env` y asegúrate de que las credenciales de la base de datos sean correctas:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Luego crea la base de datos:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Configurar Google OAuth

#### Paso A: Crear proyecto en Google Cloud Console

1. Accede a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto o selecciona uno existente
3. Habilita la API de Google+ 

#### Paso B: Crear credenciales OAuth

1. Ve a "Credenciales" en el menú lateral
2. Haz clic en "Crear credenciales" → "ID de cliente de OAuth"
3. Selecciona "Aplicación web"
4. En "URIs de redirección autorizados", agrega:
   - `http://localhost:8000/auth/google/callback`
5. Copia el Client ID y Secret

#### Paso C: Actualizar el archivo .env

Reemplaza los valores en tu archivo `.env`:

```env
GOOGLE_CLIENT_ID=tu_client_id_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

### 8. Compilar assets con Vite

```bash
npm run build
```

O para desarrollo con hot reload:

```bash
npm run dev
```

En otra terminal, inicia el servidor Laravel:

```bash
php artisan serve
```

## 🎨 Características

### Autenticación OAuth Google
- Inicio de sesión seguro con Google
- Registro automático de usuarios
- Gestión de sesiones

### Interfaz de Usuario
- Diseño responsivo con Tailwind CSS
- Colores corporativos personalizables (Rojo: #CF0A2C, Amarillo: #F9BE00)
- Dashboard limpio y moderno
- Componentes accesibles

### Rutas Implementadas

| Ruta | Método | Descripción |
|------|--------|-------------|
| `/login` | GET | Página de inicio de sesión |
| `/auth/google` | GET | Redirige a Google para autenticar |
| `/auth/google/callback` | GET | Callback de Google |
| `/dashboard` | GET | Dashboard principal (requiere autenticación) |
| `/logout/google` | POST | Cierra la sesión |

## 🔧 Estructura del Proyecto

```
app-orchestrator/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── GoogleController.php    # Controlador de Google OAuth
│   └── Models/
│       └── User.php                    # Modelo de usuario
├── config/
│   └── services.php                    # Configuración de servicios
├── database/
│   └── migrations/                     # Migraciones de base de datos
├── resources/
│   ├── css/
│   │   └── app.css                    # Estilos Tailwind
│   ├── js/
│   │   └── app.js                     # JavaScript
│   └── views/
│       ├── login.blade.php            # Vista de login
│       └── dashboard.blade.php        # Vista de dashboard
├── routes/
│   └── web.php                        # Rutas de la aplicación
└── tailwind.config.js                 # Configuración de Tailwind
```

## 🎯 Uso

1. Navega a `http://localhost:8000`
2. Serás redirigido a la página de login
3. Haz clic en "Iniciar sesión con Google"
4. Autoriza la aplicación
5. Serás redirigido al dashboard
6. Puedes cerrar sesión con el botón "Cerrar sesión"

## 🔐 Seguridad

- Implementación de CSRF protection
- Validación de sesiones
- OAuth 2.0 estándar de la industria
- Contraseñas hasheadas con bcrypt

## 🚨 Troubleshooting

### Error: "The database does not exist"
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"
php artisan migrate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
Asegúrate de que MySQL está ejecutándose en XAMPP

### Los estilos no se cargan
```bash
npm run build
# O para desarrollo
npm run dev
```

### Error de Google OAuth
- Verifica que el Client ID y Secret sean correctos
- Asegúrate de que `http://localhost:8000/auth/google/callback` está en los URIs autorizados

## 📚 Documentación Adicional

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [Tailwind CSS](https://tailwindcss.com/docs)

## 👤 Autor

App Orchestrator - 2025

## 📄 Licencia

Este proyecto está bajo licencia MIT.
