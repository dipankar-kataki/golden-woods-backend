<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_answer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("question");
            $table->foreign("question")->references("id")->on("chat_question");
            $table->text("answer");
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_answer');
    }
};
