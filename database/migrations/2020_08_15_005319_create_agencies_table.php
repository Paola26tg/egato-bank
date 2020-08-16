<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->Increments('idAgency');
            $table->integer('idCountry')->unsigned();
            $table->integer('idCity')->unsigned();
            $table->string('nameAgency');
            $table->string('codeAgency');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idCountry')
                ->references('idCountry')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idCity')
                ->references('idCity')
                ->on('cities')
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
        Schema::dropIfExists('agencies');
    }
}
