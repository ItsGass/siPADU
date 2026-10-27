<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $complaint_id
 * @property string $path
 * @property string $original_name
 * @property string $mime_type
 * @property int $size
 */
#[Fillable(['complaint_id', 'path', 'original_name', 'mime_type', 'size'])]
class ComplaintAttachment extends Model
{
    /**
     * @return BelongsTo<Complaint, $this>
     */
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function humanSize(): string
    {
        $kilobytes = $this->size / 1024;

        return $kilobytes >= 1024
            ? number_format($kilobytes / 1024, 1, ',', '.').' MB'
            : number_format($kilobytes, 0, ',', '.').' KB';
    }
}
