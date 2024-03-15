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
         Schema::create('enquiries', function (Blueprint $table) {
             $table->id();
             $table->string("name");
             $table->string("phone", 10); 
             $table->string("email")->nullable();
             $table->string("flatType")->nullable();
             $table->string("enquiryType")->default("general");
             $table->integer("projectId")->nullable();
             $table->tinyInteger("madeEnquiry")->default(0);
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
        Schema::dropIfExists('enquiries');
    }
};
