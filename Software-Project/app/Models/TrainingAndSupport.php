<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAndSupport extends Model
{
    use HasFactory;

    protected $fillable = ["knowledge_base"];  // Make sure this includes the foreign key
    protected $table = 'training_and_support';

    public function trainingPackages()
    {
        return $this->hasMany(TrainingPackages::class, 'support_id');  // Use 'support_id' as the foreign key
    }
    public function staff()
    {
        return $this->belongsToMany(PharmacyStaff::class, 'pharmacy_staff_training');
    }
}
