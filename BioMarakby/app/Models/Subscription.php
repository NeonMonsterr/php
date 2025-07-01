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
            'type' => 'string',
            'status' => 'string',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
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
        return $query->where(function ($q) {
            $q->where('status', 'expired')
                ->orWhere(function ($q2) {
                    $q2->where('end_date', '<', now())
                        ->where('status', '!=', 'canceled');
                });
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

    public function updateStatusBasedOnDates()
    {
        // Skip if already canceled
        if ($this->status === 'canceled') {
            return;
        }

        $now = now();
        $newStatus = $this->status;

        if ($this->start_date && $this->start_date->isPast() &&
            (!$this->end_date || $this->end_date->isFuture())) {
            $newStatus = 'active';
        }
        elseif ($this->end_date && $this->end_date->isPast()) {
            $newStatus = 'expired';
        }

        if ($newStatus !== $this->status) {
            $this->status = $newStatus;
            $this->save();
        }
}
}
