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
     *
     * The image is centre-cropped to a square first, because dompdf has no
     * `object-fit` support and would otherwise squash non-square photos.
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

            $raw = $disk->get($this->image);
            $square = $this->cropToSquare($raw);

            return 'data:image/png;base64,'.base64_encode($square ?? $raw);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Centre-crop image bytes to a square PNG. Returns null when GD cannot
     * read the image, so the caller can fall back to the original bytes.
     */
    private function cropToSquare(string $raw): ?string
    {
        $image = @imagecreatefromstring($raw);

        if ($image === false) {
            return null;
        }

        try {
            $width = imagesx($image);
            $height = imagesy($image);
            $side = min($width, $height);
            $sourceX = intdiv($width - $side, 2);
            $sourceY = intdiv($height - $side, 2);

            $size = 240;
            $canvas = imagecreatetruecolor($size, $size);
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            imagecopy($canvas, $image, 0, 0, $sourceX, $sourceY, $side, $side);

            ob_start();
            imagepng($canvas, null, 7);

            return (string) ob_get_clean();
        } catch (Throwable) {
            return null;
        } finally {
            imagedestroy($image);
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

