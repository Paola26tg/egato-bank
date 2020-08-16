<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_user', function (Blueprint $table) {
            $table->Increments('idAgencyUser');
            $table->integer('idUser')->unsigned();
            $table->integer('idAgency')->unsigned();
            $table->boolean('isEnable')->default(true);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idUser')
                ->references('idUser')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idAgency')
                ->references('idAgency')
                ->on('agencies')
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
        Schema::dropIfExists('agency_user');
    }
}
