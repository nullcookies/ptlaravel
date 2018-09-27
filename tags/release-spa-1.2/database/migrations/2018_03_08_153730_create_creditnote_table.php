<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Creditnote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditnote', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('creditnote_no')->unsigned();
            $table->integer('return_of_goods_id');
            $table->integer('quantity');
            $table->enum('status', ['pending','approved','rejected']);
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
        Schema::drop('creditnote');
    }
}
