<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDesign extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $fillable = [
        'id',
        'username',
        'display_name',
    ];
    const CREATED_AT = null;

    const UPDATED_AT = null;
    public function collections()
    {
        return $this->hasMany(Collection::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'name_id');
    }
}