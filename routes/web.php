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


// Route::get('/', function () {
//     return view('home');
// });


Route::get('/helpline/submitted','HelplineController@submitted');
Route::get('/fakenews/submitted','FakenewsController@submitted');
Route::get('/hotline/submitted','HotlineController@submitted');


Auth::routes();

Route::group(['middleware' => ['web','auth']], function () {

    Route::get('/', 'HomeController@index');
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    // User Routing, protected with middleware

    Route::group(['middleware' => ['permission:delete_users']], function () {
        Route::delete('/users/{user}','UserController@destroy')->name('users.destroy');
    });

    Route::group(['middleware' => ['permission:create_users']], function () {
        Route::get('/users/create','UserController@create')->name('users.create');
        Route::post('/users','UserController@store')->name('users.store');
    });

    Route::group(['middleware' => ['permission:edit_users']], function () {
        Route::put('/users/{user}','UserController@update')->name('users.update');
    });

    Route::group(['middleware' => ['permission:view_users']], function () {
        Route::get('/users/{user}/','UserController@edit')->name('users.edit');
        Route::get('/users','UserController@index')->name('users.index');
    });

    // allow to edit yourself
    Route::get('/profile/edit','UserController@self_edit')->name('profile.edit');
    Route::put('/profile/edit','UserController@self_update')->name('profile.update');
    
    /*
    *   Roles
    */
    Route::group(['middleware' => ['permission:delete_roles']], function () {
        Route::delete('/roles/{role}','RoleController@destroy')->name('roles.delete');
    });

    Route::group(['middleware' => ['permission:create_roles']], function () {
        Route::get('/roles/create','RoleController@create');
        Route::post('/roles','RoleController@store');
    });

    Route::group(['middleware' => ['permission:delete_roles']], function () {
        Route::put('/roles/{role}','RoleController@update')->name('roles.update');
    });

    Route::group(['middleware' => ['permission:view_roles']], function () {
        Route::get('/roles/{role}/edit','RoleController@edit')->name('roles.edit');
        Route::get('/roles/{role}','RoleController@show')->name('roles.show');
        Route::get('/roles','RoleController@index')->name('roles.index');
    });

    /*
    *   Inputs
    */
    
    Route::group(['middleware' => ['permission:delete_content']], function () {
        Route::delete('/resourceType/{resourceType}','ResourceTypeController@destroy');

        Route::delete('/contentType/{contentType}','ContentTypeController@destroy');

        Route::delete('/referenceBy/{referenceBy}','ReferenceByController@destroy');

        Route::delete('/referenceTo/{referenceTo}','ReferenceToController@destroy');
    });

    Route::group(['middleware' => ['permission:create_content']], function () {
        Route::get('/resourceType/create','ResourceTypeController@create')->name('resourceType.create');
        Route::post('/resourceType','ResourceTypeController@store');

        Route::get('/contentType/create','ContentTypeController@create')->name('contentType.create');
        Route::post('/contentType','ContentTypeController@store');

        Route::get('/referenceBy/create','ReferenceByController@create')->name('referenceBy.create');
        Route::post('/referenceBy','ReferenceByController@store');

        Route::get('/referenceTo/create','ReferenceToController@create')->name('referenceTo.create');
        Route::post('/referenceTo','ReferenceToController@store');
    });

    Route::group(['middleware' => ['permission:edit_content']], function () {
        Route::put('/resourceType/{resourceType}','ResourceTypeController@update')->name('resourceType.update');

        Route::put('/contentType/{contentType}','ContentTypeController@update')->name('contentType.update');

        Route::put('/referenceBy/{referenceBy}','ReferenceByController@update')->name('referenceBy.update');

        Route::put('/referenceTo/{referenceTo}','ReferenceToController@update')->name('referenceTo.update');
    });

    Route::group(['middleware' => ['permission:view_content']], function () {
        Route::get('/resourceType/{resourceType}/edit','ResourceTypeController@edit')->name('resourceType.edit');
        Route::get('/resourceType/{resourceType}','ResourceTypeController@show')->name('resourceType.show');
        Route::get('/resourceType','ResourceTypeController@index')->name('resourceType.index');

        Route::get('/contentType/{contentType}/edit','ContentTypeController@edit')->name('contentType.edit');
        Route::get('/contentType/{contentType}','ContentTypeController@show')->name('contentType.show');
        Route::get('/contentType','ContentTypeController@index')->name('contentType.index');

        Route::get('/referenceBy/{referenceBy}/edit','ReferenceByController@edit')->name('referenceBy.edit');
        Route::get('/referenceBy/{referenceBy}','ReferenceByController@show')->name('referenceBy.show');
        Route::get('/referenceBy','ReferenceByController@index')->name('referenceBy.index');

        Route::get('/referenceTo/{referenceTo}/edit','ReferenceToController@edit')->name('referenceTo.edit');
        Route::get('/referenceTo/{referenceTo}','ReferenceToController@show')->name('referenceTo.show');
        Route::get('/referenceTo','ReferenceToController@index')->name('referenceTo.index');
    });

    /*
    * Manager
    */
    Route::group(['middleware' => ['role:manager']], function () {
        Route::get('/helpline/showManager', [ 'as' => 'show-helpline-manager', 'uses' => 'HelplineController@showManager']);
        Route::patch('/helpline/editManager', [ 'as' => 'edit-helpline-manager', 'uses' => 'HelplineController@editManager']);
        Route::get('/hotline/showManager', [ 'as' => 'hotline.show.manage', 'uses' => 'HotlineController@showManager']);
        Route::patch('/hotline/editManager', [ 'as' => 'edit-hotline-manager', 'uses' => 'HelplineController@editManager']);
    });

    Route::get('/hotline/changeFromHotline', [ 'as' => 'hotline.move-helpline', 'uses' => 'HotlineController@changeFromHotline']);
    Route::get('/helpline/changeFromHelpLine', [ 'as' => 'helpline.move-hotline', 'uses' => 'HelplineController@changeFromHelpLine']);
  
    /*
    * Helpline
    */

    Route::group(['middleware' => ['permission:create_helpline']], function () {
        Route::get('/helpline/create','HelplineController@create')->name('create-helpline'); // form
    });

    Route::group(['middleware' => ['permission:view_helpline']], function () {
        Route::get('/helpline/{helpline}','HelplineController@show')->name('show-helpline'); // invastigation form
        Route::get('/helpline','HelplineController@index'); // show all helpline
    });


    Route::group(['middleware' => ['permission:delete_helpline']], function () {
        Route::delete('/helpline/{helpline}','HelplineController@destroy'); // delete report
    });  

    /*
    * Hotline
    */

    Route::group(['middleware' => ['permission:create_hotline']], function () {
        Route::get('/hotline/create','HotlineController@create')->name('hotline.create'); // form
    });

    Route::group(['middleware' => ['permission:view_hotline']], function () {
        Route::get('/hotline/{hotline}','HotlineController@show')->name('hotline.show'); // Investigation form
        Route::get('/hotline','HotlineController@index')->name('hotline'); // show all hotline
    });

    Route::group(['middleware' => ['permission:delete_hotline']], function () {
        Route::delete('/hotline/{hotline}','HotlineController@destroy')->name('delete-hotline'); // delete report
    });

    /*
    * Fakenews
    */

    Route::group(['middleware' => ['permission:create_fakenews']], function () {
        Route::get('/fakenews/create','FakenewsController@create')->name('create.fakenews'); // form
    });

    Route::group(['middleware' => ['permission:view_fakenews']], function () {
        Route::get('/fakenews/{fakenews}','FakenewsController@show')->name('show.fakenews'); // invastigation form
        Route::get('/fakenews','FakenewsController@index'); // show all fakenews
    });


    Route::group(['middleware' => ['permission:delete_fakenews']], function () {
        Route::delete('/fakenews/{fakenews}','FakenewsController@destroy')->name('delete.fakenews'); // delete report
    });  


    /*
    * Investigation, this is used for both helpline and hotline.
    */
    Route::group(['middleware' => ['permission:edit_helpline, edit_hotline']], function () {
        Route::patch('/helpline/{helpline}/edit','HelplineController@edit')->name('edit-helpline'); // edit Investigation 
    });

    Route::group(['middleware' => ['permission:edit_fakenews']], function () {
        Route::patch('/fakenews/{fakenews}/edit','FakenewsController@edit')->name('edit-fakenews'); // edit invastigation
        Route::get('/fakenews/{fakenews}/delete/{image_id}','FakenewsController@deleteimage')->name('delete-image-fakenews');
        //Route::get('/fakenews/{fakenews/add_image}','FakenewsController@deleteimage')->name('add-image-fakenews');
    });

    /*
    *   Statistics
    */
    Route::group(['middleware' => ['permission:view_statistics']], function () {
        Route::get('statistics/fakenews','StatisticsController@index_fakenews')->name('show.fakenews.stats');
        Route::get('statistics/gen_charts','StatisticsController@gen_charts')->name('gen.charts');
        Route::resource('statistics','StatisticsController');
    });

    // Online Users
    Route::get('/online','OnlineUsersController@index');

    /*
    *   Logs
    */
    Route::group(['middleware' => ['permission:view_logs']], function () {
        Route::get('logs/hotline_helpline','HelplinesLogController@index')->name('helplinesLogController.index');
        Route::get('logs/hotline_helpline/{id}','HelplinesLogController@timeline')->name('helplinesLogController.timeline');
        Route::get('logs/{log}','HelplinesLogController@show')->name('helplinesLogController.show');
    });

    Route::group(['middleware' => ['permission:delete_logs']], function () {
        Route::delete('/logs/hotline_helpline/{id}' ,'HelplinesLogController@destroy')->name('helplinesLogController.destroy');
        Route::delete('/logs/hotline_helpline/' ,'HelplinesLogController@mass_destroy')->name('helplinesLogController.mass_destroy');
    });

    /*
    *   Settings
    */
    Route::group(['middleware' => ['permission:view_settings']], function () {
        Route::get('settings/automated_deletion','SettingsController@index')->name('settingsController.index');
    });
    Route::group(['middleware' => ['permission:edit_settings']], function () {
        Route::post('settings/automated_deletion/update-helpline','SettingsController@store')->name('settingsController.store');
    });

    /*
    * Actions, depricated?
    */
    // Route::resource('actions','ActionTakenController');

});

