<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Stream;
use App\Models\Student;
use App\Models\StudentPractic;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReport extends Controller
{
    public static function get()
    {

        $user = Auth::user();
        $student = Student::where('mira_id', $user->mira_id)->get()->first();
        $group = Group::find($student->group_id);
        $stream = Stream::find($group->stream_id);
        $profile = Profile::find($stream->profile_id);
        $faculty = Faculty::find($profile->faculty_id);

        $student_practic = StudentPractic::where('student_id', $student->id)->get()->first();
        if ($student_practic) {
            $disabled = "disabled";
            $teacher = 'WHERE id = ' . $student['teacher_id'];
            if (!$student_practic['company_id']) {
                $checked = "checked";
            } else {
                $displayNone = 'style="display: none;"';
            }
        } else {
            $student_practic = [];
            $disabled = "";
            $checked = "";
            $displayNone = "";
            $companies = Company::all();
            $teachers = Teachers::where('fac_id', $faculty->id)->get();
        }


        return view('student.student_report', [
            'disabled' => $disabled,
            'checked' => $checked,
            'displayNone' => $displayNone,
            'teachers' => $teachers,
            'companies' => $companies,
            'student_practic' => $student_practic
        ]);
    }

    public static function post()
    {
    }
}

// @php
//         $UserController = new app\Http\Controllers\UserController();
//     @endphp
//     @php
//         $disabled = true;
//     @endphp
//     @php
//         if (isset($_GET['download'])) {
//             $controllerPrikazy->Download_Templace($_GET['download']);
//         }
//         if (isset($_GET['done'])) {
//             DB::table('templates')
//                 ->where('id', $_GET['done'])
//                 ->update(['decanat_check' => 1, 'comment' => '']);
//         }
//         if (isset($_GET['noShow'])) {
//             DB::table('templates')
//                 ->where('id', $_GET['noShow'])
//                 ->update(['decanat_check' => 0, 'comment' => '']);
//         }
//         if (isset($_GET['remake'])) {
//             DB::table('templates')
//                 ->where('id', $_GET['remake'])
//                 ->update(['decanat_check' => 2, 'comment' => $_GET['comment']]);
//         }
//     @endphp

// <?
//                         /*echo'<select class="form-select zxc" id="teacher" required name="teacher_id" '. $disabled .'>' ;
?>
// <?php
    //                         /*
    // 						if($disabled == "disabled"){
    // 							$result=$connect->query('SELECT * FROM Practices.teachers WHERE ID = '.$student_request['teacher_id'].';' )->Fetch();
    // 							echo("<option value=".$result["id"].">".$result["fio"]."</option>" );
    // 						}
    // 						else{
    // 							echo('<option value="" disabled selected>Выбрать</option>');
    // 							$resultset=$connect->query("SELECT * FROM Practices.teachers;");
    // 							foreach($resultset as $result){
    // 								if ($result["work_load"]>0){
    // 								  echo("<option value=".$result["id"].">".$result["fio"]." (свободных мест: " . $result["work_load"] . ")</option>" );
    // 								}
    // 							} 
    // 						}
    // 					echo '</select>';

    //                         */
    //                         
    ?>


<?php
/*
			echo '<select class="form-select zxc" id="company" name="company_id" onchange="get_options()" required ' . $disabled . ' ' . $displayNoneCompany . '>';
			if ($disabled == "disabled" && $checked == "") {
				$result = $connect->query('SELECT * FROM Practices.companies WHERE ID = ' . $student_request['company_id'] . ';')->Fetch();
				echo("<option value=" . $result["id"] . ">" . $result["name"] . "</option>");
			} else {
				echo('<option value="" disabled selected>Выбрать</option>');
				echo('<option value="custom">Своя компания</option>');
				$resultset = $connect->query("SELECT * FROM Practices.companies;");
				foreach ($resultset as $result) {
					echo("<option value=" . $result["id"] . ">" . $result["name"] . "</option>");
				}
			}
			echo '</select>';
			echo '<div class="row">
					<div class="col-10">
						<label ' . $displayNoneDownload .'>Свой договор</label>
					</div>
					<div class="col-2 d-flex align-item-center">
						<input type="checkbox" name="cbMyCompany" id="cbMyCompany" ' . $checked . ' ' . $disabled . ' onchange="change_company_format()" >
					</div>
				</div>';
			if ($disabled != "disabled") {
				echo '<input type="file" required name="company_file" class="company_file" id="company_file">';
			} else {
				echo '<button class="btn btn-success" name="download" >Скачать договор</button>';
			}
            */
?>


<?php
/*
    echo '<select class="form-select zxc" id="theme" required name="theme" onchange="theme_check()" ' . $disabled . '></select>';
	echo '<input type="text" class="form-control zxc" style="margin-left: 0" required value="' . $student_request['theme'] . '" id="theme_field" name="theme_field" ' . $disabled . '>';
    */
?>


<?php
/*if ($connect->query("SELECT * FROM Practices.student_practic WHERE student_id ='" . $student_id . "';")->Fetch()) {
        echo '<button type="submit" class="btn btn-primary btn-lg" name="cancel">Отменить заявку</button>';
    } else {
        echo '<button type="submit" class="btn btn-primary btn-lg" name="send">Отправить</button>';
    }*/
?>


<?php
if ($student_request && $student_request['company_path']) {
    $status_message = '';
    switch ($student_request['status']) {
        case 0:
            $status_message = 'Ждите уведомление о принятии руководителем заявки на практику!';
            $status_color = 'primary';
            break;
        case 1:
            $status_message = 'Руководитель принял вашу заявку!';
            $status_color = 'success';
            break;
        case 2:
            $status_message = 'Преподаватель отклонил вашу заявку, для получения большей информации свяжитесь с ним.';
            $status_color = 'danger';
            break;
    }

    if ($status_message) {
        echo '<div class="alert alert-' . $status_color . ' mt-2">' . $status_message . '</div>';
    }
}
?>