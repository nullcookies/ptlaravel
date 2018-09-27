
<?php



Route::get('/opossum', 'OpossumController@index')->name('opposum.trunk.index');


Route::get('/listproduct', 'OpossumController@listproduct')->name('listproduct');
Route::get('/skulist', 'OpossumController@skulist')->name('skulist');

Route::get('/skulist_since', 'OpossumController@skulist_since')->name('skulist_since');
Route::get('/skulist_ytd', 'OpossumController@skulist_ytd')->name('skulist_ytd');
Route::get('/skulist_mtd', 'OpossumController@skulist_mtd')->name('skulist_mtd');
Route::get('/skulist_wtd', 'OpossumController@skulist_wtd')->name('skulist_wtd');
Route::get('/skulist_daily', 'OpossumController@skulist_daily')->name('skulist_daily');
Route::get('/skulist_hourly', 'OpossumController@skulist_hourly')->name('skulist_hourly');


Route::post('/savesparoom', 'OpossumController@savesparoom')->name('savesparoom');
Route::get('/sparooms', 'OpossumController@sparooms')->name('sparooms');
Route::get('/lockerkeys', 'OpossumController@lockerkeys')->name('lockerkeys');
Route::any('/check_existance/{type}/{fnum}', 'OpossumController@check_existance')->name('check_existance');
Route::post('/checkin', 'OpossumController@checkin')->name('checkin');
Route::post('/checkoutsparoom', 'OpossumController@checkoutsparoom')->name('checkoutsparoom');
Route::get('/deleteroom/{id}', 'OpossumController@deleteroom')->name('deleteroom');
Route::post('/saverec', 'OpossumController@saverec')->name('saverec');
Route::post('/savediscountbtn', 'OpossumController@savediscountbtn')->name('savediscountbtn');
Route::get('/getdiscountbtn', 'OpossumController@getdiscountbtn')->name('getdiscountbtn');

Route::get('/opossum-operation-hrs-variables', 'OpossumController@operation_hours_variables');
Route::get('/get-member-location-data', 'OpossumController@getMemberLocationData');

Route::get('/stockin', 'OpossumController@stockin')->name('stockin');
Route::get('/stockout', 'OpossumController@stockout')->name('stockout');

/*Table Routes . Please give unique names to routes Also Please start the route with opossum prefix*/
Route::get('/table', 'OpossumController@table')->name('table');
Route::any('/table/{table}/{fnum}', 'OpossumController@table')->name('table'); //not unique name
Route::post('/savetable', 'OpossumController@savetable')->name('savetable');
Route::post('/savehotelroom', 'OpossumController@savehotelroom')->name('savehotelroom');
Route::post('/lokerkeydata', 'OpossumController@lokerkeydata')->name('lokerkeydata');
Route::post('/setbfunction', 'OpossumController@setbfunction')->name('setbfunction');

Route::get('/hotelroom', 'OpossumController@hotelroom')->name('hotelroom');
Route::get('/getbfunction', 'OpossumController@getbfunction')->name('getbfunction');
/**/
Route::group(array("prefix"=>"opossum"),function(){
	Route::post("transaction/{action}","OpossumController@transaction");
	Route::post("product/{action}","OpossumController@product");
	Route::get("receipt/{action}/{receipt_id}","OpossumController@receipt");
	Route::get("support/{type}/{user_id?}","OpossumController@support");
});

//********************** Document *************************
Route::post('/opos_tax_invoice/document', 'OpossumController@list_terminal');
Route::get('/showreceipt/{from}/{to}/{terminalid}', 'OpossumController@showreceipt');
Route::get('/showreceiptproduct/{id}', 'OpossumController@showreceiptproduct');
Route::get('/statement/showreceiptlist/{terminal_id}', 'OpossumController@showreceiptlist');
Route::get('/showopossumreceipt/{id}', 'OpossumController@showopossumreceipt');
Route::get('/digitalclock', 'OpossumController@digitalclock');


Route::post('/opossum/savelokersession', 'OpossumController@savelokersession');
Route::get('/opossum/showSavedData', 'OpossumController@showSavedData');
Route::post('/opossum/deletelokersession', 'OpossumController@deletelokersession');
Route::post('/opossum/getftypeid', 'OpossumController@getftypeid');

Route::get('/opossum/{terminal_id}', 'OpossumController@index')->name('opposum.trunk.index');
Route::group(['middleware' => 'admin'],function(){
Route::get('/opossum/{terminal_id}/{merchant_id}', 'OpossumController@index')->name('opposum.trunk.index');
});