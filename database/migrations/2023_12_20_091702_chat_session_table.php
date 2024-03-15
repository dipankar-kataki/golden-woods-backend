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
            $table->unsignedBigInteger("web_user_id"); // Apply 'unsigned' attribute
            $table->unsignedBigInteger("question_id");
            $table->longText("answer");

            // Use 'unsigned' attribute and ensure the data type matches 'web_user.id'
            $table->foreign("web_user_id")->references("id")->on("web_user");
            $table->foreign("question_id")->references("id")->on("chat_question");

            $table->timestamps();
            $table->index('id');
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
