<?php

namespace App\Models;

use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Attachment;

class EmailAttachment extends Model implements Attachable
{
    use HasFactory;

    protected $fillable = [
        'email_id', 'filename', 'path', 'embedded',
    ];

    public function toMailAttachment() {
        return Attachment::fromPath(public_path($this->attributes['path']))
            ->as($this->attributes['filename']);
    }

    public function email() {
        return $this->belongsTo(Email::class);
    }
}
