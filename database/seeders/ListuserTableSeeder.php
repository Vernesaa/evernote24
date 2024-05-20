<?php

namespace Database\Seeders;

use App\Models\Lists;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListuserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = User::all();
        $lists = Lists::all();

        // Beispiel: Jede Liste wird mit einigen Benutzern geteilt
        foreach ($lists as $list) {
            // Holen Sie eine zufällige Sammlung von Benutzer-IDs
            $userIds = $users->pluck('id')->toArray();
            // Teilen der Liste mit den ausgewählten Benutzern
            $list->listuser()->attach($userIds);
        }

    }
}
