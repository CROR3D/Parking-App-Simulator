<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('temp_user_id')->unsigned()->nullable()->index();
            $table->integer('parking_id')->unsigned()->nullable()->index();
            $table->string('code')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('paid')->default(false);
            $table->dateTime('entrance_time')->nullable();
            $table->dateTime('bonus_time')->nullable();

            $table->engine = 'InnoDB';
            $table->unique('code');
        });

        Schema::table('tickets', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('temp_user_id')->references('id')->on('temp_users')->onDelete('cascade');
            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
