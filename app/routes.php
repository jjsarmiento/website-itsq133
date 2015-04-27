<?php
// REMINDERS - By Jan Sarmiento
//    on the php folder>file php.ini uncomment the extension=php_fileinfo.dll line
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

// WEBSITE ROUTES -- START
Route::group(array('before' => 'DESTROY-ADMIN'), function(){
    Route::get('/', 'WebMainController@index');
    Route::get('/home', 'WebMainController@index');
    Route::get('/gallery', 'WebMainController@gallery');
    Route::get('/about', 'WebMainController@about');
    Route::get('/contactus', 'WebMainController@contactus');
    Route::get('/doLogout', 'WebMainController@doLogout');
    Route::post('/doLogin', 'WebMainController@doLogin');
    Route::post('/doRegister', 'WebMainController@doRegister');
    Route::get('/getArticle/{id}', 'WebMainController@getArticle');
});

Route::group(array('before' => 'ROUTE-PROTECT'), function(){
    Route::get('/login', 'WebMainController@login');
    Route::get('/register', 'WebMainController@register');
});
// WEBSITE ROUTES -- END

// ADMIN ROUTES -- START

Route::group(array('before' => 'DESTROY-USER'), function(){
    Route::get('/admin/', 'AdminController@index');
    Route::get('/admin/login', 'AdminController@index');
    Route::post('/admin/doLogin', 'AdminController@doLogin');
    Route::get('/admin/logout', 'AdminController@logout');
});

Route::group(array('before' => 'ADMIN'), function(){
    Route::get('/admin/home', 'AdminController@promotions');
    Route::get('/admin/users', 'AdminController@users');
    Route::get('/admin/deactivate/{id}', 'AdminController@deactivate');
    Route::get('/admin/activate/{id}', 'AdminController@activate');
    Route::get('/admin/profile/{id}', 'AdminController@profile');
    Route::post('/admin/changepass/{id}', 'AdminController@changepass');
    Route::get('/admin/comments', 'AdminController@comments');
    Route::get('/admin/images', 'AdminController@images');
    Route::get('/admin/videos', 'AdminController@videos');
    Route::post('/admin/upload/{id}', 'AdminController@upload');
    Route::get('/admin/general', 'AdminController@general');
    Route::get('/admin/preview/aboutus', 'AdminController@previewAboutus');
    Route::get('/admin/homeManage', 'AdminController@homeManage');
    Route::get('/admin/contactus', 'AdminController@contactus');
    Route::post('/admin/updateAboutus', 'AdminController@updateAboutus');
    Route::post('/admin/updateSlogan', 'AdminController@updateSlogan');
    Route::post('/admin/updateHomeslogan', 'AdminController@updateHomeslogan');
    Route::get('/admin/deleteAboutus', 'AdminController@deleteAboutus');
    Route::get('/admin/deleteSlogan', 'AdminController@deleteSlogan');
    Route::get('/admin/deleteHomeslogan', 'AdminController@deleteHomeslogan');
    Route::get('/admin/promotions', 'AdminController@promotions');
    Route::post('/admin/addLocation', 'AdminController@addLocation');
    Route::post('/admin/editLocation', 'AdminController@editLocation');
    Route::get('/admin/article/{id}', 'AdminController@article');
    Route::post('/admin/addArticle', 'AdminController@addArticle');
    Route::get('/admin/deleteLocation/{id}', 'AdminController@deleteLocation');
    Route::post('/admin/editArticle', 'AdminController@editArticle');
    Route::post('/admin/uploadArticleImage/{id}', 'AdminController@uploadArticleImage');
});

// ADMIN ROUTES -- END

// THIS FUNCTION IS FOR ROUTE PROTECTION - IT REDIRECTS THE SYSTEM WHEN THE ROUTE/METHOD IS NOT FOUND AND/OR DOESN'T EXIST - Jan Sarmiento
App::missing(function(){
    return View::make('Route404');
});