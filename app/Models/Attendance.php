<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'member_id',
        'checked_in_at',
        'seat_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the meeting
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Get the member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Mark member as present
     */
    public function markPresent()
    {
        $this->update([
            'checked_in_at' => now(),
            'status' => 'present',
        ]);

        return $this;
    }

    /**
     * Assign seat
     */
    public function assignSeat(int $seatNumber)
    {
        $this->update(['seat_number' => $seatNumber]);
        return $this;
    }
}
