<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->date('date_limit');
            $table->text('description');
            $table->double('payment_min');
            $table->double('payment_max');
            $table->dateTime('unavailable_at')->nullable();
            $table->unsignedBigInteger('payment_type');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('payment_type')
                    ->references('id')
                    ->on('payment_types')
                    ->onDelete('cascade');

            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
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
        Schema::dropIfExists('projects');
    }
}
