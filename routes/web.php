<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Insertcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    //return Insertcontroller::get();
    // return AuthController::campus_auth();
    $APP = [
        'ID' => 'local.65e57544bd23d6.71638042',
        'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
    ];
    return header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
});

Route::get('/bitrix', function (Request $request) {
    // dd($request);
    $APP = [
        'ID' => 'local.65e57544bd23d6.71638042',
        'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
    ];
    if (isset($_REQUEST['code'])) {
        
        # формирование параметров запроса
        $url = implode('&', [
            'https://int.istu.edu/oauth/token/?grant_type=authorization_code',
            'code=' . $_REQUEST['code'],
            'client_id=' . $APP['ID'],
            'client_secret=' . $APP['CODE']
        ]);

        # выполнение запроса и обработка ответа

        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);
        $content = (string) $res->getBody();
        
        dd($content);

        $data = @file_get_contents($url);

        if (explode(' ', $http_response_header[0])[1] !== '200') return false;
        $data = json_decode($data, true);
        
        dd($data);
    }
});