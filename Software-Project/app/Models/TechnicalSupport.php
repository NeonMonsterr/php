<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSupport extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tickets_assigned', 'average_resolution_time', 'customer_satisfaction_rating'];

    protected $casts = [
        'tickets_assigned' => 'array',
    ];
}

