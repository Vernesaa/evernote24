<?php

namespace Database\Seeders;

use App\Models\Lists;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;


//daten werden in die datenbank gelegt
class ListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User holen, prüfen, ob vorhanden
        $user = User::first();

        // Erstellen und Speichern der ersten Liste
        $lists = new Lists();
        $lists->name = "Bachelorarbeit";
        $lists->user()->associate($user);
        $lists->save();

        // Erstellen und Speichern der zweiten Liste
        $lists2 = new Lists();
        $lists2->name = "Web";
        $lists2->user()->associate($user);
        $lists2->save();

        // Erstellen und Speichern der dritten Liste
        $lists3 = new Lists();
        $lists3->name = "AUP";
        $lists3->user()->associate($user);
        $lists3->save();



    }
}
