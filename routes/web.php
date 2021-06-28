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

Route::get('/', function () {
    return view('welcome');
});


/*
Route::get('/admin',['middleware'=> 'isrole', function () {
    return view('admin');
}]);
*/
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=> ['isrole']], function () {
Route::get('/',function (){
    return view('admin');
});
Route::group(['prefix' => 'user_managment','namespace'=>'UserManagment'],function(){
    Route::resource('/users','UserControlers',['as'=>'admin.user_managment']);
});

    Route::resource('/color1','Color1Controller',['as'=>'admin']);
    Route::resource('/color2','Color2Controller',['as'=>'admin']);

    Route::resource('/comment1','Comment1Controller',['as'=>'admin']);

    Route::resource('/bank','BankController',['as'=>'admin']);
    Route::resource('/product','ProductController',['as'=>'admin']);
    Route::resource('/policy','PolicyController',['as'=>'admin']);

    Route::resource('/template','TemplateController',['as'=>'admin']);

    Route::resource('/other','OtherController',['as'=>'admin']);

    Route::resource('/baseasg','SecondDatabaseController',['as'=>'admin']);
    Route::post("/parse-csv", "SecondDatabaseController@importData",['as'=>'admin']);


    //report
    Route::get('/report_agent','ReportController@report_agent',['as'=>'admin']);
    Route::post('/report_agent_','ReportController@report_agent_',['as'=>'admin']);
    Route::get('/report_agent_csv','ReportController@report_agent_csv',['as'=>'admin']);

    Route::get('/report_bank','ReportController@report_bank',['as'=>'admin']);
    Route::post('/report_bank_','ReportController@report_bank_',['as'=>'admin']);
    Route::get('/report_bank_csv','ReportController@report_bank_csv',['as'=>'admin']);

    Route::get('/report_percent','ReportController@report_percent',['as'=>'admin']);
    Route::post('/report_percent_','ReportController@report_percent_',['as'=>'admin']);
    Route::get('/report_percent_csv','ReportController@report_percent_csv',['as'=>'admin']);

    Route::get('/report_agent_call','ReportController@report_agent_call',['as'=>'admin']);
    Route::post('/report_agent_call_','ReportController@report_agent_call_',['as'=>'admin']);
    Route::get('/report_agent_call_csv','ReportController@report_agent_call_csv',['as'=>'admin']);

    Route::get('/report_incorrect','ReportController@report_incorrect',['as'=>'admin']);
    Route::post('/report_incorrect_','ReportController@report_incorrect_',['as'=>'admin']);
    Route::get('/report_incorrect_csv','ReportController@report_incorrect_csv',['as'=>'admin']);


});



Route::get('/manager',['middleware'=> 'auth', function () {
    return view('manager');
}]);

Route::get('/users',['middleware'=> 'auth', function () {
    return view('users');
}]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('change_incorrect', 'RegionController@change_incorrect');
Route::get('search_city', 'RegionController@search_city');
Route::get('search_region', 'RegionController@search_region');
Route::get('search_phone', 'RegionController@search_phone');
Route::get('search_fio', 'RegionController@search_fio');
Route::get('search_client', 'RegionController@search_client');
Route::get('search_policy', 'RegionController@search_policy');
Route::get('searchinfopolicy', 'RegionController@searchinfopolicy');
Route::get('searchinfoclient', 'RegionController@searchinfoclient');
Route::get('add_phone', 'RegionController@add_phone');

Route::get('search_color1listing', 'RegionController@search_color1listing');
Route::get('search_color2listing', 'RegionController@search_color2listing');
Route::get('search_comment1listing', 'RegionController@search_comment1listing');

Route::get('search_banklisting', 'RegionController@search_banklisting');
Route::get('search_productlisting', 'RegionController@search_productlisting');
Route::get('search_regexproduct', 'RegionController@search_regexproduct');
Route::get('searchinfoproduct', 'RegionController@searchinfoproduct');
Route::get('search_templetesms', 'RegionController@search_templetesms');
Route::get('search_smsonphone', 'RegionController@search_smsonphone');


Route::get('realclientinfo', 'RegionController@realclientinfo');


Route::get('search_newcall', 'RegionController@search_newcall');
Route::get('search_callinfo', 'RegionController@search_callinfo');
Route::get('search_makenewcall', 'RegionController@search_makenewcall');
Route::get('search_newbell', 'RegionController@search_newbell');
Route::post('search_sendsms', 'RegionController@search_sendsms');

Route::get('searchcolorinfo', 'RegionController@search_colorinfo');

Route::get('search_user', 'RegionController@search_user');
Route::get('search_group', 'RegionController@search_group');
Route::get('search_colorclient', 'RegionController@search_colorclient');
Route::get('search_bankbank', 'RegionController@search_bankbank');
Route::get('search_product_bank', 'RegionController@search_product_bank');

Route::resource('/client','ClientController' ,['middleware'=> 'auth']);

Route::resource('/findclient','FindclientController' ,['middleware'=> 'auth']);
