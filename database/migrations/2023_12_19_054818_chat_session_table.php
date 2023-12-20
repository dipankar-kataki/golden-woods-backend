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
        Schema::create('chat_session', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone", 10);
            $table->string("preferredMode");
            $table->string("email")->nullable();
            $table->unsignedBigInteger("question");
            $table->foreign("question")->references("id")->on("chat_question");
            $table->unsignedBigInteger("answer");
            $table->foreign("answer")->references("id")->on("chat_answer");
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_session');
    }
};
