<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Todo extends Model
{
    protected $fillable = [
        'title', 'description', 'due_date', 'user_id', 'notes_id', 'listusers_id'
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'todo_tag');
    }

    // Definiert eine polymorphe Beziehung zu Bildern
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    //BelongTo Methode zw. Todos und Note Tabellen

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'notes_id');
    }



}
