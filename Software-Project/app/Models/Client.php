<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['Fname', 'Lname','password','email'];
    protected $table='client';

    public function privateDetails()
    {
        return $this->hasOne(PrivateDetails::class);
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }

    public function contactDetails()
    {
        return $this->hasOne(ContactDetails::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

