<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'conditions', 'allergies', 'medications', 'immunizations', 'procedures', 'notes'];
    protected $table='client_medical_history';
    protected $casts = [
        'conditions' => 'array',
        'allergies' => 'array',
        'medications' => 'array',
        'immunizations' => 'array',
        'procedures' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

