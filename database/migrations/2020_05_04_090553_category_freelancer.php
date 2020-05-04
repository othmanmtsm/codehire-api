<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryFreelancer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_freelancer', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('freelancer_id');


            $table->unique(['category_id','freelancer_id']);

            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');

            $table->foreign('freelancer_id')
                    ->references('user_id')
                    ->on('freelancers');
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
        Schema::dropIfExists('category_freelancer');
    }
}
