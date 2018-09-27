<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOposDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opos_discount', function (Blueprint $table) {
            $table->increments('id');
			$table->string("name");
			$table->string("description");

			/* Discount value in percentage */
			$table->float("value")->unsigned()->default(0);
			$table->integer("min_discount_amt")->unsigned()->default(0);
			$table->integer("max_discount_amt")->unsigned();
			$table->float("max_discount_pct")->unsigned()->default(99);

			$table->enum("type", ["staff","member","public"]);
			$table->enum("status", ["pending","active","suspended"]);

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
        Schema::drop('opos_discount');
    }
}
