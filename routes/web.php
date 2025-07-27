<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/test-mail', function () {
   try {
       Mail::raw('This is a test email from Laravel', function ($message) {
           $message->to('your_email@gmail.com')
                   ->subject('Test Email from Laravel');
       });
       return '✅ Email sent successfully!';
   } catch (\Exception $e) {
       return '❌ Failed: ' . $e->getMessage();
   }
});
Route::middleware(['web'])->group(function () {
Route::get('/auth/google', 'GoogleController@redirectToGoogle');
Route::get('/auth/google/callback', 'GoogleController@handleGoogleCallback');
Route::get('/', 'UserController@index')->name('/');
});

Auth::routes(['verify' => true]);
Route::middleware(['auth', 'logout.unverified'])->group(function () {
Route::get('/home', 'HomeController@index')->name('home');
});
Route::get('/verify-info', function () {
    return view('auth.verify_guest');
})->name('verify.guest');

Route::get('/profile', 'UserController@profile')->middleware('auth')->name('profile');
Route::post('profile-update','UserController@profileupdate');
Route::get('/get_products/{id}', 'UserController@get_products')->name('get_products');
Route::get('/sort_asc/{id}', 'UserController@sort_asc')->name('sort_asc');
Route::get('/sort_dsc/{id}', 'UserController@sort_dsc')->name('sort_dsc');
Route::get('/get_category_products/{id}', 'UserController@get_category_products')->name('get_category_products');
Route::get('/get_product_details/{id}', 'UserController@get_product_details')->name('get_product_details');
Route::get('/my_ads', 'UserController@my_ads')->middleware('auth')->name('my_ads');
Route::get('/get_subcategory_fields/{id}', 'UserController@get_subcategory_fields')->name('get_subcategory_fields');
Route::post('/report-abuse', 'UserController@store_report_abuse')->name('report.abuse');

Route::middleware('auth')->group(function () {
    Route::post('/favorites/toggle/{product}', 'UserController@toggle')->name('favorites.toggle');
    Route::get('favorites_ad','UserController@favorites_ad')->name('favorites_ad');
});



//search
Route::get('/search', 'UserController@search')->name('search');

//Post Ad
Route::get('/post_ad', 'UserController@post_ad')->middleware('auth')->name('post_ad');
Route::post('/store_ad', 'UserController@store_ad')->middleware('auth')->name('store_ad');
Route::get('/get-subcategories/{id}', 'UserController@getSubcategories')->name('get.subcategories');

//Chats
Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', 'ChatController@inbox')->name('chat.inbox');
    Route::post('/chat/send', 'ChatController@send')->name('chat.send');
    Route::get('/chat/{productId}/{receiverId}','ChatController@chat')->name('chat');
    Route::get('/chat_fetch/{conversationId}', 'ChatController@fetch')->name('chat.fetch');
    Route::get('/load/{conversationId}', 'ChatController@loadChat')->name('chat.load');
    Route::post('/chat/mark-read', 'ChatController@markAsRead')->name('chat.markAsRead');
    Route::post('/typing', 'ChatController@typing');

    
});
// routes/web.php
Route::post('/broadcasting/auth', '\Illuminate\Broadcasting\BroadcastController@authenticate')->middleware('auth');




//Admin
Route::group(['middleware' => ['auth','isAdmin']], function () {

    Route::get('/admin1', function () {
       return view('Admin.dashboard');
    });
    Route::get('/admin1', 'AdminController@index')->name('admin1');
    Route::get('manage_user', 'AdminController@manage_user')->name('manage_user');
    Route::post('/user_ban/{id}', 'AdminController@ban')->name('user_ban');
    Route::post('/user_unban/{id}', 'AdminController@unban')->name('user_unban');
    Route::get('/about', 'AdminController@about')->name('about');
    Route::post('/store_about', 'AdminController@store_about')->name('store_about');
    Route::put('/update_about/{id}', 'AdminController@update_about')->name('update_about');


    //category
    Route::get('/add_category', 'CategoryController@add_category')->name('add_category');
    Route::get('/manage_category', 'CategoryController@manage_category')->name('manage_category');
    Route::post('/store_category','CategoryController@store_category')->name('store_category');
    Route::get('category-edit/{id}','CategoryController@edit_category')->name('category-edit');
    Route::get('category-delete/{id}','CategoryController@delete_category')->name('category-delete');
    Route::put('/category_update/{id}', 'CategoryController@update_category')->name('category_update');
    
    //subcategory
   Route::get('/add_subcategory', 'SubcategoryController@add_subcategory')->name('add_subcategory');
   Route::post('/store_subcategory','SubcategoryController@store_subcategory')->name('store_subcategory');
   Route::get('/manage_subcategory', 'SubcategoryController@manage_subcategory')->name('manage_subcategory');
   Route::get('subcategory-edit/{id}','SubcategoryController@edit_subcategory')->name('subcategory-edit');
   Route::get('subcategory-delete/{id}','SubcategoryController@delete_subcategory')->name('subcategory-delete');
   Route::put('/subcategory_update/{id}', 'SubcategoryController@update_subcategory')->name('subcategory_update');
 
//product
   Route::get('/manage_product', 'ProductController@manage_product')->name('manage_product');
   Route::post('update_status', 'ProductController@update_status')->name('update_status');
   Route::get('product_delete/{id}','ProductController@product_delete')->name('product_delete');


 });