Route::get('/fakenews_evals','FakenewsController@evalview');
// both loggedin users & loggedout can create a resource, this is used by hotline & helpline
Route::post('/helpline','HelplineController@store')->name('save-helpline'); // create form post request.

// both loggedin users & loggedout can create a resource, this is used by fakenews
Route::post('/fakenews','FakenewsController@store')->name('save-fakenews'); // create form post request.


Route::get('/helpline/{loc}/form/','HelplineController@index');
Route::get('/hotline/{loc}/form/','HotlineController@index');
Route::get('/fakenews/{loc}/form/','FakenewsController@index');



/*
/   Route to get the Current language to
/   display the prefered view.
*/
Route::get('/setlang/{lang}', function($lang){
    $web = explode('/',url()->previous());
    App::setLocale($lang);
    Session::put('lang', $lang );
    //Check if the delimiter is Chat
    if($web[3] != 'chat'){
        return redirect( $web[3] .'/'.$lang.'/form');
    } else {
        return redirect('chat/'. $lang);
    }

});

/*
  Chatrooms
*/
Route::get('/messages/{chat_id}','MessageController@show');
Route::post('/messages','MessageController@store');
Route::post('/messages/notify','MessageController@notify');
Route::post('/messages/change/{id}','MessageController@edit');
Route::get('/chatroom','ChatroomController@index');
Route::delete('/messages/{chatid}' ,'MessageController@destroy');
Route::post('/chatroom/{id}','ChatroomController@edit');
Route::get('/chatroom/{id}','ChatroomController@show');

Route::get('/chatroom/online','MessageController@show');


/*
|       Extra Pages
*/
Route::get('/chat/{lang}',function($lang){
    App::setLocale($lang);
    Session::put('lang', $lang );
    return view('chat');
});

Route::get( '/chat',function (){
    App::setLocale('en');
    Session::put('lang', 'en' );
    return redirect('/chat/en');
});


Route::get('/foo',function (){
    // $data = App\Chatroom::all();
    $data = App\Statistics::find(122);
    // $data = App\Chatroom::where('status', '1')->orderBy('id', 'DESC')->first();
    return $data;
});
