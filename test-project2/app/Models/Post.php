<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='posts';
    protected $fillable=['name', 'email', 'password'];
    protected $hidden=['email_verified_at','remember_token'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
