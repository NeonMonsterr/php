<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'total_sales', 'num_transactions', 'sales_by_drug'];

    protected $casts = [
        'sales_by_drug' => 'array',
    ];
}
