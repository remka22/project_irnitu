<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public static function campus_auth()
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
        if (!isset($_REQUEST['code'])) {
            header('HTTP 302 Found');
            header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
            exit;
        }
        # ЭТАП 2 - авторизация приложения
        if (isset($_REQUEST['code'])) {
            # формирование параметров запроса
            $url = implode('&', [
                'https://int.istu.edu/oauth/token/?grant_type=authorization_code',
                'code=' . $_REQUEST['code'],
                'client_id=' . $APP['ID'],
                'client_secret=' . $APP['CODE']
            ]);

            # выполнение запроса и обработка ответа

            $data = @file_get_contents($url);

            if (explode(' ', $http_response_header[0])[1] !== '200') return false;
            $data = json_decode($data, true);
        }
        // # ЭТАП 3 - запрос данных по учетной записи
        // if (isset($data['client_endpoint']) && isset($data['access_token'])) {
        //     # формирование параметров запроса
        //     $url = $data['client_endpoint'] . 'user.info.json?auth=' . $data['access_token'];
        //     # выполнение запроса и обработка ответа
        //     $data = @file_get_contents($url);
        //     if (explode(' ', $http_response_header[0])[1] !== '200') return false;
        //     $data = json_decode($data, true);
        //     # проверка наличия структуры данных
        //     if (isset($data['result']['email'])) $return = $data['result'];
        // }
        // # возврат
        // return $return;
        dd($data);
    }
}
