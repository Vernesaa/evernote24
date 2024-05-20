<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'title'];



//definiert eine polymorphe Beziehung,
// die es Image ermöglicht, zu verschiedenen Modellen zu gehören.

    public function imageable()
    {
        return $this->morphTo();
    }

}
