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
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Jrean\UserVerification as send;
use Illuminate\Support\Facades\Mail;

Route::get('/','onecontroller@index');
Route::get('/Home','onecontroller@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search' , 'onecontroller@search');

Route::get('map' , 'onecontroller@index');
Route::get('/many', function (){

    $province = \App\Province::findOrFail(1);
    $result =\App\Province::join('cities' ,'provinces.id','=','cities.Province')->get();
    echo $result;
});

$this->get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
Route::get('/mail',  function() {
    $user = \App\User::find(1);


    send( $user, $subject = null, $from = null, $name = null);
});
//      imamzade controller
Route::get('imamzade/creates','imamzadecontroller@creates');
Route::resource('imamzade','imamzadecontroller');

Route::get('join',function (){
   $result = \Illuminate\Support\Facades\DB::table('imamzades')
       ->join('cities', 'cities.Cid', '=', 'imamzades.CID')
       ->join('provinces', 'provinces.Pid', '=', 'imamzades.PID')
       ->get();
   return $result;
});


Route::get('detail/{iid}','imamzadecontroller@detail');
Route::get('logout' , 'Auth\LoginController@logout');

Route::post('searchroute' ,'onecontroller@managesearch');
Route::post('cmap','onecontroller@custommap');
Route::get('map{id}', 'onecontroller@map');
Route::get('tmap{id}','onecontroller@tmap');

Route::get('manage' , 'onecontroller@manage');
Route::get('edit{id}','onecontroller@edit');
Route::get('tdetail/{id}' , 'onecontroller@tdetail');
Route::get('verify/{id}','onecontroller@verify');
Route::get('profile/{id}' , 'onecontroller@profile');
Route::post('changepass','onecontroller@change');
Route::get('changep',function (){
    return view('
    changepass');
});