<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectFreelancer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_freelancer', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('freelancer_id');
            $table->float('amount');
            $table->integer('duration');
            $table->string('description');
            $table->boolean('isHired')->default(false);
            $table->dateTime('submitted_at')->default(date('Y-m-d H:i:s'));

            $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->onDelete('cascade');

            $table->foreign('freelancer_id')
                    ->references('user_id')
                    ->on('freelancers')
                    ->onDelete('cascade');

            $table->unique(['project_id','freelancer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_freelancer');
    }
}
