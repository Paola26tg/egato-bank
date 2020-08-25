<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_transactions', function (Blueprint $table) {
            $table->Increments('idDepositTransaction');
            $table->integer('idAccountCustomer')->unsigned();
            $table->integer('idUser')->unsigned();
            $table->double('transactionAmount');
            $table->string('transaction_token');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idAccountCustomer')
                ->references('idAccountCustomer')
                ->on('account_customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idUser')
                ->references('idUser')
                ->on('users')
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
        Schema::dropIfExists('deposit_transactions');
    }
}
