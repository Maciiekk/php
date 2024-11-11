<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $atributes = [
        'name',
        'colour',
    ];

    protected $fillable = [
        'name',
        'colour',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
