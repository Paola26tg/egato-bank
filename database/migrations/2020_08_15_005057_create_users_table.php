<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->Increments('idUser');
            $table->integer('idRole')->unsigned();
            $table->string('firstNameUser');
            $table->string('lastNameUser');
            $table->string('telUser');
            $table->boolean('isOnline')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idRole')
                ->references('idRole')
                ->on('roles')
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
        Schema::dropIfExists('users');
    }
}
