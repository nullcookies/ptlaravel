<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locationusers', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('location_id')->unsigned();	//FK->fairlocation
			$table->integer('user_id')->unsigned();		//FK->users
            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('locationusers');
    }
}
