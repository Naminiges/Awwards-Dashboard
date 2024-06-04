<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collection';

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'slug',
        'category_id',
        'followers_count',
        'created_at',
        'type',
        'url',
    ];

    // Disable the updated_at timestamp
    const UPDATED_AT = null;

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Relasi ke UserDesign
    public function user()
    {
        return $this->belongsTo(UserDesign::class, 'user_id');
    }
}
