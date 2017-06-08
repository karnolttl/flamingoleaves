<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(users_seeder::class);
        $this->call(tags_and_categories_seeder::class);
        $this->call(posts_seeder::class);
    }
}
