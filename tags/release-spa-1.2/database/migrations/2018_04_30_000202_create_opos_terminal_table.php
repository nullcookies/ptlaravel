<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposTerminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/* This tables tracks the individual OPOSsum POS systems */
        Schema::create('opos_terminal', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name");
			$table->string("description");
			$table->time("start_work");
			$table->time("end_work");

			/* We'd probably have different types of POS:
			$table->enum("type", ['foo','bar','baz']); */

			/* We'd probably keep track of IP or Hardware addresses.
			 * Perhaps even asset tags, or IDs: */
			$table->string("ip_addr");
			$table->string("hardware_addr");
			$table->string("asset_id");

			$table->enum('status', ['pending','active','suspended'])->
				default('active');
			$table->string("counter");

            $table->timestamps();
            $table->softDeletes();
			$table->engine = "MYISAM";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opos_terminal');
    }
}
