<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'type',
        'status',
        'start_date',
        'end_date',
    ];
    protected function casts(): array
    {
        return [
            'type' => 'string', // For enum (semester/monthly)
            'status' => 'string', // For enum (active/expired/canceled)
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->where('end_date', '>=', now())
                    ->orWhereNull('end_date');
            });
    }
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
            ->orWhere(function ($q) {
                $q->where('end_date', '<', now())
                    ->where('status', '!=', 'canceled');
            });
    }
    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
