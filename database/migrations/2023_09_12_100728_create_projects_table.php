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
            $table->string("projectVideo")->nullable();
            $table->string("projectThumbnail");
            $table->text("description");
            $table->text("overviewHeading");
            $table->text("overviewContent");
            $table->text("overviewFooter");
            $table->string("location");
            $table->text("withinReach");
            $table->string("withinReachImage");
            $table->text("flatConfig");
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
