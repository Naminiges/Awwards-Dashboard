<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable = [
        'id',
        'name',
        'slug',
    ];

    const UPDATED_AT = null;
    const CREATED_AT = null;
    // Relasi ke Collection
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
