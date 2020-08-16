<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_company', function (Blueprint $table) {
            $table->Increments('idAccountCompany');
            $table->integer('idAccountCustomer')->unsigned();
            $table->double('generateAmount');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idAccountCustomer')
                ->references('idAccountCustomer')
                ->on('account_customers')
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
        Schema::dropIfExists('account_company');
    }
}
