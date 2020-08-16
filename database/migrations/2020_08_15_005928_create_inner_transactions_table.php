<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInnerTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inner_transactions', function (Blueprint $table) {
            $table->Increments('idInnerTransaction');
            $table->integer('idAccountDepart')->unsigned();
            $table->integer('idAccountArrive')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idAccountDepart')
                ->references('idAccountCustomer')
                ->on('account_customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idAccountArrive')
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
        Schema::dropIfExists('inner_transactions');
    }
}
