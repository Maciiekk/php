<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{

    protected $table = 'event';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $atributes = [
        'category_id',
        'image_id',
        'name',
        'description',
        'begin_date',
        'end_date',
    ];

    protected $fillable = [
        'category_id',
        'image_id',
        'name',
        'description',
        'begin_date',
        'end_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
