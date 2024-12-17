<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetails extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'phone_number', 'mobile_number', 'mailing_address'];
    protected $table = 'client_contact_details';
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

