<?php

use Illuminate\Database\Seeder;

class tags_and_categories_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tag::class, 10)->create();
        factory(App\Category::class, 10)->create();
    }
}
