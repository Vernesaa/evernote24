<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::first();

        $note = new Note();
            $note->title= "Bachelorarbeit abgeben";
            $note->description =  "Abgabe am 17.Juni";

        //User zu Notes hinzufügen
        $note->user()->associate($user);
        //in DB speichern
        $note->save();

        // Bild zur Notiz hinzufügen
        $image = new Image([
            'url' => 'https://picsum.photos/seed/picsum/200/300',
            'title' => 'Bild1'
        ]);
        $note->images()->save($image);

        // IDs der Tags wird drangehängt

        $tag = Tag::first();

        if ($tag) {
            $note->tags()->attach($tag->id);
        }





    }
}
