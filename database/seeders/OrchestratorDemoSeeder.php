<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OrchestratorDemoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Datos de prueba para el dashboard de orquestación.
     * Simula un escenario real con sitios en distintos estados,
     * tiempos de respuesta variados y un administrador de acceso.
     */
    public function run(): void
    {
        $this->seedAdminUser();
        $this->assignAdminToUserId1();
        $this->seedSites();

        $this->command->info('✓ Datos de prueba del orquestador generados.');
        $this->command->line('  Admin: admin@demo.com / password: password');
    }

    // -------------------------------------------------------------------------
    // Asignar rol admin al usuario ID 1 (tu usuario de Google OAuth)
    // -------------------------------------------------------------------------

    private function assignAdminToUserId1(): void
    {
        $user = User::find(1);

        if (! $user) {
            $this->command->warn('  Usuario ID 1 no encontrado, se omite asignación de rol.');
            return;
        }

        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            $this->command->warn('  Rol "admin" no existe. Ejecuta RolesAndSitesSeeder primero.');
            return;
        }

        if (! $user->hasRole('admin')) {
            $user->addRole($adminRole);
            $this->command->line("  Rol admin asignado a: {$user->email}");
        } else {
            $this->command->line("  {$user->email} ya tiene rol admin.");
        }
    }

    // -------------------------------------------------------------------------
    // Usuario administrador de prueba
    // -------------------------------------------------------------------------

    private function seedAdminUser(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name'     => 'Admin Demo',
                'email'    => 'admin@demo.com',
                'password' => Hash::make('password'),
            ]
        );

        // Asignar rol admin si Laratrust ya lo tiene creado
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && ! $admin->hasRole('admin')) {
            $admin->addRole($adminRole);
        }
    }

    // -------------------------------------------------------------------------
    // Sitios con estados variados para el dashboard
    // -------------------------------------------------------------------------

    private function seedSites(): void
    {
        $now = Carbon::now();

        $sites = [
            // --- Sistemas UP ---
            [
                'name'            => 'IT Satech Energy',
                'url'             => 'https://it.satechenergy.com',
                'description'     => 'Sistema de gestión de infraestructura IT',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 142,
                'last_checked_at' => $now->copy()->subMinutes(2),
                'check_interval'  => 300,
            ],
            [
                'name'            => 'RRHH Satech Energy',
                'url'             => 'https://rrhh.satechenergy.com',
                'description'     => 'Sistema de recursos humanos y nómina',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 89,
                'last_checked_at' => $now->copy()->subMinutes(1),
                'check_interval'  => 300,
            ],
            [
                'name'            => 'Compras GPT Satech',
                'url'             => 'https://app.gptsatech.com/compras',
                'description'     => 'Sistema de gestión de compras y proveedores',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 213,
                'last_checked_at' => $now->copy()->subMinutes(3),
                'check_interval'  => 300,
            ],
            [
                'name'            => 'QHSE GPT Satech',
                'url'             => 'https://qhse.gptsatech.com',
                'description'     => 'Sistema de calidad, salud, seguridad y medio ambiente',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 176,
                'last_checked_at' => $now->copy()->subMinutes(4),
                'check_interval'  => 300,
            ],
            [
                'name'            => 'Portal Empleados',
                'url'             => 'https://empleados.satechenergy.com',
                'description'     => 'Portal de autoservicio para empleados (nómina, vacaciones, etc.)',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 310,
                'last_checked_at' => $now->copy()->subMinutes(2),
                'check_interval'  => 600,
            ],
            [
                'name'            => 'CRM Comercial',
                'url'             => 'https://crm.satechenergy.com',
                'description'     => 'Gestión de clientes y oportunidades comerciales',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 98,
                'last_checked_at' => $now->copy()->subMinutes(5),
                'check_interval'  => 300,
            ],

            // --- Sistema con latencia alta (degradado) ---
            [
                'name'            => 'Reportes GPT Satech',
                'url'             => 'https://reportesgpt.satechenergy.com',
                'description'     => 'Sistema de reportes, KPIs y análisis de datos',
                'is_active'       => true,
                'status'          => 'up',
                'response_time'   => 1840,   // lento pero arriba
                'last_checked_at' => $now->copy()->subMinutes(6),
                'check_interval'  => 300,
            ],

            // --- Sistemas DOWN ---
            [
                'name'            => 'EC Satech Energy',
                'url'             => 'https://ec.satechenergy.com',
                'description'     => 'Sistema de control de energía y mediciones eléctricas',
                'is_active'       => true,
                'status'          => 'down',
                'response_time'   => null,
                'last_checked_at' => $now->copy()->subMinutes(8),
                'check_interval'  => 300,
            ],
            [
                'name'            => 'ERP Finanzas',
                'url'             => 'https://erp.satechenergy.com',
                'description'     => 'Sistema de planeación financiera y contabilidad',
                'is_active'       => true,
                'status'          => 'down',
                'response_time'   => null,
                'last_checked_at' => $now->copy()->subMinutes(15),
                'check_interval'  => 300,
            ],

            // --- Sistema inactivo (mantenimiento programado) ---
            [
                'name'            => 'Almacén WMS',
                'url'             => 'https://wms.satechenergy.com',
                'description'     => 'Sistema de gestión de almacén e inventarios',
                'is_active'       => false,  // en mantenimiento
                'status'          => 'unknown',
                'response_time'   => null,
                'last_checked_at' => $now->copy()->subHours(12),
                'check_interval'  => 600,
            ],
        ];

        foreach ($sites as $site) {
            Site::updateOrCreate(
                ['url' => $site['url']],
                $site
            );
        }
    }
}
