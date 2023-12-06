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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("projectName")->unique()->nullable();
            $table->string("status");
            $table->string("projectImage1");
            $table->string("projectImage2");
            $table->string("projectVideo");
            $table->string("projectThumbnail");
            $table->string("description");
            $table->string("overviewHeading");
            $table->string("overviewContent");
            $table->string("overviewFooter");
            $table->string("location", 255);
            $table->string("withinReach", 255);
            $table->string("withinReachImage");
            $table->string("flatConfig");
            $table->string("brochure")->nullable();
            $table->tinyInteger("isActive")->default(0);
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
        Schema::dropIfExists('projects');
    }
};
