<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'surname',
        'firstname',
        'middlename',
        'position',
        'phone',
        'dob',
        'state',
        'pscode',
        'image',
        'category',
        'public_uuid',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dob' => 'date',
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
     * Get the full name of the member.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->middlename} {$this->surname}");
    }

    /**
     * Get the members by category.
     */
    public static function getByCategory(string $category)
    {
        return static::where('category', $category)->get();
    }

    /**
     * Get the QR code URL for this member
     */
    public function getQrCodeUrl(): string
    {
        $profileUrl = route('members.public-profile', ['uuid' => $this->public_uuid]);
        $size = '300x300';
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}&data=" . urlencode($profileUrl);
    }
}

