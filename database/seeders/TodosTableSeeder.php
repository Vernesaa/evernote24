<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::first();
       $todo = new Todo();
            $todo->title = "Kapitel eins schreiben";
            $todo->description = "Fragestellungen beantworten";
            $todo->due_date =new DateTime();

        $todo->user()->associate($user);
        //in DB speichern
        $todo->save();

        // Bild zu Todos hinzufügen
        $image = new Image([
            'url' => 'https://picsum.photos/200/300/?blur',
            'title' => 'Bild2'
        ]);
        $todo->images()->save($image);

        // IDs der Tags wird drangehängt
        $tagsIds = [1];
        $todo->tags()->attach($tagsIds);


    }
}
