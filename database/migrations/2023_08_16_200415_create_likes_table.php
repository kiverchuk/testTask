<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Like;
class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comment_id');
            $table->timestamps();

            //references
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('comment_id')->references('comment_id')->on('comments');

            //primary key
            $table->unique(['user_id', 'comment_id']);
        });

        $numberOfUsers = 10;
        $numberOfComment = 50;
        $likes = [];
        for ($i = 0; $i < $numberOfUsers; $i++)
            for ($j = 0; $j < $numberOfComment; $j++)
                $likes[] = ['user_id' => $i+1, 'comment_id' => $j+1];
        shuffle($likes);
        foreach($likes as $like)
        {
            Like::create([
                'user_id' => $like['user_id'],
                'comment_id' => $like['comment_id'],
            ]);
        }
        Like::inRandomOrder()->limit(250)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
