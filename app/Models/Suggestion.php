<?php

namespace App\Models;

use App\Enums\SuggestionType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property SuggestionType $type
 * @property string $subject
 * @property string $message
 * @property bool $is_anonymous
 * @property bool $is_reviewed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['user_id', 'type', 'subject', 'message', 'is_anonymous', 'is_reviewed'])]
class Suggestion extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => SuggestionType::class,
            'is_anonymous' => 'boolean',
            'is_reviewed' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reporterName(): string
    {
        if ($this->is_anonymous || $this->user === null) {
            return 'Anonim';
        }

        return $this->user->name;
    }
}
