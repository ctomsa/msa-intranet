<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Knowledge extends Model
{
    protected $table = 'knowledge_items';

    protected $fillable = [
        'title',
        'category',
        'excerpt',
        'content',
        'author_name',
        'author_position',
        'attachment_path',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'attachment_url',
        'category_label',
    ];

    public function getAttachmentUrlAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }

        return Storage::disk('public')->url($this->attachment_path);
    }

    public function getCategoryLabelAttribute(): ?string
    {
        return match ($this->category) {
            'ved'            => 'ВЭД',
            'fundraising'    => 'Привлечение финансирования',
            'legal'          => 'Юридические услуги',
            'growth'         => 'Развитие',
            'private_office' => 'Private office',
            default          => null,
        };
    }
}