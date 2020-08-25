<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->Increments('idCustomer');
            $table->integer('idCountry')->unsigned();
            $table->integer('idCity')->unsigned();
            $table->string('firsName');
            $table->string('lastName');
            $table->boolean('isValidated')->default(true);
            $table->boolean('isEnable')->default(true);

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('customers');
    }
}
