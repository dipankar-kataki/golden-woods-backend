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
        Schema::create('web_user', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone", 10);
            $table->string("preferredMode");
            $table->string("email")->nullable();
            $table->tinyInteger("madeContact")->default(0);
            $table->timestamps();
            $table->index('id'); // Make sure 'id' has an index
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_user');
    }
};
