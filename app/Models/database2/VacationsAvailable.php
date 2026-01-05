<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationsAvailable extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'days_availables',
        'dv',
        'days_enjoyed',
        'days_reserved',
        'date_start',
        'date_end',
        'cutoff_date',
        'is_historical',
        'status',
        'users_id',
    ];

    protected $casts = [
        'days_availables' => 'decimal:2',
        'period' => 'integer',
        'dv' => 'integer',
        'days_enjoyed' => 'integer',
        'days_reserved' => 'decimal:2',
        'date_start' => 'date',
        'date_end' => 'date',
        'cutoff_date' => 'date',
        'is_historical' => 'boolean',
    ];

    /**
     * Get the user that owns the vacation available record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the period options.
     */
    public static function getPeriodOptions(): array
    {
        return [
            1 => 'Período 1',
            2 => 'Período 2',
            3 => 'Período 3',
        ];
    }

    /**
     * Get the period name.
     */
    public function getPeriodNameAttribute(): string
    {
        return self::getPeriodOptions()[$this->period] ?? 'Desconocido';
    }
}