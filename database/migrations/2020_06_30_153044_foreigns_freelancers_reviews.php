<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignsFreelancersReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freelancer_reviews', function (Blueprint $table) {
            $table->dropForeign('freelancer_reviews_client_id_foreign');
            $table->dropForeign('freelancer_reviews_freelancer_id_foreign');

            $table->foreign('freelancer_id')
                    ->references('user_id')
                    ->on('freelancers')
                    ->onDelete('cascade');

            $table->foreign('client_id')
                    ->references('user_id')
                    ->on('clients')
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
        Schema::table('freelancer_reviews', function (Blueprint $table) {
            $table->dropForeign('freelancer_reviews_client_id_foreign');
            $table->dropForeign('freelancer_reviews_freelancer_id_foreign');
        });
    }
}
