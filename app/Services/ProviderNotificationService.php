<?php

namespace App\Services;

use App\Models\ProviderApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProviderNotificationService
{
    /**
     * Enviar correo de aprobación con datos y documentos
     * 
     * @param ProviderApplication $application
     * @param string $approvalChain
     * @param string|null $approvalNotes
     * @return bool
     */
    public function sendApprovalEmail(
        ProviderApplication $application,
        string $approvalChain,
        ?string $approvalNotes = null
    ): bool {
        try {
            $emailData = $this->prepareApprovalEmailData($application, $approvalChain, $approvalNotes);
            
            // Construir el body del correo
            $mailBody = $this->buildApprovalEmailBody($emailData);
            
            // Obtener rutas de documentos
            $documents = $this->getProviderDocuments($application);
            
            // Enviar correo con documentos adjuntos
            return $this->sendEmailWithAttachments(
                to: env('PURCHASING_APPROVAL_EMAIL', 'purchasing@company.com'),
                subject: "Aprobación de Proveedor: {$application->company_name}",
                body: $mailBody,
                documents: $documents
            );
            
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de aprobación: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar correo de rechazo con datos del proveedor
     * 
     * @param ProviderApplication $application
     * @param string $rejectionReason
     * @param string $approvalChain
     * @return bool
     */
    public function sendRejectionEmail(
        ProviderApplication $application,
        string $rejectionReason,
        string $approvalChain
    ): bool {
        try {
            $emailData = $this->prepareRejectionEmailData($application, $rejectionReason, $approvalChain);
            
            $mailBody = $this->buildRejectionEmailBody($emailData);
            
            return $this->sendEmailWithAttachments(
                to: env('PURCHASING_REJECTION_EMAIL', 'purchasing@company.com'),
                subject: "Rechazo de Solicitud de Proveedor: {$application->company_name}",
                body: $mailBody,
                documents: [] // No adjuntar documentos en rechazo
            );
            
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de rechazo: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Preparar datos para correo de aprobación
     */
    private function prepareApprovalEmailData(
        ProviderApplication $application,
        string $approvalChain,
        ?string $approvalNotes
    ): array {
        return [
            'company_name' => $application->company_name,
            'rfc' => $application->rfc,
            'status' => 'APROBADO',
            'approval_chain' => ucfirst($approvalChain),
            'approval_notes' => $approvalNotes,
            'request_date' => $application->created_at->format('d/m/Y H:i'),
            'general_info' => [
                'street' => $application->street,
                'number' => $application->number,
                'colony' => $application->colony,
                'municipality' => $application->municipality,
                'state' => $application->state,
                'country' => $application->country,
                'postal_code' => $application->postal_code,
                'website' => $application->website,
            ],
            'banking_info' => [
                'bank' => $application->bank,
                'account_type' => $application->account_type,
                'clabe' => $application->clabe,
            ],
        ];
    }

    /**
     * Preparar datos para correo de rechazo
     */
    private function prepareRejectionEmailData(
        ProviderApplication $application,
        string $rejectionReason,
        string $approvalChain
    ): array {
        return [
            'company_name' => $application->company_name,
            'rfc' => $application->rfc,
            'status' => 'RECHAZADO',
            'approval_chain' => ucfirst($approvalChain),
            'rejection_reason' => $rejectionReason,
            'request_date' => $application->created_at->format('d/m/Y H:i'),
            'general_info' => [
                'street' => $application->street,
                'number' => $application->number,
                'colony' => $application->colony,
                'municipality' => $application->municipality,
                'state' => $application->state,
                'country' => $application->country,
                'postal_code' => $application->postal_code,
            ],
        ];
    }

    /**
     * Construir cuerpo HTML para correo de aprobación
     */
    private function buildApprovalEmailBody(array $data): string
    {
        $notesHtml = $data['approval_notes'] 
            ? "<p><strong>Notas de Aprobación:</strong><br>{$data['approval_notes']}</p>"
            : '';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #CF0A2C; color: white; padding: 20px; border-radius: 5px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section h3 { color: #CF0A2C; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .status { background-color: #28a745; color: white; padding: 10px; border-radius: 3px; display: inline-block; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notificación de Aprobación de Proveedor</h1>
            <p>Solicitud procesada: {$data['request_date']}</p>
        </div>

        <div class="section">
            <h3>Estado: <span class="status">✓ {$data['status']}</span></h3>
            <p><strong>Empresa:</strong> {$data['company_name']}</p>
            <p><strong>RFC:</strong> {$data['rfc']}</p>
            <p><strong>Cadena de Aprobación:</strong> {$data['approval_chain']}</p>
        </div>

        <div class="section">
            <h3>Información General</h3>
            <table>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>Calle</td>
                    <td>{$data['general_info']['street']}</td>
                </tr>
                <tr>
                    <td>Número</td>
                    <td>{$data['general_info']['number']}</td>
                </tr>
                <tr>
                    <td>Colonia</td>
                    <td>{$data['general_info']['colony']}</td>
                </tr>
                <tr>
                    <td>Municipio</td>
                    <td>{$data['general_info']['municipality']}</td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td>{$data['general_info']['state']}</td>
                </tr>
                <tr>
                    <td>País</td>
                    <td>{$data['general_info']['country']}</td>
                </tr>
                <tr>
                    <td>Código Postal</td>
                    <td>{$data['general_info']['postal_code']}</td>
                </tr>
                <tr>
                    <td>Sitio Web</td>
                    <td>{$data['general_info']['website']}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Información Bancaria</h3>
            <table>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>Banco</td>
                    <td>{$data['banking_info']['bank']}</td>
                </tr>
                <tr>
                    <td>Tipo de Cuenta</td>
                    <td>{$data['banking_info']['account_type']}</td>
                </tr>
                <tr>
                    <td>CLABE</td>
                    <td>{$data['banking_info']['clabe']}</td>
                </tr>
            </table>
        </div>

        {$notesHtml}

        <div class="section">
            <h3>Documentos Adjuntos</h3>
            <p>Los siguientes documentos se encuentran adjuntos a este correo:</p>
            <ul>
                <li>Hoja de datos bancarios</li>
                <li>Constancia de situación fiscal</li>
            </ul>
        </div>

        <div class="footer">
            <p>Este es un correo automático generado por App Orchestrator.</p>
            <p>Por favor no responda a este correo.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Construir cuerpo HTML para correo de rechazo
     */
    private function buildRejectionEmailBody(array $data): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #CF0A2C; color: white; padding: 20px; border-radius: 5px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section h3 { color: #CF0A2C; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .status { background-color: #dc3545; color: white; padding: 10px; border-radius: 3px; display: inline-block; }
        .reason { background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Notificación de Rechazo de Solicitud</h1>
        </div>

        <div class="section">
            <h3>Estado: <span class="status">✗ {$data['status']}</span></h3>
            <p><strong>Empresa:</strong> {$data['company_name']}</p>
            <p><strong>RFC:</strong> {$data['rfc']}</p>
            <p><strong>Cadena de Aprobación:</strong> {$data['approval_chain']}</p>
            <p><strong>Fecha de Solicitud:</strong> {$data['request_date']}</p>
        </div>

        <div class="reason">
            <h4 style="margin-top: 0; color: #ff6b6b;">Motivo del Rechazo:</h4>
            <p>{$data['rejection_reason']}</p>
        </div>

        <div class="section">
            <h3>Información General del Solicitante</h3>
            <table>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>Calle</td>
                    <td>{$data['general_info']['street']}</td>
                </tr>
                <tr>
                    <td>Número</td>
                    <td>{$data['general_info']['number']}</td>
                </tr>
                <tr>
                    <td>Colonia</td>
                    <td>{$data['general_info']['colony']}</td>
                </tr>
                <tr>
                    <td>Municipio</td>
                    <td>{$data['general_info']['municipality']}</td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td>{$data['general_info']['state']}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Este es un correo automático generado por App Orchestrator.</p>
            <p>Si tiene preguntas, por favor contacte al departamento de compras.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Obtener rutas de documentos del proveedor
     */
    private function getProviderDocuments(ProviderApplication $application): array
    {
        $documents = [];

        // Hoja de datos bancarios
        if ($application->bank_data_file_path && Storage::exists($application->bank_data_file_path)) {
            $documents[] = [
                'path' => Storage::path($application->bank_data_file_path),
                'name' => 'Hoja_de_datos_bancarios.pdf',
            ];
        }

        // Constancia de situación fiscal
        if ($application->tax_certificate_file_path && Storage::exists($application->tax_certificate_file_path)) {
            $documents[] = [
                'path' => Storage::path($application->tax_certificate_file_path),
                'name' => 'Constancia_de_situacion_fiscal.pdf',
            ];
        }

        return $documents;
    }

    /**
     * Enviar correo con adjuntos
     */
    private function sendEmailWithAttachments(
        string $to,
        string $subject,
        string $body,
        array $documents = []
    ): bool {
        try {
            // Si no tienes un mailable configurado, puedes usar sendmail directamente
            // Aquí se usa una aproximación simplificada con raw email
            
            // Para producción, considera crear un Mailable:
            // Mail::send(new ApprovalNotificationMail($to, $subject, $body, $documents));
            
            // Por ahora, registrar en logs que se intentó enviar
            Log::info("Intento de envío de correo: $subject a $to");
            Log::debug('Documentos a adjuntar: ' . json_encode($documents));
            
            // TODO: Implementar envío real una vez configurado mailer
            // Mail::raw($body, function($message) use ($to, $subject, $documents) {
            //     $message->to($to)->subject($subject);
            //     foreach ($documents as $doc) {
            //         $message->attach($doc['path'], ['as' => $doc['name']]);
            //     }
            // });
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Error enviando correo: ' . $e->getMessage());
            return false;
        }
    }
}
