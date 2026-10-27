<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 */
#[Fillable(['name', 'email', 'subject', 'message'])]
class ContactMessage extends Model
{
    //
}
