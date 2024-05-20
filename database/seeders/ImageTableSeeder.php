<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $notes = Note::all();
        $todos = Todo::all();

        // Bilder für User
        foreach ($users as $user) {
            $user->images()->create([
                'url' => 'https://picsum.photos/id/237/200/300',
            ]);
        }

        // Bilder für Notes
        foreach ($notes as $note) {
            $note->images()->create([
                'url' => 'https://picsum.photos/seed/picsum/200/300'
            ]);
        }

        //Bilder für Todos
        foreach ($todos as $todo) {
            $todo->images()->create([
                'url' => 'https://picsum.photos/seed/picsum/200/300'
            ]);
        }


    }
}
