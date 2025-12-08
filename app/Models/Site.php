<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'description',
        'is_active',
        'status',
        'response_time',
        'last_checked_at',
        'check_interval',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_checked_at' => 'datetime',
        'response_time' => 'integer',
        'check_interval' => 'integer',
    ];

    /**
     * Scope para sitios activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para sitios que están caídos
     */
    public function scopeDown($query)
    {
        return $query->where('status', 'down');
    }

    /**
     * Scope para sitios operativos
     */
    public function scopeUp($query)
    {
        return $query->where('status', 'up');
    }
}
