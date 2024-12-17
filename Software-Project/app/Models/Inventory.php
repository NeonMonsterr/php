<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'dosage', 'unit_price', 'stock_level', 'reorder_level', 'medicine_id']; // Add medicine_id to fillable
    protected $table='inventory';
    protected $primaryKey = 'medicine_id'; // Tell Eloquent to use medicine_id as the primary key
    public $incrementing = false; // Since it's not an auto-incrementing ID, set this to false
    protected $keyType = 'string'; // If the primary key is a string, set the key type to string (adjust this as needed)

}
