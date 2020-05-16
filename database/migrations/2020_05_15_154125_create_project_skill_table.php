<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_skill', function (Blueprint $table) {
            $table->unsignedBigInteger('skill_id');
            $table->unsignedBigInteger('project_id');

            $table->unique(['skill_id','project_id']);

            $table->foreign('skill_id')
                    ->references('id')
                    ->on('skills')
                    ->onDelete('cascade');

            $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_skill');
    }
}
