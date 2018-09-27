<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankaccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Each records represents a user's account with a bank */

        Schema::create('bankaccount', function (Blueprint $table) {
            $table->increments('id');

            /* Which bank do these accounts are from? */
            $table->integer('bank_id')->unsigned();

            $table->string('account_name1');
            $table->string('account_number1');
            $table->string('account_name2');
            $table->string('account_number2');
            $table->string('iban');
            $table->string('swift');

            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'MyISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bankaccount');
    }
}
