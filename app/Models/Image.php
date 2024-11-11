<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{

    protected $table = 'image';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $attributes = [
        'name',
        'description',
        'path',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
