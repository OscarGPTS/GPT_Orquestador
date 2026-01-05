<?php

namespace App\Models\Database2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;

    protected $connection = 'mysql_secondary';
    protected $table = 'areas';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'area_id');
    }
}
