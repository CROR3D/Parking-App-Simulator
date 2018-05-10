<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('parking_id')->unsigned()->nullable()->index();
            $table->integer('code')->index();
            $table->dateTime('cancellation')->nullable();
            $table->dateTime('expire_time')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::table('reservations', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE reservations CHANGE code code INT(4) UNSIGNED ZEROFILL NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
