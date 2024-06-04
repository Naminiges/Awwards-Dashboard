<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tag';

    protected $fillable = [
        'id',
        'name',
    ];

    // Relasi ke Item melalui ItemTag
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_tag', 'tag_id', 'item_id');
    }
}
