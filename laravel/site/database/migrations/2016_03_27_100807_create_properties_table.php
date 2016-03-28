<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id');
            $table->string('title');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('pic_url');
            $table->string('region');
            $table->string('suburb');
            $table->string('address');
            $table->string('district');
            $table->string('price');
            $table->integer('price_int');
            $table->integer('rateable_value');
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 11, 8);
            $table->dateTime('last_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
