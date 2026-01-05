<?php

namespace App\Models\Database2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamento extends Model
{
    use HasFactory;

    protected $connection = 'mysql_secondary';
    protected $table = 'departamentos';

    protected $fillable = [
        'name',
        'area_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'depto_id');
    }
}
