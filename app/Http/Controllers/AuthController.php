<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public static function check_auth()
    {
        return route_auth();
    }

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
    if (User::where('mira_id', $return['mira_id'][0])->get()->count() == 0) {
        $user = new User;
        $user->name = $return['name'];
        $user->last_name = $return['last_name'];
        $user->second_name = $return['second_name'];
        $user->email = $return['email'];


        if ($return['is_student']) {
            $user->type = 'student';
        }
        if ($return['is_teacher']) {
            if (strpos($return['data_teacher']['dep'], 'Отдел по работе со студентами') === true) {
                $user->type = 'direct';
            } elseif (strpos($return['data_teacher']['dep'], 'Центр карьеры') === true) {
                $user->type = 'center';
            } else {
                $user->type = 'teacher';
            }
        }

        $user->password = bcrypt('AzSxDc132!');
        $user->mira_id = $return['mira_id'][0];
        $user->save();
    }

    if (!Auth::attempt(['email' => $return['email'], 'password' => 'AzSxDc132!'])) {
        return response([
            'message' => 'Provided email or password is incorrect'
        ], 422);
    }

    return route_auth();
}

function route_auth()
{
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->type) {
            case "student":
                return redirect('/student');
                break;
            case "teacher":
                return redirect('/teacher');
                break;
            case "direct":
                return redirect('/direct');
                break;
            case "center":
                return redirect('/center');
                break;
            case "rop":
                return redirect('/rop');
                break;
            case "admin":
                return redirect('/admin/home');
                break;
        }
    } else {
        return redirect('/bitrix');
    }
}
