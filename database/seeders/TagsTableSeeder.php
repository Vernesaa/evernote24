<?php

namespace Database\Seeders;

use App\Models\Lists;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = new Tag();
        $tags->name = "sehr wichtig";
        $tags->save();

        $tags2 = new Tag();
        $tags2->name = "wichtig";
        $tags2->save();

    }
}

