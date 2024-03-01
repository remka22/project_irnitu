<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Insertcontroller extends Controller
{
    public static function get()
    {
        // $group = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034',
        //                                         'mNNxbKiXS9', 'allspec.info');
        // $arr_faculty = [];
        // $faculty = getInstituteFromAis($group);
        //         foreach($faculty as $num => $value){
        //                 //connection()->query("insert into Practices.faculty (name) values ('".$value."')");
        //                 $arr_faculty[] = $value;
        //         }
        // $company = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034', 'mNNxbKiXS9', 'practice.company');
        // //return dd(json_encode($arr_faculty, JSON_UNESCAPED_UNICODE));
        // $users = DB::connection('mariadb')->select("select * from faculty");
        // dd($users);
        return view('insert');
    }

    public static function post($request)
    {
        if ($request->input('insertInst')) {
            return insertFuculty();
        }
        if ($request->input('insertProf')) {
            return insertProfiles();
        }
        if ($request->input('insertStream')) {
            //insertStreams();
        }
        if ($request->input('insertStud')) {
            //insertStud();
        }
        if ($request->input('insertComp')) {
            return insertComp();
        }
    }
}

function insertFuculty()
{
    $group = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034', 'mNNxbKiXS9', 'allspec.info');
    $arr_faculty = [];
    $faculty = getInstituteFromAis($group);
    foreach ($faculty as $num => $value) {
        //DB::connection('mariabd')->insert("insert into faculty (name) values ('".$value."')");
        //$arr_faculty[] = $value;
    }
    return redirect("/"); //dd(json_encode($arr_faculty, JSON_UNESCAPED_UNICODE));
}

function insertComp()
{
    $company = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034', 'mNNxbKiXS9', 'practice.company');
    $comp = [];
    foreach ($company["RecordSet"] as $num => $value) {
        //DB::connection('mariabd')->insert("insert into companies (name, dbegin, dend) values ('".$value['name']."','".$value['dbegin']."','".$value['dend']."')");
        //$comp[] = $value;
    }
    return redirect("/"); //dd(json_encode($arr_faculty, JSON_UNESCAPED_UNICODE));
}

function insertProfiles()
{
    $group = getPortal(
        '3e927995-75ee-4c90-a9dc-b1c9e775e034',
        'mNNxbKiXS9',
        'allspec.info'
    );
    $profiles = [];
    foreach ($group["RecordSet"] as $grp => $value) {
        $prof = $group["RecordSet"][$grp]["direct_name"];
        $inst = $group["RecordSet"][$grp]["fac_name"];
        if ($prof == "") {
            $prof = "Нет названия";
        }
        if (!in_array([$prof, $inst], $profiles)) {
            array_push($profiles, [$prof, $inst]);
        }
    }
    // $prof = getProfilesFromAis($group);
    foreach ($profiles as $num => $value) {
        $id_faculty = DB::connection('mariadb')->select("SELECT id FROM faculty WHERE name = '" . $value[1] . "'")[0]->id;
        //print_r($value[0]." - ".$id_faculty);
        //print '<br>';
        //dd($value);
        //DB::connection('mariabd')->insert("insert into profiles (name, faculty_id) values ('" . $value[0] . "'," . $id_faculty . ")");
    }
    return redirect("/");
}

function getPortal($app, $skey, $module, $param_array = null)
{
    $portal =
        'https://int.istu.edu/extranet/worker/rp_view/integration/';
    $a = false;
    $i = 0;

    if (isset($param_array)) {
        $s = "";
        foreach ($param_array as $key => $value) {
            $s = $s . urlencode($key) . '=' . urlencode($value) . '&';
        }
        $module = $module . '?' . substr($s, 0, -1);
    };
    $path = $portal . $app . '/' . $skey . '/' . $module;
    #return $path;

    while ($a == false && $i < 4) {
        $a = file_get_contents($path);
        $i++;
        if ($a == false) {
            usleep(100000 + $i * 50000);
        }
    }
    $array = json_decode($a, true);
    return $array;
}


function getInstituteFromAis($group)
{
    $institute = array();
    foreach ($group["RecordSet"] as $grp => $value) {
        $inst = $group["RecordSet"][$grp]["fac_name"];
        if (!in_array($inst, $institute)) {
            array_push($institute, $inst);
        }
    }
    /*foreach($institute as $inst => $value){
            print($value);
            print '<br>';
    }*/
    return $institute;
}
