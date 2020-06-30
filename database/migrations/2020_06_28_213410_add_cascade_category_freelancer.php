<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeCategoryFreelancer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_freelancer', function (Blueprint $table) {
            $table->dropForeign('category_freelancer_freelancer_id_foreign');
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
        Schema::table('category_freelancer', function (Blueprint $table) {
            $table->dropForeign('category_freelancer_freelancer_id_foreign');
        });
    }
}
