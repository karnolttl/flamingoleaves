<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->nullable()->unsigned()->index();
            $table->integer('sequence')->nullable()->unsigned();
            $table->text('post_text', 4000);
            $table->timestamps();
        });

        Schema::table('post_details', function($table) {
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_details');
    }
}