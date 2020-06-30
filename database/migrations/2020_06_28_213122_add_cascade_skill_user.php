<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeSkillUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            $table->dropForeign('skill_user_user_id_foreign');
            $table->foreign('user_id')
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
        Schema::table('skill_user', function (Blueprint $table) {
            $table->dropForeign('skill_user_user_id_foreign');
        });
    }
}
