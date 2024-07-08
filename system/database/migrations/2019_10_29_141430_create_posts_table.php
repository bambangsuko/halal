<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cover')->nullable();
            $table->string('thumbnail')->nullable();
            $table->bigInteger('menu_id')->unsigned();
            $table->boolean('is_published')->default(1);            
            $table->boolean('is_running_text')->default(0);            
            $table->boolean('is_featured_product')->default(0);            
            $table->string('template');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('posts');
    }

}
