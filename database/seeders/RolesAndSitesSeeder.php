<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Site;
use App\Models\User;

class RolesAndSitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Usuario con acceso completo al sistema'
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'display_name' => 'Usuario',
            'description' => 'Usuario estándar con acceso limitado'
        ]);

        // Crear permisos
        $manageSites = Permission::firstOrCreate([
            'name' => 'manage-sites',
            'display_name' => 'Gestionar Sitios',
            'description' => 'Crear, editar y eliminar sitios'
        ]);

        $viewSites = Permission::firstOrCreate([
            'name' => 'view-sites',
            'display_name' => 'Ver Sitios',
            'description' => 'Ver la lista de sitios y su estado'
        ]);

        // Asignar permisos a roles
        $admin->syncPermissions([$manageSites, $viewSites]);
        $user->syncPermissions([$viewSites]);

        // Crear sitios iniciales
        $sites = [
            [
                'name' => 'IT Satech Energy',
                'url' => 'https://it.satechenergy.com',
                'description' => 'Sistema de gestión IT',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
            [
                'name' => 'RRHH Satech Energy',
                'url' => 'https://rrhh.satechenergy.com',
                'description' => 'Sistema de recursos humanos',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
            [
                'name' => 'Compras GPT Satech',
                'url' => 'https://app.gptsatech.com/compras',
                'description' => 'Sistema de gestión de compras',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
            [
                'name' => 'QHSE GPT Satech',
                'url' => 'https://qhse.gptsatech.com',
                'description' => 'Sistema de calidad, salud, seguridad y medio ambiente',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
            [
                'name' => 'Reportes GPT Satech',
                'url' => 'https://reportesgpt.satechenergy.com',
                'description' => 'Sistema de reportes y análisis',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
            [
                'name' => 'EC Satech Energy',
                'url' => 'https://ec.satechenergy.com',
                'description' => 'Sistema EC',
                'is_active' => true,
                'status' => 'unknown',
                'check_interval' => 300,
            ],
        ];

        foreach ($sites as $site) {
            Site::firstOrCreate(
                ['url' => $site['url']],
                $site
            );
        }

        $this->command->info('Roles, permisos y sitios creados exitosamente!');
    }
}

