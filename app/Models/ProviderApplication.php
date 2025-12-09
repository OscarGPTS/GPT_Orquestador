<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderApplication extends Model
{
    protected $fillable = [
        'rfc',
        'company_name',
        'street',
        'number',
        'neighborhood',
        'municipality',
        'state',
        'country',
        'cp',
        'web_company',
        'bank',
        'bank_account',
        'bank_account_number',
        'approval_chain',
        'status',
        'user_request_id',
        'user_approve_id',
        'bank_data_file_path',
        'tax_certificate_file_path',
        'approval_notes',
        'rejection_reason',
        'google_drive_folder_id',
    ];

    protected $casts = [
        'user_request_id' => 'integer',
        'user_approve_id' => 'integer',
    ];
}
