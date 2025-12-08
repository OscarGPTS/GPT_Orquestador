<?php

namespace App\Http\Controllers;

use App\Models\ProviderApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchasingController extends Controller
{
    /**
     * Mostrar listado de solicitudes de proveedores
     */
    public function index(Request $request)
    {
        $query = ProviderApplication::query();

        // Filtrar por estado
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filtrar por cadena de aprobación
        if ($request->has('approval_chain') && $request->approval_chain) {
            $query->where('approval_chain', $request->approval_chain);
        }

        // Búsqueda por RFC o razón social
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('rfc', 'LIKE', "%$search%")
                  ->orWhere('company_name', 'LIKE', "%$search%");
        }

        // Ordenar por más recientes primero
        $applications = $query->orderBy('created_at', 'DESC')->paginate(15);

        return view('purchasing.applications.index', [
            'applications' => $applications,
            'statuses' => ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'],
            'approvalChains' => ['normal' => 'Normal', 'special' => 'Especial'],
        ]);
    }

    /**
     * Mostrar detalle de solicitud
     */
    public function show(ProviderApplication $application)
    {
        return view('purchasing.applications.show', [
            'application' => $application,
            'approvalChains' => ['normal' => 'Normal', 'special' => 'Especial'],
        ]);
    }

    /**
     * Mostrar formulario de aprobación/rechazo
     */
    public function edit(ProviderApplication $application)
    {
        return view('purchasing.applications.edit', [
            'application' => $application,
            'approvalChains' => ['normal' => 'Normal', 'special' => 'Especial'],
        ]);
    }

    /**
     * Procesar aprobación de solicitud
     * 
     * IMPORTANTE: Este método prepara los datos para enviar a otra BD o API.
     * La lógica de envío debe ser implementada según la integración requerida.
     */
    public function approve(Request $request, ProviderApplication $application)
    {
        $validated = $request->validate([
            'approval_chain' => 'required|in:normal,special',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Actualizar estado y cadena de aprobación
        $application->update([
            'status' => 'approved',
            'approval_chain' => $validated['approval_chain'],
            'user_approve_id' => Auth::id(),
            'approval_notes' => $validated['notes'] ?? null,
        ]);

        // Preparar datos para envío (BD externa o API)
        $dataToSend = $this->prepareApprovalData($application, $validated);

        // ESPACIO RESERVADO: Aquí irá la lógica de envío a BD externa o API
        // Ejemplos de posibles implementaciones:
        // - $this->sendToExternalDatabase($dataToSend);
        // - $this->sendToExternalAPI($dataToSend);
        // - Queue::push(new SendApprovalJob($dataToSend));

        $this->sendApprovalData($dataToSend);

        return redirect()
            ->route('purchasing.applications.index')
            ->with('success', 'Solicitud aprobada exitosamente como ' . $validated['approval_chain'] . '.');
    }

    /**
     * Procesar rechazo de solicitud
     */
    public function reject(Request $request, ProviderApplication $application)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
            'approval_chain' => 'required|in:normal,special',
        ]);

        $application->update([
            'status' => 'rejected',
            'approval_chain' => $validated['approval_chain'],
            'user_approve_id' => Auth::id(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // Preparar datos para envío (BD externa o API)
        $dataToSend = $this->prepareRejectionData($application, $validated);

        // ESPACIO RESERVADO: Aquí irá la lógica de envío a BD externa o API
        $this->sendRejectionData($dataToSend);

        return redirect()
            ->route('purchasing.applications.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Descargar documentos de la solicitud
     */
    public function downloadDocument(ProviderApplication $application, $documentType)
    {
        $filePath = null;

        if ($documentType === 'bank_data' && $application->bank_data_file_path) {
            $filePath = $application->bank_data_file_path;
        } elseif ($documentType === 'tax_certificate' && $application->tax_certificate_file_path) {
            $filePath = $application->tax_certificate_file_path;
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Documento no encontrado');
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Preparar datos de aprobación para envío
     */
    private function prepareApprovalData(ProviderApplication $application, array $validated): array
    {
        return [
            'type' => 'approval',
            'application_id' => $application->id,
            'status' => 'approved',
            'approval_chain' => $validated['approval_chain'],
            'provider_data' => [
                'rfc' => $application->rfc,
                'company_name' => $application->company_name,
                'bank_account_number' => $application->bank_account_number,
                'email' => $application->email ?? null,
            ],
            'approved_by' => Auth::user()->email,
            'approved_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ];
    }

    /**
     * Preparar datos de rechazo para envío
     */
    private function prepareRejectionData(ProviderApplication $application, array $validated): array
    {
        return [
            'type' => 'rejection',
            'application_id' => $application->id,
            'status' => 'rejected',
            'approval_chain' => $validated['approval_chain'],
            'provider_data' => [
                'rfc' => $application->rfc,
                'company_name' => $application->company_name,
            ],
            'rejected_by' => Auth::user()->email,
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ];
    }

    /**
     * ESPACIO RESERVADO: Enviar datos de aprobación
     * 
     * Implementar según necesidad:
     * - Enviar a base de datos externa
     * - Enviar a API externa
     * - Guardar en queue para procesamiento asíncrono
     */
    private function sendApprovalData(array $data): void
    {
        // TODO: Implementar lógica de envío
        // Ejemplo para BD:
        // DB::connection('external')->table('approvals')->insert($data);
        
        // Ejemplo para API:
        // Http::post('https://api.example.com/approvals', $data);
        
        // Ejemplo para Queue:
        // dispatch(new SendApprovalToExternalSystem($data));

        \Log::info('Approval data prepared for external system', $data);
    }

    /**
     * ESPACIO RESERVADO: Enviar datos de rechazo
     */
    private function sendRejectionData(array $data): void
    {
        // TODO: Implementar lógica de envío
        \Log::info('Rejection data prepared for external system', $data);
    }
}
