<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Note extends Model
{
    //alles was gesetzt werden soll, das was geändert werden darf
    protected $fillable =  ['title', 'description', 'user_id', 'lists_id', ];



    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->belongsTo(Lists::class, 'lists_id');
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'note_tag');
    }

    //eine polymorphe Beziehung zu Bildern
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    //eine one-to-many Beziehung zu TodoEntries
    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'notes_id');
    }



}




