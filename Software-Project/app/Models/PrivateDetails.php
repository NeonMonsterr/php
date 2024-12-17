<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateDetails extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'ssn', 'date_of_birth'];
    protected $table='client_private_details';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

