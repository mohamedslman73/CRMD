<?php
//use Symfony\Component\HttpFoundation\File\UploadedFile;

Route::get('/', function () {
    return view('welcome');
});



/*Route::group(['domain'=>'{account}.{domain}.{tld}'],function () {
    Route::get('/', function ($account,$domain,$tld) {
        return $account;
    });
    http://gad.hexxie.com:8000/
});*/

Route::get("part",function (Illuminate\Http\Request $request){
    echo "<form method='post' enctype='multipart/form-data'>";
    echo csrf_field();
    echo "<input name='pics[]' type='file' multiple>";
    echo "<input type='submit'>";
    echo "</form>";
});
Route::post("part",'Api\RegionsController@testUpload');

Route::get('test',function ()
{
    return App\Message::where('id',5)->first();
});
