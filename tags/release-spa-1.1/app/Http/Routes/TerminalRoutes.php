<?php
Route::group(['middleware'=>'merchant'],function() {
 
 Route::get('/open-terminal/get-sub-cateogires','TerminalController@getSubCategories');
 Route::get('/open-terminal/save-terminal-data','TerminalController@saveTerminalData');   
 Route::get('/open-terminal/save-terminal-user-data','TerminalController@saveTerminalUserData');   
 Route::get('/open-terminal/get-terminal-user-data','TerminalController@getTerminalUserData');   
 Route::get('/open-terminal/add-without-values/{location}','TerminalController@addWithoutValues');
 Route::get('/open-terminal/update-values','TerminalController@updateValue');
 Route::get('/open-terminal/assign-user-term','TerminalController@assignUser');
 Route::get('/open-terminal/delete/{id}','TerminalController@deleteValue');
 Route::get('/open-terminal/{location_id}','TerminalController@viewTerminal');
 Route::get('/product-defination-page','TerminalController@viewProductDefination');
 Route::get('/cashmgmt', ['as' => 'getTerminalList', 'uses' => 'SellerHelpController@getTerminalCash']);
 Route::get('/cashmgmt/{terminal_id}', ['as' => 'getCML', 'uses' => 'SellerHelpController@getCML']);
});
