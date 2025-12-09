<?php

namespace App\Http\Controllers;

use App\Models\ProviderApplication;
use App\Services\GoogleDriveService;
use App\Services\ProviderNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $applications = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('purchasing.applications.index', [
            'applications' => $applications,
        ]);
    }

    /**
     * Mostrar detalle de solicitud
     */
    public function show(ProviderApplication $application)
    {
        return view('purchasing.applications.show', [
            'application' => $application,
        ]);
    }

    /**
     * Mostrar formulario de aprobación/rechazo
     */
    public function edit(ProviderApplication $application)
    {
        return view('purchasing.applications.edit', [
            'application' => $application,
        ]);
    }

    /**
     * Procesar aprobación de solicitud
     * 
     * Cuando se aprueba una solicitud:
     * 1. Se actualiza el estado a "approved"
     * 2. Se invoca GoogleDriveService para crear carpeta y subir documentos
     * 3. Se invoca ProviderNotificationService para enviar correo de aprobación
     * 4. Se envían datos a sistema externo
     */
    public function approve(Request $request, ProviderApplication $application)
    {
        $validated = $request->validate([
            'approval_chain' => 'required|in:normal,special',
            'approval_notes' => 'nullable|string|max:1000',
        ]);

        // Actualizar estado y cadena de aprobación
        $application->update([
            'status' => 'approved',
            'approval_chain' => $validated['approval_chain'],
            'user_approve_id' => Auth::id(),
            'approval_notes' => $validated['approval_notes'] ?? null,
        ]);

        // 1. Intentar crear carpeta en Google Drive y subir documentos
        $this->processGoogleDriveIntegration($application);

        // 2. Enviar correo de aprobación
        $this->sendApprovalNotification($application, $validated['approval_chain'], $validated['approval_notes'] ?? null);

        // 3. Preparar y enviar datos a sistema externo
        $dataToSend = $this->prepareApprovalData($application, $validated);
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
            'rejection_reason' => 'nullable|string|max:500',
            'approval_chain' => 'required|in:normal,special',
        ]);

        $application->update([
            'status' => 'rejected',
            'approval_chain' => $validated['approval_chain'],
            'user_approve_id' => Auth::id(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // Enviar correo de rechazo
        $this->sendRejectionNotification(
            $application,
            $validated['rejection_reason'],
            $validated['approval_chain']
        );

        // Preparar datos para envío (BD externa o API)
        $dataToSend = $this->prepareRejectionData($application, $validated);
        $this->sendRejectionData($dataToSend);

        return redirect()
            ->route('purchasing.applications.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Procesar integración con Google Drive
     */
    private function processGoogleDriveIntegration(ProviderApplication $application): void
    {
        if (!env('GOOGLE_DRIVE_ENABLED', false)) {
            Log::info('Google Drive integration disabled');
            return;
        }

        try {
            $googleDrive = new GoogleDriveService();
            
            // ID de la carpeta padre en Google Drive (opcional, puede ser null)
            $parentFolderId = env('GOOGLE_DRIVE_PROVIDERS_FOLDER_ID');
            
            $googleDriveFolderId = $googleDrive->createProviderFolder($application, $parentFolderId);
            
            // Guardar el ID de la carpeta de Google Drive en la aplicación
            $application->update([
                'google_drive_folder_id' => $googleDriveFolderId,
            ]);

            Log::info("Google Drive folder created successfully: $googleDriveFolderId");
        } catch (\Exception $e) {
            Log::warning('Could not create Google Drive folder: ' . $e->getMessage());
            // Continuar sin detener el flujo si falla Google Drive
        }
    }

    /**
     * Enviar correo de aprobación
     */
    private function sendApprovalNotification(
        ProviderApplication $application,
        string $approvalChain,
        ?string $approvalNotes = null
    ): void {
        try {
            $notificationService = new ProviderNotificationService();
            $notificationService->sendApprovalEmail($application, $approvalChain, $approvalNotes);
            Log::info("Approval notification sent for application: {$application->id}");
        } catch (\Exception $e) {
            Log::warning('Could not send approval notification: ' . $e->getMessage());
        }
    }

    /**
     * Enviar correo de rechazo
     */
    private function sendRejectionNotification(
        ProviderApplication $application,
        ?string $rejectionReason,
        string $approvalChain
    ): void {
        try {
            $notificationService = new ProviderNotificationService();
            $notificationService->sendRejectionEmail($application, $rejectionReason, $approvalChain);
            Log::info("Rejection notification sent for application: {$application->id}");
        } catch (\Exception $e) {
            Log::warning('Could not send rejection notification: ' . $e->getMessage());
        }
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
            'notes' => $validated['approval_notes'] ?? null,
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

        Log::info('Approval data prepared for external system', $data);
    }

    /**
     * ESPACIO RESERVADO: Enviar datos de rechazo
     */
    private function sendRejectionData(array $data): void
    {
        // TODO: Implementar lógica de envío
        Log::info('Rejection data prepared for external system', $data);
    }
}
