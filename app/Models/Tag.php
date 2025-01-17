<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name','user_id'
    ];



    public function todos(): BelongsToMany {
        return $this->belongsToMany(Todo::class, 'todo_tag');
    }

    public function notes(): BelongsToMany {
        return $this->belongsToMany(Note::class, 'note_tag');
    }
}
