<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_customers', function (Blueprint $table) {
            $table->Increments('idAccountCustomer');
            $table->integer('idAgency')->unsigned();
            $table->integer('idCustomer')->unsigned();
            $table->double('accountAmount');
            $table->string('accountNumber');
            $table->boolean('isBlocked')->default(false);
            $table->boolean('isPremium')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idAgency')
                ->references('idAgency')
                ->on('agencies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idCustomer')
                ->references('idCustomer')
                ->on('customers')
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
        Schema::dropIfExists('account_customers');
    }
}
