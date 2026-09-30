<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

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
        'email',
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
     * Get the member photo as an inline data URI, for use in server-rendered
     * documents such as PDFs. Returns null when no readable image exists.
     */
    public function getImageDataUriAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        try {
            $disk = Storage::disk('public');

            if (! $disk->exists($this->image)) {
                return null;
            }

            return 'data:'.$disk->mimeType($this->image).';base64,'.base64_encode($disk->get($this->image));
        } catch (Throwable) {
            return null;
        }
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

