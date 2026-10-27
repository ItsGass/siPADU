<?php

namespace App\Models;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use Database\Factories\ComplaintFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $ticket_number
 * @property int $user_id
 * @property ComplaintCategory $category
 * @property string $title
 * @property string $description
 * @property string|null $location
 * @property Carbon|null $incident_date
 * @property bool $is_anonymous
 * @property ComplaintStatus $status
 * @property ComplaintPriority $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'user_id',
    'ticket_number',
    'category',
    'title',
    'description',
    'location',
    'incident_date',
    'is_anonymous',
    'status',
    'priority',
])]
class Complaint extends Model
{
    /** @use HasFactory<ComplaintFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint): void {
            if (blank($complaint->ticket_number)) {
                $complaint->ticket_number = static::generateTicketNumber();
            }
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => ComplaintCategory::class,
            'status' => ComplaintStatus::class,
            'priority' => ComplaintPriority::class,
            'incident_date' => 'date',
            'is_anonymous' => 'boolean',
        ];
    }

    public static function generateTicketNumber(): string
    {
        do {
            $ticket = 'SPD-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        } while (static::query()->where('ticket_number', $ticket)->exists());

        return $ticket;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ComplaintAttachment, $this>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }

    /**
     * @return HasMany<ComplaintUpdate, $this>
     */
    public function updates(): HasMany
    {
        return $this->hasMany(ComplaintUpdate::class)->oldest();
    }

    public function reporterName(): string
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }

    public function reporterInitials(): string
    {
        return $this->is_anonymous ? 'AN' : $this->user->initials();
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}
