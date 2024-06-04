<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';

    protected $fillable = [
        'id',
        'title',
        'collection_id',
        'created_at',
        'type',
        'preview_link',
        'name_id',
    ];

    const CREATED_AT = null;

    const UPDATED_AT = null;

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tag', 'item_id');
    }

    public function userDesign()
    {
        return $this->belongsTo(UserDesign::class, 'name_id');
    }
}