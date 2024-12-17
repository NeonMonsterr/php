<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportingAndAnalytics extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'report_type', 'drug_names', 'other_fields'];

    protected $casts = [
        'other_fields' => 'array',
    ];
}

