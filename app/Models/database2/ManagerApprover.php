<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerApprover extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'departamento_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who is the approver.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that this approver can approve.
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Scope para obtener solo aprobadores activos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Obtener todos los departamentos que un usuario puede aprobar.
     */
    public static function getDepartmentsForUser($userId)
    {
        return static::where('user_id', $userId)
            ->where('is_active', true)
            ->pluck('departamento_id')
            ->toArray();
    }

    /**
     * Verificar si un usuario puede aprobar solicitudes de un departamento.
     */
    public static function canApprove($userId, $departamentoId)
    {
        return static::where('user_id', $userId)
            ->where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Obtener todos los usuarios que pueden aprobar un departamento específico.
     */
    public static function getApproversForDepartment($departamentoId)
    {
        return static::where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->with('user')
            ->get()
            ->pluck('user');
    }

    /**
     * Obtener el jefe asignado para el departamento de un usuario.
     * Retorna el ID del primer jefe activo asignado o null si no hay ninguno.
     */
    public static function getManagerForDepartment($departamentoId)
    {
        $approver = static::where('departamento_id', $departamentoId)
            ->where('is_active', true)
            ->with('user')
            ->first();

        return $approver ? $approver->user_id : null;
    }
}
