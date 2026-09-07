<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_uuid',
        'title',
        'description',
        'scheduled_at',
        'location',
        'status',
        'total_seats',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->public_uuid) {
                $model->public_uuid = Str::uuid();
            }
        });
    }

    /**
     * Get attendances for this meeting
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get members who attended
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'attendances')
            ->withPivot('checked_in_at', 'seat_number', 'status', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the QR code URL for attendance scanning
     */
    public function getAttendanceQrUrl(): string
    {
        $url = route('meetings.attendance-scan', ['uuid' => $this->public_uuid]);
        $size = '300x300';
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}&data=" . urlencode($url);
    }

    /**
     * Get total attendees
     */
    public function getTotalAttendeesAttribute(): int
    {
        return $this->attendances()->where('status', 'present')->count();
    }

    /**
     * Get next available seat
     */
    public function getNextAvailableSeat(): ?int
    {
        if (!$this->total_seats) {
            return null;
        }

        $usedSeats = $this->attendances()
            ->whereNotNull('seat_number')
            ->pluck('seat_number')
            ->toArray();

        for ($i = 1; $i <= $this->total_seats; $i++) {
            if (!in_array($i, $usedSeats)) {
                return $i;
            }
        }

        return null;
    }
}
