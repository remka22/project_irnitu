<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class Insertcontroller extends Controller
{
    public static function get()
    {
        // $group = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034',
        //                                         'mNNxbKiXS9', 'allspec.info');
        // $arr_faculty = [];
        // $faculty = getInstituteFromAis($group);
        //         foreach($faculty as $num => $value){
        //                 //connection()->query("insert into faculty (name) values ('".$value."')");
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
            return insertStreams();
        }
        if ($request->input('insertStud')) {
            return insertStud();
        }
        if ($request->input('insertComp')) {
            return insertComp();
        }
        if ($request->input('insertTeach')) {
            return insertTeach();
        }
    }
}


function insertTeach()
{
    $teachers = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034', 'mNNxbKiXS9', 'worker.fac', array('id' => 46));
    foreach ($teachers as $num => $value) {
        $faculty = DB::connection('mariabd')->select("select id from faculty where name = ".$value['fac'])[0];
        DB::connection('mariabd')->insert("insert into teachers (fio, post, mira_id, fac_id) values ('".$value['name']."','".$value['post']."',".$value['id'].",'".$faculty."',)");
        //$arr_faculty[] = $value;
    }
    return redirect("/"); //dd(json_encode($arr_faculty, JSON_UNESCAPED_UNICODE));
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

function insertStreams()
{
    $group = getPortal(
        '3e927995-75ee-4c90-a9dc-b1c9e775e034',
        'mNNxbKiXS9',
        'allspec.info'
    );

    $groups = [];
    foreach ($group["RecordSet"] as $grp => $value) {
        //ВНИМАНИЕ КОСТЫЛЬ!
        $grp_yaer = preg_split("#\W*-#", $group["RecordSet"][$grp]["group_name"])[1];
        if ("20" . $grp_yaer > date("Y")) {
            $date = "19" . $grp_yaer;
        } else {
            $date = "20" . $grp_yaer;
        }
        //КОСТЫЛЬ КОНЧИЛСЯ
        if (intval($date) >= (intval(date("Y")) - 6))
            array_push($groups, [
                $group["RecordSet"][$grp]["group_name"],
                $group["RecordSet"][$grp]["spec_name"],
                $group["RecordSet"][$grp]["code"],
                $date,
                $group["RecordSet"][$grp]["fac_name"]
            ]);
    }

    $streams = $groups;
    foreach ($streams as $num => $value) {
        $id_faculty = DB::connection('mariadb')->select("SELECT id FROM faculty WHERE name = '" . $value[4] . "'")[0]->id;
        $id_profiles = DB::connection('mariadb')->select("SELECT id FROM profiles WHERE faculty_id = " . $id_faculty)[0]->id;

        //DB::connection('mariabd')->insert("insert into streams (name, full_name, code, year, profile_id) values ('" . $value[0] . "','" . $value[1] . "','" . $value[2] . "','" . $value[3] . "'," . $id_profiles . ")");
    }
    return redirect("/");
}
function insertStud()
{
    $stud = getPortal('3e927995-75ee-4c90-a9dc-b1c9e775e034', 'mNNxbKiXS9', 'stud.fac', array('id' => 46));
    //dd($stud);
    foreach ($stud["RecordSet"] as $name => $value) {
        $id = $value["id"];
        $name = $value["name"];
        $group = $value["grup"];
        //Парсер группы
        $name_group = explode('-', $group);
        //
        $id_stream = DB::connection('mariadb')->select("SELECT id FROM streams WHERE name = '" . $name_group[0] . "-" . $name_group[1] . "'")[0]->id;

        if (empty(DB::connection('mariadb')->select("select id from groups where stream_id = " . $id_stream . " and group_number = '" . $name_group[2] . "'"))) {
            DB::connection('mariadb')->insert("insert into groups (group_number, stream_id) values (" . $name_group[2] . ", " . $id_stream . ")");
        }
        $id_group = DB::connection('mariadb')->select("select id from groups where stream_id = " . $id_stream . " and group_number = '" . $name_group[2] . "'")[0]->id;

        DB::connection('mariadb')->insert("insert into students (fio, stud_id, category, group_id) values ('" . $name . "', " . $id . ", 'test', " . $id_group . ")");
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
