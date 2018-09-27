<?php

Route::post('/addcustomerdetail', ['as' => 'adminsellermembers', 'uses'=>'SellerHelpController@addCustomerDetails']);
Route::post('/add_customer_details', ['as' => 'adminsellermembers', 'uses'=>'SellerHelpController@customer_segment_role_details']);
Route::get('/customerdetails', ['as' => 'adminsellermembers', 'uses'=>'SellerHelpController@showCustomerDetails']);


Route::get('merchant/cre/{porderId}','CREController@initRForm');
Route::get('merchant/approval/{porderId}','CREController@showApproveModal');
Route::post('merchant/approval','CREController@doApproval');

Route::post('product/map/delete','ProductController@product_map_delete');
Route::get('barcode/generate/{product_id}/{barcode?}','ProductController@barcode_generate');
Route::get("salesmemo/freeze","SellerHelpController@freeze_salesmemo");

Route::post("branch/users/{user_id?}","SellerBranchController@branch_users_list");
Route::post("branch/products/{user_id?}","SellerBranchController@branch_products_list");


//Route::get("seller/rack/{uid?}","SellerRackController");
Route::post("seller/rack/{uid?}","SellerRackController@store");
Route::post("remove/rack/{uid?}","SellerRackController@remove");
Route::post("seller/rack/remarks/{uid?}","SellerRackController@remarks");


Route::get("warehouse/rack/{warehouse_id}/{user_id?}","WarehouseController@warehouse_rack_info");
Route::post("warehouse/rack/products/{user_id?}","SellerRackController@rack_product_info");
Route::post("warehouse/rack/remove_product/{user_id?}","SellerRackController@rack_product_remove");

Route::get("branch/list/{user_id?}","SellerHelpController@branch_list");
Route::post("product/exists/name/{user_id?}","AlbumController@product_exists_name");
Route::get("product/list/datatable/{user_id?}","SellerHelpController@get_merchant_products");
Route::get("product/list/json/{user_id?}","AlbumController@merchant_product_json");

Route::get("seller/autobarcode/{user_id?}","SellerHelpController@autobarcode");

Route::get("seller/q1","TerminalController@index");
Route::post("seller/q1/update","TerminalController@updateQ1Def");
Route::get("seller/fridge","StorageController@index");
?>
