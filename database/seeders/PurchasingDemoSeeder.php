<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProviderApplication;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PurchasingDemoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Datos de prueba para el dashboard de Compras.
     * Crea un usuario con rol purchasing y solicitudes de proveedores en distintos estados.
     */
    public function run(): void
    {
        $this->seedPurchasingUser();
        $this->seedProviderApplications();

        $this->command->info('✓ Datos de prueba de Compras generados.');
        $this->command->line('  Compras: compras@demo.com / password: password');
    }

    // -------------------------------------------------------------------------
    // Usuario del equipo de Compras
    // -------------------------------------------------------------------------

    private function seedPurchasingUser(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'compras@demo.com'],
            [
                'name'     => 'Equipo Compras',
                'email'    => 'compras@demo.com',
                'password' => Hash::make('password'),
            ]
        );

        $role = Role::where('name', 'purchasing')->first();

        if ($role && ! $user->hasRole('purchasing')) {
            $user->addRole($role);
        }
    }

    // -------------------------------------------------------------------------
    // Solicitudes de proveedores de prueba
    // -------------------------------------------------------------------------

    private function seedProviderApplications(): void
    {
        $providers = [
            // --- Pendientes ---
            [
                'rfc'             => 'ABC123456DEF',
                'company_name'    => 'Suministros Industriales del Norte S.A. de C.V.',
                'street'          => 'Av. Industrial',
                'number'          => '450',
                'neighborhood'    => 'Parque Industrial',
                'municipality'    => 'Monterrey',
                'state'           => 'Nuevo León',
                'country'         => 'México',
                'cp'              => '64000',
                'web_company'     => 'https://suministrosnorte.com.mx',
                'bank'            => 'BBVA',
                'bank_account'    => 'BBVA Norte',
                'bank_account_number' => '0123456789',
                'approval_chain'  => 'normal',
                'status'          => 'pending',
                'created_at'      => Carbon::now()->subDays(2),
            ],
            [
                'rfc'             => 'XYZ987654GHI',
                'company_name'    => 'Tecnología y Soluciones Avanzadas S.C.',
                'street'          => 'Blvd. Tecnológico',
                'number'          => '120',
                'neighborhood'    => 'Centro',
                'municipality'    => 'Guadalajara',
                'state'           => 'Jalisco',
                'country'         => 'México',
                'cp'              => '44100',
                'web_company'     => null,
                'bank'            => 'Santander',
                'bank_account'    => 'Cuenta Empresarial',
                'bank_account_number' => '9876543210',
                'approval_chain'  => 'especial',
                'status'          => 'pending',
                'created_at'      => Carbon::now()->subDays(1),
            ],
            [
                'rfc'             => 'MNO112233PQR',
                'company_name'    => 'Distribuidora de Materiales Omega',
                'street'          => 'Calle Reforma',
                'number'          => '88',
                'neighborhood'    => 'Reforma',
                'municipality'    => 'Ciudad de México',
                'state'           => 'CDMX',
                'country'         => 'México',
                'cp'              => '06600',
                'web_company'     => 'https://omega-materiales.mx',
                'bank'            => 'Banorte',
                'bank_account'    => 'Cuenta Corriente',
                'bank_account_number' => '1122334455',
                'approval_chain'  => 'normal',
                'status'          => 'pending',
                'created_at'      => Carbon::now()->subHours(5),
            ],
            [
                'rfc'             => 'STU445566VWX',
                'company_name'    => 'Servicios Logísticos Rápidos',
                'street'          => 'Periférico Sur',
                'number'          => '2200',
                'neighborhood'    => 'Pedregal',
                'municipality'    => 'Ciudad de México',
                'state'           => 'CDMX',
                'country'         => 'México',
                'cp'              => '04500',
                'web_company'     => null,
                'bank'            => 'HSBC',
                'bank_account'    => 'Empresa Flex',
                'bank_account_number' => '5544332211',
                'approval_chain'  => 'especial',
                'status'          => 'pending',
                'created_at'      => Carbon::now()->subHours(1),
            ],

            // --- Aprobadas ---
            [
                'rfc'             => 'EFG778899HIJ',
                'company_name'    => 'Constructora Beta Internacional',
                'street'          => 'Av. Constitución',
                'number'          => '500',
                'neighborhood'    => 'Centro Histórico',
                'municipality'    => 'Monterrey',
                'state'           => 'Nuevo León',
                'country'         => 'México',
                'cp'              => '64010',
                'web_company'     => 'https://betaconstruye.mx',
                'bank'            => 'Banamex',
                'bank_account'    => 'Cuenta Maestra',
                'bank_account_number' => '7788990011',
                'approval_chain'  => 'normal',
                'status'          => 'approved',
                'approval_notes'  => 'Documentación completa y validada. RFC verificado en SAT.',
                'created_at'      => Carbon::now()->subDays(10),
            ],
            [
                'rfc'             => 'KLM001122NOP',
                'company_name'    => 'Proveedora de Equipos Eléctricos del Bajío',
                'street'          => 'Blvd. Independencia',
                'number'          => '77',
                'neighborhood'    => 'Industrial',
                'municipality'    => 'León',
                'state'           => 'Guanajuato',
                'country'         => 'México',
                'cp'              => '37000',
                'web_company'     => null,
                'bank'            => 'BBVA',
                'bank_account'    => 'Pyme Plus',
                'bank_account_number' => '0011223344',
                'approval_chain'  => 'normal',
                'status'          => 'approved',
                'approval_notes'  => 'Proveedor verificado. Cuenta bancaria confirmada.',
                'created_at'      => Carbon::now()->subDays(7),
            ],

            // --- Rechazadas ---
            [
                'rfc'             => 'QRS334455TUV',
                'company_name'    => 'Importaciones Globales Express',
                'street'          => 'Calle 5 de Mayo',
                'number'          => '30',
                'neighborhood'    => 'Centro',
                'municipality'    => 'Querétaro',
                'state'           => 'Querétaro',
                'country'         => 'México',
                'cp'              => '76000',
                'web_company'     => null,
                'bank'            => 'Scotiabank',
                'bank_account'    => 'Negocios',
                'bank_account_number' => '3344556677',
                'approval_chain'  => 'especial',
                'status'          => 'rejected',
                'rejection_reason' => 'RFC no localizado en el SAT. Se solicita constancia de situación fiscal actualizada.',
                'created_at'      => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($providers as $data) {
            // Evitar duplicados por RFC
            ProviderApplication::firstOrCreate(
                ['rfc' => $data['rfc']],
                $data
            );
        }
    }
}
