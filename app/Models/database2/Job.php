<?php

namespace App\Models\Database2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $connection = 'mysql_secondary';
    protected $table = 'jobs';

    protected $fillable = [
        'name',
        'depto_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'depto_id');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'job_id');
    }
}

