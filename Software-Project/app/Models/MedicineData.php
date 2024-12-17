<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineData extends Model
{
    use HasFactory;

    protected $fillable = ['batch_no', 'drug_name', 'price', 'manufacturer', 'stock_qty', 'expiry_date'];
    public function staff()
    {
        return $this->belongsToMany(PharmacyStaff::class, 'pharmacy_staff_medicine');
    }

    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'medicine_prescription');
    }
}
