# App Orchestrator

> Plataforma central Laravel 12 que cumple dos funciones principales: **orquestación de sistemas empresariales** mediante una capa de API unificada, y **gestión del registro de proveedores** con flujo de aprobación interno.

---

## Tabla de contenido

- [Tecnologías](#tecnologías)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Variables de entorno](#variables-de-entorno)
- [Roles y permisos](#roles-y-permisos)
- [Módulo 1 — Orquestador de Sistemas](#módulo-1--orquestador-de-sistemas)
- [Módulo 2 — Registro de Proveedores](#módulo-2--registro-de-proveedores)

---

## Tecnologías

| Paquete | Versión | Uso |
|---|---|---|
| PHP | ^8.2 | Runtime |
| Laravel | ^12.0 | Framework base |
| Laravel Socialite | ^5.23 | Autenticación con Google OAuth |
| Laratrust | ^8.5 | Roles y permisos (admin, purchasing) |
| Google API Client | ^2.18 | Google Drive & Sheets |
| Vite + Tailwind CSS | — | Frontend |

---

## Requisitos

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL / MariaDB
- Cuenta de servicio de Google (para Google Drive)
- Credenciales OAuth de Google (para inicio de sesión)

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone <repo-url>
cd app-orchestrator

# 2. Instalación automática (instala dependencias, genera clave, migra y compila assets)
composer run setup
```

O paso a paso:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### Modo desarrollo

```bash
composer run dev
```

Levanta en paralelo: servidor PHP, queue worker, log watcher (Pail) y Vite.

---

## Variables de entorno

```env
# Base de datos principal
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app_orchestrator
DB_USERNAME=root
DB_PASSWORD=

# Base de datos secundaria (ej. RH)
DB2_HOST=127.0.0.1
DB2_PORT=3306
DB2_DATABASE=rh_database
DB2_USERNAME=root
DB2_PASSWORD=

# Google OAuth (Socialite)
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

# Google Drive / Sheets (Service Account)
GOOGLE_PROJECT_ID=
GOOGLE_PRIVATE_KEY_ID=
GOOGLE_PRIVATE_KEY=
GOOGLE_CLIENT_EMAIL=

# Correo
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

> También se puede colocar el archivo `google-credentials.json` de cuenta de servicio en `storage/app/google-credentials.json` en lugar de usar las variables de entorno de Google.

---

## Roles y permisos

Gestionados con **Laratrust**. Los dos roles principales son:

| Rol | Acceso |
|---|---|
| `admin` | Gestión de sitios, panel de control administrativo |
| `purchasing` | Revisión, aprobación y rechazo de solicitudes de proveedores |

Poblar roles y sitios base:

```bash
php artisan db:seed --class=RolesAndSitesSeeder
php artisan db:seed --class=PurchasingRoleSeeder
```

---

---

## Módulo 1 — Orquestador de Sistemas

Este módulo expone una **API REST** que actúa como intermediario entre los distintos sistemas empresariales. Cada sistema externo consume o provee datos a través de los endpoints definidos a continuación, sin necesidad de acceder directamente a las bases de datos de cada aplicación.

### Arquitectura

```
Sistema A  ─┐
Sistema B  ─┤──▶  App Orchestrator (API)  ──▶  Base de datos RH / otros
Sistema C  ─┘          Laravel 12
```

### Autenticación de usuarios (Web)

Los usuarios internos acceden al orquestador mediante **Google OAuth**:

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/login` | Pantalla de inicio de sesión |
| `GET` | `/auth/google` | Redirige a Google para autenticación |
| `GET` | `/auth/google/callback` | Callback de Google OAuth |
| `POST` | `/logout/google` | Cerrar sesión |
| `GET` | `/dashboard` | Panel principal (vista según rol) |

### Gestión de sitios (rol: admin)

Los administradores gestionan los sistemas/sitios registrados en el orquestador:

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/sites` | Listado de sitios |
| `GET` | `/sites/create` | Formulario de nuevo sitio |
| `POST` | `/sites` | Crear sitio |
| `GET` | `/sites/{site}` | Ver detalle de sitio |
| `GET` | `/sites/{site}/edit` | Formulario de edición |
| `PUT/PATCH` | `/sites/{site}` | Actualizar sitio |
| `DELETE` | `/sites/{site}` | Eliminar sitio |
| `POST` | `/sites/{site}/check` | Verificar estado/conectividad del sitio |

### API REST — Módulo RH

Prefijo base: `/api/rh`

Expone los datos del sistema de **Recursos Humanos** (base de datos secundaria) hacia otros sistemas.

#### Usuarios

| Método | Endpoint | Descripción |
|---|---|---|
| `GET` | `/api/rh/users` | Listar todos los usuarios activos con su puesto, departamento, área, jefe y razón social |
| `GET` | `/api/rh/users/{userId}` | Obtener un usuario por su ID |
| `POST` | `/api/rh/users/buscar-por-email` | Buscar usuario por correo electrónico |

##### `GET /api/rh/users` — Ejemplo de respuesta

```json
{
  "success": true,
  "total": 42,
  "data": [
    {
      "id": 1,
      "uuid": "abc-123",
      "nombre_completo": "Juan Pérez",
      "nombre": "Juan",
      "apellido": "Pérez",
      "email": "juan@empresa.com",
      "telefono": "5512345678",
      "cedula": "PERJ900101",
      "fecha_admission": "2022-01-15",
      "foto_perfil": null,
      "activo": true,
      "puesto": { "id": 3, "nombre": "Desarrollador Senior" },
      "departamento": { "id": 2, "nombre": "Tecnología" },
      "area": { "id": 1, "nombre": "Sistemas" },
      "jefe": { "uuid": "xyz-456", "nombre_completo": "María López" },
      "razon_social": { "id": 1, "nombre": "Empresa S.A. de C.V." }
    }
  ]
}
```

##### `POST /api/rh/users/buscar-por-email` — Body

```json
{
  "email": "juan@empresa.com"
}
```

---

---

## Módulo 2 — Registro de Proveedores

Flujo completo para que un **proveedor externo** envíe su solicitud de alta y el equipo de **Compras** la revise, apruebe o rechace. Los documentos se almacenan localmente y en **Google Drive**.

### Flujo general

```
Proveedor (público)
   │  Llena formulario en /proveedores/registro
   │  Adjunta: constancia de situación fiscal + datos bancarios
   ▼
Sistema guarda solicitud con status: pendiente
   │  Sube documentos a Google Drive (carpeta por proveedor)
   │  Envía notificación al equipo de Compras
   ▼
Equipo de Compras (rol: purchasing)
   │  Revisa solicitud en /compras/solicitudes
   │  Puede aprobar o rechazar con notas
   ▼
Proveedor recibe notificación por correo
```

### Rutas públicas (sin autenticación)

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/proveedores/registro` | Formulario público de registro de proveedor |
| `POST` | `/proveedores/registro` | Enviar solicitud de proveedor |
| `GET` | `/proveedores/registro/gracias` | Página de confirmación post-registro |

#### Campos del formulario de registro

| Campo | Descripción |
|---|---|
| `rfc` | RFC del proveedor |
| `company_name` | Razón social |
| `street`, `number`, `neighborhood` | Domicilio fiscal |
| `municipality`, `state`, `country`, `cp` | Ubicación |
| `web_company` | Sitio web (opcional) |
| `bank`, `bank_account`, `bank_account_number` | Datos bancarios |
| `bank_data_file` | PDF de carátula bancaria |
| `tax_certificate_file` | PDF de constancia de situación fiscal (SAT) |

### Rutas de gestión (rol: purchasing)

Prefijo: `/compras/solicitudes`

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/compras/solicitudes` | Listado de solicitudes (filtros por status, cadena de aprobación, búsqueda RFC/razón social) |
| `GET` | `/compras/solicitudes/{application}` | Detalle de solicitud |
| `GET` | `/compras/solicitudes/{application}/revisar` | Formulario de aprobación / rechazo |
| `POST` | `/compras/solicitudes/{application}/aprobar` | Aprobar solicitud |
| `POST` | `/compras/solicitudes/{application}/rechazar` | Rechazar solicitud con motivo |
| `GET` | `/compras/solicitudes/{application}/descargar/{documentType}` | Descargar documento adjunto |

#### Estados de una solicitud

| Status | Descripción |
|---|---|
| `pending` | Recién registrada, en espera de revisión |
| `approved` | Aprobada por Compras |
| `rejected` | Rechazada con motivo |

### Google Drive

Al recibir una nueva solicitud, el sistema crea automáticamente una carpeta en Google Drive con los documentos del proveedor. El `google_drive_folder_id` se almacena en la solicitud para acceso posterior.

Configuración de credenciales de cuenta de servicio: ver sección [Variables de entorno](#variables-de-entorno).

---

## Comandos útiles

```bash
# Ejecutar pruebas
composer run test

# Limpiar caché de configuración
php artisan config:clear

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Ver logs en tiempo real
php artisan pail
```
