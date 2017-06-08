<?php

use Illuminate\Database\Seeder;

class posts_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run()
    {
        factory(App\Post::class, 10)
            ->create()
            ->each(function ($p) {
                $tagsCount = DB::table('tags')->count();
                $p->post_detail()->save(factory(App\Post_detail::class)->make());
                $p->img()->save(factory(App\Img::class)->make());
                $p->tags()->attach([rand(1, $tagsCount), rand(1, $tagsCount)]);
            });
    }
}
