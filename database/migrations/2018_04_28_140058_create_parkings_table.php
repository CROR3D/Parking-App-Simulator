<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('city');
            $table->string('address');
            $table->string('slug');
            $table->string('image');
            $table->integer('spots')->unsigned();
            $table->unsignedDecimal('price_per_hour', 8, 2);
            $table->unsignedDecimal('price_of_reservation', 8, 2);
            $table->unsignedDecimal('price_of_reservation_penalty', 8, 2);
            $table->string('working_time');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
