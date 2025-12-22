<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeAttachment extends Model
{
    protected $table = 'knowledge_attachments';

    protected $fillable = [
        'knowledge_id',
        'path',
        'original_name',
        'size',
        'mime',
    ];

    public function knowledge()
    {
        return $this->belongsTo(Knowledge::class, 'knowledge_id');
    }
}
