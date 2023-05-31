<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('is_post_likeds', function (Blueprint $table) {
            $table->id();
            $table->boolean('isLiked');
            $table->unsignedBigInteger('user_post_id');
            $table->timestamps();

            $table->foreign("user_post_id")
            ->references("id")->on("user_posts");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('is_post_likeds');
    }
};
