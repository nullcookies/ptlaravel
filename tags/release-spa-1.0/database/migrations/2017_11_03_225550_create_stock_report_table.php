<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockreport', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('report_no')->unsigned();
            $table->integer('checker_user_id')->unsigned();
            $table->integer('creator_user_id')->unsigned();
            $table->integer('checker_company_id')->unsigned();
            $table->integer('creator_company_id')->unsigned();
            $table->enum('status',[
				'pending','confirmed','deleted','in_progress'
			])->default('pending');
            $table->string("qr");
			$table->integer('creator_location_id')->unsigned();
			$table->integer('checker_location_id')->unsigned();
			$table->enum('ttype', [
				'voided','treport','tin','tout','smemo','stocktake',
				'gator_sorder','wastage'
			]);
			/* We record how data is being entered, either using the phone's
			 * default mechanism, or using manual tapping via Checker Edit, or
			 * using external scanners via ESM */
			$table->enum('method', ['chkedit','esm','phone'])->
				default('phone');
            $table->timestamps();
            $table->timestamp('checked_on');
            $table->softDeletes();
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
        Schema::drop('stockreport');
    }
}
