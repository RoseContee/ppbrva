<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'to', 'cc', 'bcc', 'subject', 'content', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime:n/j/Y @ H:i A',
        'updated_at' => 'datetime:n/j/Y @ H:i A',
    ];

    public function getToAttribute() {
        if (empty($this->attributes['to'])) return [];
        return Member::query()
            ->whereIn('id', explode(',', $this->attributes['to']))
            ->withTrashed()
            ->get(['id', 'firstname', 'lastname', 'email']);
    }

    public function getSubjectAttribute() {
        return $this->attributes['subject'] ?? '';
    }

    public function attachments() {
        return $this->hasMany(EmailAttachment::class);
    }
}
