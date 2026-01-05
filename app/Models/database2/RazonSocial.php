<?php

namespace App\Models\Database2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RazonSocial extends Model
{
    use HasFactory;

    protected $connection = 'mysql_secondary';
    protected $table = 'razones_sociales';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'business_name_id');
    }
}
