<?php

use Illuminate\Http\Request; 
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type,token, X-Auth-Token, Origin, Authorization');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/ 
Route::post('/test',function(Request $request){
	return $request->value;
})->middleware('token_checker'); //checker for authenticated user

//LOGIN AND LOGOUT | USER
//parameter [ username, password]
Route::post('/user/login','LoginController@login');//done
//parameter [ token ]
Route::post('/user/logout','LogoutController@logout')->middleware('token_checker');//done
//parameter [ token ]
Route::post('/user/get_delivery_address','UserController@get_delivery_address')->middleware('token_checker');//done
//parameter [ token ]
Route::post('/user/get_personal_details','UserController@get_personal_details')->middleware('token_checker');//done

//CART
//parameter [ product_id ] 
Route::post('/cart/add_to_cart', 'CartController@addToCart')->middleware('token_checker');//done
//parameter [ product_id ] 
Route::post('/cart/remove_item_from_cart', 'CartController@removeItemFromCart')->middleware('token_checker');//done
//parameter [ token ] 
Route::post('/cart/get_cart', 'CartController@getCart')->middleware('token_checker'); //done
//parameter [ token ]
Route::post('/cart/delete_cart', 'CartController@deleteCart')->middleware('token_checker');//done
//parameter [product_id,qty]
Route::post('/cart/update_cart', 'CartController@updateCart')->middleware('token_checker');//done

//ORDER
//parameter [ token ]
Route::post('/order/add_sales_order', 'SaleOrderController@create')->middleware('token_checker');//done
//parameter [ token ]
Route::post('/order/sales_history', 'SaleOrderController@salesOrderHistory')->middleware('token_checker');//done
//parameter [ token,sales_order_id ]
Route::post('/order/sales_order_details', 'SaleOrderController@salesOrderDetailHistory')->middleware('token_checker');//done

//PRODUCT
Route::post('/products', 'ProductController@list')->middleware('token_checker');//done

//PRODUCT CATEGORY
Route::post('/product_category','ProductCategoryController@list')->middleware('token_checker');

//MODE OF PAYMENT
Route::post('/mode_of_payment/index', 'MopController@index')->middleware('token_checker');

/*----------  EMAIL SENDING  ----------*/ 
Route::post('/mail/franchise_inquiry','MailController@franchiseInquiry');
Route::post('/mail/contact_inquiry','MailController@contactInquiry');
Route::post('/contact-us', 	'ContactUsController@store');


/*----------  FOR CLARION  ----------*/
//Route::get('/clarion/order/sales_history/{customer_id}', 'SaleOrderController@clarion_salesOrderHistory');//done
Route::any('/clarion/order/sales_history/{customer_id}/{order_id}', 'SaleOrderController@clarion_singleSalesOrderHistory');//done