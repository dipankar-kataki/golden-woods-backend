<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('chat_question', function (Blueprint $table) {
            $table->id();
            $table->integer("questionNumber");
            $table->string("questionType");
            $table->text("question");
            $table->timestamps();
            $table->unique("questionNumber");
            $table->index('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_question');
    }
};
