<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderApplicationRequest;
use App\Models\ProviderApplication;
use App\Services\ProviderNotificationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProviderApplicationController extends Controller
{
    public function __construct(private ProviderNotificationService $providerNotificationService)
    {
    }

    /**
     * Mostrar formulario público de registro de proveedor
     */
    public function create()
    {
        return view('providers.register');
    }

    /**
     * Guardar solicitud de proveedor
     */
    public function store(ProviderApplicationRequest $request)
    {
        $data = $request->validated();

        // Manejo de archivos PDF
        $folder = 'provider_applications/' . Str::slug($data['rfc']) . '-' . time();

        $bankDataPath = $request->file('bank_data_file')->store($folder, 'public');
        $taxCertificatePath = $request->file('tax_certificate_file')->store($folder, 'public');

        $application = ProviderApplication::create([
            'rfc' => $data['rfc'],
            'company_name' => $data['company_name'],
            'street' => $data['street'],
            'number' => $data['number'],
            'neighborhood' => $data['neighborhood'],
            'municipality' => $data['municipality'],
            'state' => $data['state'],
            'country' => $data['country'],
            'cp' => $data['cp'] ?? null,
            'web_company' => $data['web_company'] ?? null,
            'bank' => $data['bank'] ?? null,
            'bank_account' => $data['bank_account'] ?? null,
            'bank_account_number' => $data['bank_account_number'],
            'approval_chain' => 'normal',
            'status' => 'pending',
            'bank_data_file_path' => $bankDataPath,
            'tax_certificate_file_path' => $taxCertificatePath,
            'user_request_id' => null,
            'user_approve_id' => null,
        ]);

        // Avisar al equipo de Compras (no bloquea al usuario)
        try {
            $this->providerNotificationService->sendIntakeEmail($application);
        } catch (\Throwable $e) {
            Log::warning('No se pudo notificar a Compras sobre nueva solicitud: ' . $e->getMessage());
        }

        return redirect()
            ->route('providers.register.thankyou')
            ->with('success', 'Hemos recibido tu registro. Nuestro equipo de Compras revisará tu información.');
    }

    /**
     * Página de agradecimiento
     */
    public function thankyou()
    {
        return view('providers.thankyou');
    }
}
