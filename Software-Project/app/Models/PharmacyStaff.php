<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyStaff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    public function trainings()
    {
        return $this->belongsToMany(TrainingAndSupport::class, 'pharmacy_staff_training');
    }

    public function medicines()
    {
        return $this->belongsToMany(MedicineData::class, 'pharmacy_staff_medicine');
    }
}
