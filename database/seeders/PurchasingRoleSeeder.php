<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PurchasingRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear rol de compras si no existe
        $purchasingRole = Role::firstOrCreate(
            ['name' => 'purchasing'],
            ['display_name' => 'Compras', 'description' => 'Equipo de Compras - Gestión de solicitudes de proveedores']
        );

        // Crear permisos relacionados con compras
        $permissions = [
            ['name' => 'view_provider_applications', 'display_name' => 'Ver solicitudes de proveedores'],
            ['name' => 'approve_provider_applications', 'display_name' => 'Aprobar solicitudes de proveedores'],
            ['name' => 'reject_provider_applications', 'display_name' => 'Rechazar solicitudes de proveedores'],
            ['name' => 'download_provider_documents', 'display_name' => 'Descargar documentos de proveedores'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['display_name' => $perm['display_name']]
            );
        }

        // Asignar permisos al rol de compras
        $purchasingRole->syncPermissions(
            Permission::whereIn('name', [
                'view_provider_applications',
                'approve_provider_applications',
                'reject_provider_applications',
                'download_provider_documents',
            ])->get()
        );

        $this->command->info('Rol de Compras creado exitosamente.');
    }
}
