<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Comment;
use Illuminate\Support\Str;


class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements("comment_id");
            //Post ID where is writen comment
            $table->unsignedBigInteger('user_id');
            $table->string('message');
            $table->timestamps();

            //references
            $table->foreign('user_id')->references('id')->on('users');
        });

        $numberOfComment = 50;
        for ($i = 0; $i < $numberOfComment; $i++) {
            Comment::create([
                'user_id' => random_int(1, 10),
                'message' => Str::random(10),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
