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

Auth::routes();

Route::group(['middleware' => ['web','auth']], function () {

    Route::get('/', 'HomeController@index');
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    /**
     * Users resource that provides all the routes under the /users, and
     * the UserController is responsible for each REST call.
     *
     */
    Route::resource('users','UserController');

    /**
    * Roles resource that provides all the routes under the /roles, and
    * the RoleController is responsible for each REST call.
    */
    Route::resource('/roles', 'RoleController',[
        'names' => [
            'destroy' => 'delete-role',
            'index' => 'roles',
            'update' => 'update-role',
        ]
    ]);

    /**
    * Permissions resource that provides all the routes under the /permissions, and
    * the PermissionController is responsible for each REST call.
     */
    Route::resource('/permissions', 'PermissionController');

    /**
    * Group resource that provides all the routes under the /groups, and
    * the GroupController is responsible for each REST call.
     */
    Route::resource('/groups','GroupController');


    /*
    *   Inputs
    */
    Route::resource('resourceType','ResourceTypeController');
    Route::resource('contentType','ContentTypeController');
    Route::resource('referenceBy','ReferenceByController');
    Route::resource('referenceTo','ReferenceToController');

    /*
    *   Statistics
    */
    Route::resource('statistics','StatisticsController');
    
    /*
    | Actions
    */
    Route::resource('actions','ActionTakenController');

    Route::get('/helpline/showManager', [ 'as' => 'show-helpline-manager', 'uses' => 'HelplineController@showManager']);
    Route::get('/helpline/editManager', [ 'as' => 'edit-helpline-manager', 'uses' => 'HelplineController@editManager']);
    Route::get('/hotline/showManager', [ 'as' => 'hotline.show.manage', 'uses' => 'HotlineController@showManager']);
    Route::get('/hotline/editManager', [ 'as' => 'edit-hotline-manager', 'uses' => 'HelplineController@editManager']);

    Route::get('/hotline/changeFromHotline', [ 'as' => 'hotline.move-helpline', 'uses' => 'HotlineController@changeFromHotline']);
    Route::get('/helpline/changeFromHelpLine', [ 'as' => 'helpline.move-hotline', 'uses' => 'HelplineController@changeFromHelpLine']);
});

/*
*   Routes from this point will not use the auth middleware
*   and will not need to login to access them
*/

Route::get('/helpline/submitted','HelplineController@submitted');
Route::get('/hotline/submitted','HotlineController@submitted');


Route::resource('/hotline','HotlineController',[
    'names' => [
        'index' => 'hotline',
        'destroy' => 'delete-hotline',
    ]
]);

Route::resource('/helpline','HelplineController',[
    'names' => [
        'create' => 'create-helpline',
        'store' => 'save-helpline',
        'destroy' => 'delete-helpline',
        'show' => 'show-helpline',
        'edit' => 'edit-helpline',
    ]
]);

Route::get('/helpline/{loc}/form/','HelplineController@index');
Route::get('/hotline/{loc}/form/','HotlineController@index');

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
