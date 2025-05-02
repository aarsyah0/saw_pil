<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_slide_id',
        'icon_class',
        'text',
        'order',
    ];

    public function heroSlide()
    {
        return $this->belongsTo(HeroSlide::class);
    }
}
