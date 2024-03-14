<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public static function campus_auth($request)
    {
        # переменные
        $return = false;

        $APP = [
            'ID' => 'local.65e57544bd23d6.71638042',
            'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
        ];
        # ЭТАП 1 - авторизация учетной записи в ЛИЧНОМ КАБИНЕТЕ
        # редирект на страницу авторизации
        # редирект обратно после успешной авторизации
        // if (!isset($_REQUEST['code'])) {
        if (!$request->get('code')) {
            //header('HTTP 302 Found');
            return header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
            exit;
        }
        # ЭТАП 2 - авторизация приложения
        $client = new \GuzzleHttp\Client();
        if ($request->get('code')) {
            # формирование параметров запроса
            $url = implode('&', [
                'https://int.istu.edu/oauth/token/?grant_type=authorization_code',
                'code=' . $_REQUEST['code'],
                'client_id=' . $APP['ID'],
                'client_secret=' . $APP['CODE']
            ]);

            # выполнение запроса и обработка ответа
            $res = $client->get($url);
            $data = (string) $res->getBody();
            //$data = @file_get_contents($url);

            //if (explode(' ', $http_response_header[0])[1] !== '200') return false;
            $data = json_decode($data, true);
        }
        # ЭТАП 3 - запрос данных по учетной записи
        if (isset($data['client_endpoint']) && isset($data['access_token'])) {
            # формирование параметров запроса
            $url = $data['client_endpoint'] . 'user.info.json?auth=' . $data['access_token'];

            # выполнение запроса и обработка ответа
            $res = $client->get($url);
            $data = (string) $res->getBody();
            //$data = @file_get_contents($url);

            //if (explode(' ', $http_response_header[0])[1] !== '200') return false;
            $data = json_decode($data, true);
            # проверка наличия структуры данных
            if (isset($data['result']['email'])) $return = $data['result'];
        }
        # возврат
        //return $return;
        // dd($return);
        return auth($return);
    }

    public static function logout()
    {
        Auth::logout();
    }
}

function auth($return)
{
    if ($return['is_student']) {
        if (User::where('mira_id', $return['mira_id'][0])->get()->count() == 0) {
            $user = new User;
            $user->name = $return['name'];
            $user->last_name = $return['last_name'];
            $user->second_name = $return['second_name'];
            $user->email = $return['email'];
            $user->type = 'student';
            $user->password = bcrypt('AzSxDc132!');
            $user->mira_id = $return['mira_id'][0];
            $user->save();
        }
        else{
            if (!Auth::attempt(['email' => $return['email'], 'password' => 'AzSxDc132!'])) {
                return response([
                    'message' => 'Provided email or password is incorrect'
                ], 422);
            }
        }


        

        return redirect('/student');
    }
    if ($return['is_teacher']) {
        return redirect('/teacher');
    }
}
