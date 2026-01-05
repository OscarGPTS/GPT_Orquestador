<?php

namespace App\Models\Database2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'mysql_secondary';
    protected $table = 'users';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'uuid',
        'last_name',
        'first_name',
        'business_name_id',
        'admission',
        'job_id',
        'boss_id',
        'email',
        'phone',
        'profile_image',
        'cedula',
        'active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'admission' => 'datetime:Y-m-d',
        'active' => 'boolean',
    ];

    public function nombre()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Relaciones
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function razonSocial()
    {
        return $this->belongsTo(RazonSocial::class, 'business_name_id');
    }

    public function jefe()
    {
        return $this->belongsTo(User::class, 'boss_id');
    }

    public function subordinados()
    {
        return $this->hasMany(User::class, 'boss_id');
    }
}
