<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FreelancerReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('freelancer_id');
            $table->unsignedBigInteger('client_id');
            $table->text('review');
            $table->double('rating')->default(3.6);
            $table->timestamps();

            $table->foreign('freelancer_id')
                    ->references('user_id')
                    ->on('freelancers');

            $table->foreign('client_id')
                    ->references('user_id')
                    ->on('clients');

            $table->unique(['freelancer_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_reviews');
    }
}
