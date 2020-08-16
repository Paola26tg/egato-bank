<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->Increments('idCity');
            $table->integer('idCountry')->unsigned();
            $table->string('nameCity');
            $table->string('latitude');
            $table->string('longitude');


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idCountry')
                ->references('idCountry')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
