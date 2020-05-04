<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('provider');
            $table->text('description');
            $table->date('date');
            $table->unsignedBigInteger('freelancer_id');
            $table->timestamps();

            $table->foreign('freelancer_id')
                    ->references('user_id')
                    ->on('freelancers')
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
        Schema::dropIfExists('certifications');
    }
}
