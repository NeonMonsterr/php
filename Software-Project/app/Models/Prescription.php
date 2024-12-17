<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'staff_id', 'pres_date'];
    protected $table='prescription';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function staff()
    {
        return $this->belongsTo(PharmacyStaff::class);
    }
    public function medicines()
    {
        return $this->belongsToMany(MedicineData::class, 'medicine_prescription');
    }
}
