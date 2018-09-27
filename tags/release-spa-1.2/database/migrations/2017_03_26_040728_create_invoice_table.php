<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('invoice', function(Blueprint $table) {
			$table->increments('id')->unsigned();

			/* This is the BUYER */
			$table->integer('porder_id')->unsigned();
			$table->integer('invoice_no')->unsigned();
			$table->integer('duration')->unsigned();
			/* invoice:stationterm = 1:1  */
			$table->integer('stationterm_id')->unsigned();
			$table->string('do_password');
			$table->enum('status',
				array('active', 'coming due', 'overdue', 'completed'))->
				default('active');
				
			$table->enum('payment',
				array('unpaid', 'partial', 'full'))->
				default('unpaid');	
 
 
			$table->softDeletes();

			/* Order received = created_at */
			$table->timestamps();

			$table->engine = 'MYISAM';
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice');
    }
}
