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
    // $APP = [
    //     'ID' => 'local.65e57544bd23d6.71638042',
    //     'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
    // ];
    // return header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
    return header('Location: https://int.istu.edu/bitrix');
});

Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
    // // dd($request);
    // $APP = [
    //     'ID' => 'local.65e57544bd23d6.71638042',
    //     'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
    // ];
    // $client = new \GuzzleHttp\Client();
    // if (isset($_REQUEST['code'])) {
        
    //     # формирование параметров запроса
    //     $url = implode('&', [
    //         'https://int.istu.edu/oauth/token/?grant_type=authorization_code',
    //         'code=' . $_REQUEST['code'],
    //         'client_id=' . $APP['ID'],
    //         'client_secret=' . $APP['CODE']
    //     ]);

    //     # выполнение запроса и обработка ответа
    //     $res = $client->get($url);
    //     $data = (string) $res->getBody();
        
    //     //dd($content);

    //     //$data = @file_get_contents($url);

    //     //if (explode(' ', $http_response_header[0])[1] !== '200') return false;
    //     $data = json_decode($data, true);
        
    //     //dd($data);
    // }
    // if (isset($data['client_endpoint']) && isset($data['access_token'])) {
    //     # формирование параметров запроса
    //     $url = $data['client_endpoint'] . 'user.info.json?auth=' . $data['access_token'];

    //     # выполнение запроса и обработка ответа
    //     //$data = @file_get_contents($url);
    //     $res = $client->get($url);
    //     $data = (string) $res->getBody();
    //     //dd($data);
         
    //     //if (explode(' ', $http_response_header[0])[1] !== '200') return false;
    //     $data = json_decode($data, true);
    //     dd($data);
    //     # проверка наличия структуры данных
    //     if (isset($data['result']['email'])) $return = $data['result'];
    // }
});