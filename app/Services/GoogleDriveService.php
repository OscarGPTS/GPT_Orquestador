<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    private $client;
    private $driveService;
    private $sheetsService;

    public function __construct()
    {
        $this->initializeClient();
    }

    /**
     * Inicializar cliente de Google
     */
    private function initializeClient()
    {
        $this->client = new Client();
        
        // Usar credenciales desde archivo JSON o variables de entorno
        $credentialsPath = storage_path('app/google-credentials.json');
        
        if (file_exists($credentialsPath)) {
            $this->client->setAuthConfig($credentialsPath);
        } else {
            // Alternativa: usar variables de entorno
            $this->client->setAuthConfig([
                'type' => 'service_account',
                'project_id' => env('GOOGLE_PROJECT_ID'),
                'private_key_id' => env('GOOGLE_PRIVATE_KEY_ID'),
                'private_key' => env('GOOGLE_PRIVATE_KEY'),
                'client_email' => env('GOOGLE_CLIENT_EMAIL'),
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            ]);
        }

        $this->client->setScopes([
            Drive::DRIVE,
            Sheets::SPREADSHEETS,
        ]);

        $this->driveService = new Drive($this->client);
        $this->sheetsService = new Sheets($this->client);
    }

    /**
     * Crear carpeta del proveedor en Google Drive y subir documentos
     */
    public function createProviderFolder($application, $parentFolderId = null)
    {
        try {
            // Crear carpeta con nombre del proveedor
            $folderName = $this->sanitizeFolderName($application->company_name);
            $folderId = $this->createFolder($folderName, $parentFolderId);

            if (!$folderId) {
                throw new \Exception('No se pudo crear la carpeta en Google Drive');
            }

            // Subir documentos del proveedor
            $this->uploadProviderDocuments($application, $folderId);

            // Crear y subir hoja de datos en Google Sheets
            $this->createAndUploadProviderSheet($application, $folderId);

            return $folderId;
        } catch (\Exception $e) {
            Log::error('Error al crear carpeta en Google Drive: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Crear carpeta en Google Drive
     */
    private function createFolder($folderName, $parentFolderId = null)
    {
        try {
            $fileMetadata = new Drive\DriveFile([
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
            ]);

            if ($parentFolderId) {
                $fileMetadata->setParents([$parentFolderId]);
            }

            $file = $this->driveService->files->create($fileMetadata, [
                'fields' => 'id',
            ]);

            Log::info("Carpeta '{$folderName}' creada en Google Drive con ID: {$file->id}");
            return $file->id;
        } catch (\Exception $e) {
            Log::error('Error al crear carpeta: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Subir documentos del proveedor
     */
    private function uploadProviderDocuments($application, $folderId)
    {
        // Subir hoja de datos bancarios
        if ($application->bank_data_file_path) {
            $this->uploadFile(
                $application->bank_data_file_path,
                'Hoja_de_datos_bancarios.pdf',
                $folderId
            );
        }

        // Subir constancia de situación fiscal
        if ($application->tax_certificate_file_path) {
            $this->uploadFile(
                $application->tax_certificate_file_path,
                'Constancia_de_situacion_fiscal.pdf',
                $folderId
            );
        }
    }

    /**
     * Subir archivo a Google Drive
     */
    private function uploadFile($localPath, $fileName, $folderId)
    {
        try {
            // Obtener contenido del archivo local
            $fileContent = Storage::disk('public')->get($localPath);

            $fileMetadata = new Drive\DriveFile([
                'name' => $fileName,
                'parents' => [$folderId],
            ]);

            // Detectar tipo MIME
            $mimeType = $this->getMimeType($fileName);

            $this->driveService->files->create(
                $fileMetadata,
                [
                    'data' => $fileContent,
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart',
                    'fields' => 'id',
                ]
            );

            Log::info("Archivo '{$fileName}' subido a Google Drive");
        } catch (\Exception $e) {
            Log::error("Error al subir archivo '{$fileName}': " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Crear hoja de cálculo con datos del proveedor
     */
    private function createAndUploadProviderSheet($application, $folderId)
    {
        try {
            $spreadsheetTitle = $this->sanitizeFolderName($application->company_name) . ' - Datos';

            // Crear nuevo spreadsheet
            $spreadsheet = new Sheets\Spreadsheet([
                'properties' => new Sheets\SpreadsheetProperties([
                    'title' => $spreadsheetTitle,
                ]),
            ]);

            $spreadsheet = $this->sheetsService->spreadsheets->create($spreadsheet);
            $spreadsheetId = $spreadsheet->getSpreadsheetId();

            // Mover el archivo a la carpeta del proveedor
            $this->moveFileToFolder($spreadsheetId, $folderId);

            // Llenar la hoja con datos
            $this->populateProviderSheet($spreadsheetId, $application);

            Log::info("Hoja de cálculo '{$spreadsheetTitle}' creada en Google Drive");
        } catch (\Exception $e) {
            Log::error('Error al crear hoja de cálculo: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Llenar la hoja de cálculo con datos del proveedor
     */
    private function populateProviderSheet($spreadsheetId, $application)
    {
        $requests = [
            [
                'updateCells' => [
                    'range' => [
                        'sheetId' => 0,
                        'rowIndex' => 0,
                        'columnIndex' => 0,
                    ],
                    'rows' => $this->buildDataRows($application),
                    'fields' => 'userEnteredValue,userEnteredFormat',
                ],
            ],
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $this->sheetsService->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }

    /**
     * Construir filas de datos para la hoja de cálculo
     */
    private function buildDataRows($application)
    {
        $rows = [];

        // Encabezados
        $headers = ['Campo', 'Valor'];
        $headerCells = [];
        foreach ($headers as $header) {
            $headerCells[] = new Sheets\CellData([
                'userEnteredValue' => new Sheets\ExtendedValue(['stringValue' => $header]),
                'userEnteredFormat' => new Sheets\CellFormat([
                    'backgroundColor' => new Sheets\Color(['red' => 0.2, 'green' => 0.2, 'blue' => 0.2]),
                    'textFormat' => new Sheets\TextFormat(['bold' => true, 'foregroundColor' => new Sheets\Color(['red' => 1, 'green' => 1, 'blue' => 1])]),
                ]),
            ]);
        }
        $rows[] = new Sheets\RowData(['values' => $headerCells]);

        // Datos del proveedor
        $data = [
            'RFC' => $application->rfc,
            'Razón Social' => $application->company_name,
            'Calle' => $application->street,
            'Número' => $application->number,
            'Colonia' => $application->neighborhood,
            'Municipio' => $application->municipality,
            'Estado' => $application->state,
            'País' => $application->country,
            'Código Postal' => $application->cp,
            'Sitio Web' => $application->web_company,
            'Banco' => $application->bank,
            'Cuenta Bancaria' => $application->bank_account,
            'CLABE' => $application->bank_account_number,
            'Cadena de Aprobación' => ucfirst($application->approval_chain),
            'Fecha de Solicitud' => $application->created_at->format('d/m/Y H:i'),
            'Estado' => ucfirst($application->status),
        ];

        foreach ($data as $field => $value) {
            $cells = [
                new Sheets\CellData([
                    'userEnteredValue' => new Sheets\ExtendedValue(['stringValue' => $field]),
                    'userEnteredFormat' => new Sheets\CellFormat([
                        'textFormat' => new Sheets\TextFormat(['bold' => true]),
                    ]),
                ]),
                new Sheets\CellData([
                    'userEnteredValue' => new Sheets\ExtendedValue(['stringValue' => (string) $value]),
                ]),
            ];
            $rows[] = new Sheets\RowData(['values' => $cells]);
        }

        return $rows;
    }

    /**
     * Mover archivo a una carpeta
     */
    private function moveFileToFolder($fileId, $folderId)
    {
        try {
            // Obtener el archivo actual
            $file = $this->driveService->files->get($fileId, ['fields' => 'parents']);
            $previousParents = implode(',', $file->getParents());

            // Mover a la nueva carpeta
            $this->driveService->files->update(
                $fileId,
                new Drive\DriveFile(),
                [
                    'addParents' => $folderId,
                    'removeParents' => $previousParents,
                    'fields' => 'id,parents',
                ]
            );

            Log::info("Archivo movido a carpeta con ID: {$folderId}");
        } catch (\Exception $e) {
            Log::error('Error al mover archivo: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sanitizar nombre de carpeta
     */
    private function sanitizeFolderName($name)
    {
        // Remover caracteres especiales
        $name = preg_replace('/[^a-zA-Z0-9\s\-áéíóúàèìòùäëïöüâêîôûãõñç]/', '', $name);
        // Remover espacios múltiples
        $name = preg_replace('/\s+/', ' ', trim($name));
        return $name;
    }

    /**
     * Obtener tipo MIME según la extensión
     */
    private function getMimeType($fileName)
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
