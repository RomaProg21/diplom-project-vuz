<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fakultet;
use App\Models\Student;
use App\Models\Prepodavatel;
use App\Models\StudentGroup;
use App\Models\Predmet;
use App\Models\Ocenka;
use App\Models\Online;
use App\Models\SheduleExam;
use App\Models\Statement;
use App\Models\StatmentStudent;
use App\Models\Module;











use Illuminate\Support\Facades\Hash;
use Laravel\Ui\Presets\React;
use Termwind\Components\Raw;

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
    // $user = User::find(1);
    // $user->password = Hash::make('admin');
    // $user->save();
    return view('auth.login');
});

Route::get('/dashboard', function () {
    // $auth = Auth()->user()->id;
    
    // $users = DB::table('students')->where('id_users',$auth)->get();
    // dd($users);
    return redirect()->route('online');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/createAbonent', function () {
    $groups = DB::table('group_students')->get();
    $fakultets = DB::table('fakultet')->get();
    return view('verstka.createAbonent',['groups'=>$groups,'fakultets'=>$fakultets]);
})->middleware(['auth', 'verified'])->name('createAbonent');

Route::post('/createFunctionalAbonent',function(Request $request){
    $role = $request->get('role_user');
    $name = $request->get('name_user');
    $surname = $request->get('surname');
    $patronomic = $request->get('patronomic');
    $pasport = $request->get('pasport');
    $password = $request->get('password');
    $email = $request->get('email');
    $group = $request->get('groups_students');
    $fakultet = $request->get('fakultet_prepod');

    User::create([
        'name' => $name,
        'email' => $email,
        'surname' => $surname,
        'patronomic' => $patronomic,
        'pasport' => $pasport,
        'role_id' => $role,
        'password' => Hash::make($password)
    ]);
    $createUser = DB::table('users')->where('email',$email)->get();
   // dd($createUser);
    if($role == '2'){
        Student::create([
            'id_group' => $group,
            'id_users' => $createUser[0]->id
        ]);
    } else if($role == '3'){
        Prepodavatel::create([
            'fakultet_id' => $fakultet,
            'user_id' => $createUser[0]->id
        ]);
    }
    return redirect()->route('createAbonent');
})->middleware(['auth', 'verified'])->name('createFunctionalAbonent');

Route::get('/students',function(){
    $fakultets = DB::table('fakultet')->get();

    return view('verstka.students.students',['fakultets'=>$fakultets]);
})->middleware(['auth','verified'])->name('students');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//axios

Route::post('/getGroups',function(Request $request){
    $kurs = $request->get('kurs');
    $idFakultet = $request->get('idFakultet');

    if($kurs==null){
    $groups = DB::table('group_students')->where('id_fakultet',$idFakultet)->get();
    //dd($idFakultet);
    } else {
        $groups = DB::table('group_students')->where([
            ['id_fakultet',$idFakultet],
            ['kurs',$kurs]
        ])->get();
        
    }
    return response()->json(['groups'=>$groups]);  

});
Route::post('/getStudentsforStatements',function(Request $request){
    $idGroup = $request->get('idGroup'); 
    $predmetId = $request->get('predmet');
    $students = DB::table('students')->where('id_group',$idGroup)->get();
    $getModule = DB::table('module_predmets_group')->where('predmet_id',$predmetId)->get();
    $module1 = $getModule[0]->module;

    $ocenka = DB::table('ocenka')->where([
        ['group_id',$idGroup],
        ['predmet_id',$predmetId]
        ])->get()->values()->all();
    $users = [];
    foreach($students as $student){
        $user = DB::table('users')->where('id',$student->id_users)->get();
        $ocnStud = array_filter($ocenka,fn($ocen)=>$ocen->stud_id==$student->id);
        $SrBall = 0;
        foreach($ocnStud as $ocenk){
           $SrBall = $SrBall + $ocenk->ocenka;
        }
        $SrBall = ($SrBall / (int)$module1) * 0.6;
        $arr = array('user'=>$user,'student'=>$student,'srBall'=>$SrBall);
        
        array_push($users,$arr);
    }
   
    return response()->json(['students'=>$users,'group'=>$idGroup]);
});
Route::post('/getStudents',function(Request $request){
    $idGroup = $request->get('idGroup'); 
    $students = DB::table('students')->where('id_group',$idGroup)->get();
  //  $group = DB::table('group_students')->where('id',$idGroup)->get();
  //  dd($students);
    $users = [];
    foreach($students as $student){
        $user = DB::table('users')->where('id',$student->id_users)->get();
        $arr = array('user'=>$user,'student'=>$student);
        array_push($users,$arr);
    }
    return response()->json(['students'=>$users,'group'=>$idGroup]);
});

Route::post('/allGroup',function(Request $request){
    $allGroup = DB::table('group_students')->get();
    return response()->json(['allGroup'=>$allGroup]);
});

Route::get('/fakultets',function(Request $request){

    $fakultets = DB::table('fakultet')->get();

    return view('verstka.fakultets.fakultets',['fakultets'=>$fakultets]);
})->name('fakultets');

Route::post('/createFakultet', function(Request $request){
   $name = $request->get('fakultet_name');
   Fakultet::create([
    'name'=>$name
   ]);
   return redirect()->route('fakultets');

})->name('createFakultet');

Route::get('/groupsStudents',function(Request $request){
    $groups = DB::table('group_students')->get();
    $result = [];
    $fakultets = DB::table('fakultet')->get();
    foreach($groups as $group){
       $fakultet = DB::table('fakultet')->where('id',$group->id_fakultet)->get();
       $arr = array('group' => $group,'fakultet'=>$fakultet[0]);
       array_push($result,$arr);
    }

    return view('verstka.groupsStudents.groupsStudents',['result'=>$result,'fakultets'=>$fakultets]);
})->name('groupsStudents');

Route::get('/predmets',function(Request $request){
   $predmets = DB::table('predmet')->get();
   $prepodAll = DB::table('prepodavatel')->get();
   $prepodArrayAll = [];
   foreach($prepodAll as $prepod){
   $user1 = DB::table('users')->where('id',$prepod->user_id)->get();
   $arr1 = array('user'=>$user1[0],'prepod'=>$prepod);
   array_push($prepodArrayAll,$arr1);
   }
   $result = [];
   foreach($predmets as $predmet){
    $prepodId = $predmet->prepod_id;
    $prepodavatel = DB::table('prepodavatel')->where('id',$prepodId)->get();
    $user = DB::table('users')->where('id',$prepodavatel[0]->user_id)->get();
    $fakultet = DB::table('fakultet')->where('id',$prepodavatel[0]->fakultet_id)->get();
    $arr = array('predmet'=>$predmet,'prepodavatel'=>$prepodavatel[0],'user'=>$user[0],'fakultet'=>$fakultet[0]);

    array_push($result,$arr);
   }
//    dd($result,$prepodArrayAll);
   return view('verstka.predmets.predmets',['prepodArrayAll'=>$prepodArrayAll,'result'=>$result]);
})->name('predmets');

Route::post('/createGroup',function(Request $request){
    $name = $request->get('name_group');
    $fakultet_id = $request->get('fakultet_id');
    $kurs = $request->get('kurs');
    StudentGroup::create([
        'name'=>$name,
        'id_fakultet'=>$fakultet_id,
        'kurs'=>$kurs
    ]);
    return redirect()->route('groupsStudents');
})->name('createGroup');

Route::post('/allPredmets',function(){
    $predmets = DB::table('predmet')->get();
    return response()->json(['predmets'=>$predmets]);
})->name('allPredmets');

Route::post('/createPredmet',function(Request $request){
    $name_predmet = $request->get('name_predmet');
    $prepodavatelId = $request->get('prepodavatel');
    $module = $request->get('module');
    $clock = $request->get('clock');

  $predmet = Predmet::create([
        'prepod_id'=>$prepodavatelId,
        'name'=>$name_predmet,
        'clock'=>$clock
    ]);
   Module::create([
    'predmet_id'=>$predmet->id,
    'module'=>$module
   ]);

    return redirect()->route('predmets');

})->name('createPredmet');

Route::post('/updateDataStudent',function(Request $request){
    //dd($request);
    DB::table('users')->where('email',$request->get('email'))
    ->update([
        'name'=>$request->get('name'),
        'surname'=>$request->get('surname'),
        'patronomic'=>$request->get('patrnomic'),
        'email'=>$request->get('email'),
        'password'=>$request->get('password'),
        'pasport'=>$request->get('pasport')
]);
$id = DB::table('users')->where('email',$request->get('email'))->get();

$group = $request->get('group_student');
DB::table('students')->where('id_users',$id[0]->id)
->update([
    'id_group'=>$group
]);

    return redirect()->route('students');

})->name('updateDataStudent');
//---

Route::get('/scores',function(){
    
    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    
    if($userRole==1){
    $predmets = DB::table('predmet')->get();
    } elseif($userRole==3){
        $teacherId = DB::table('prepodavatel')->where('user_id',$userId)->get();
        $predmets = DB::table('predmet')->where('prepod_id',$teacherId[0]->id)->get();
    } else {
        $predmets = [];
    }
    
    $groups = DB::table('group_students')->get();
    $result = [];
    $fakultets = DB::table('fakultet')->get();
    foreach($groups as $group){
       $fakultet = DB::table('fakultet')->where('id',$group->id_fakultet)->get();
       $arr = array('group' => $group,'fakultet'=>$fakultet[0]);
       array_push($result,$arr);
    }

    return view('verstka.ocenka.ocenka',['predmets'=>$predmets,'result'=>$result,'fakultets'=>$fakultets]);
})->name('scores');

Route::post('/getModulesPredmets',function(Request $request){
      $predmet = $request->get('predmet');
      $result = DB::table('module_predmets_group')->where('predmet_id',$predmet)->get();

      return response()->json(['result'=>$result]);
});

Route::post('/getOcenka',function(Request $request){
    $predmet = $request->get('predmet');
    $module = $request->get('module');
    $group = $request->get('group');
    $result = DB::table('ocenka')->where([
        ['predmet_id',$predmet['id']],
        ['group_id',$group['id']],
        ['module',$module]
    ])->get();

    return response()->json(['result'=>$result]);
});

Route::post('/addOcenkaStudent',function(Request $request){
   $student = $request->get('student');
   $date = date("Y-m-d");
   $ball = $request->get('ball');
   $predmet = $request->get('predmet');
   $module = $request->get('module');
   Ocenka::updateOrCreate(
    ['stud_id'=>$student['student']['id'],'predmet_id'=>$predmet['id'],'group_id'=>$student['student']['id_group'],'module'=>$module],
    ['ocenka'=>$ball,'date'=>$date]
   );
   return response()->json(['result'=>'Успешно']);
});

Route::get('/online',function(Request $request){
    $date = date("Y-m-d");
    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    if($userRole==1){
    $allPredmets = DB::table('predmet')->get();
    } elseif($userRole==3){
        $teacherId = DB::table('prepodavatel')->where('user_id',$userId)->get();
        $allPredmets = DB::table('predmet')->where('prepod_id',$teacherId[0]->id)->get();
    } else {
        $allPredmets = [];
    }
    $groups = DB::table('group_students')->get();
    $online = DB::table('online')->where('date','>=',$date)->get();
    $result = [];
    foreach($online as $o){
        $predmetId = $o->predmet_id;
        $groupId = $o->group_id;
        $predmet = DB::table('predmet')->where('id',$predmetId)->get();
        $group = DB::table('group_students')->where('id',$groupId)->get();
        $arr = array('online'=>$o,'predmet'=>$predmet[0],'group'=>$group[0]);
        array_push($result,$arr);
    }
    return view('verstka.online.online',['onlines'=>$result,'groups'=>$groups,'allPredmets'=>$allPredmets]);
})->name('online');

Route::post('/createNewOnline',function(Request $request){
    $group_name = $request->get('group_name');  
    $name_predmet = $request->get('name_predmet');
    $link = $request->get('link');
    $date_start = $request->get('date_start');

    Online::create([
        'predmet_id'=>$name_predmet,
        'group_id'=>$group_name,
        'link'=>$link,
        'date'=>$date_start
    ]);
    return redirect()->route('online');

})->name('createNewOnline');

Route::get('/sheduleExam',function(){
    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    if($userRole==1){
        $shedules = DB::table('schedule_exam')->get();
    } elseif($userRole==3){
        $teacherId = DB::table('prepodavatel')->where('user_id',$userId)->get();
        $predmetId = DB::table('predmet')->where('prepod_id',$teacherId[0]->id)->get();

        $shedules = DB::table('schedule_exam')->where('predmet_id',$predmetId[0]->id)->get();

    } else{
        $groupId = DB::table('students')->where('id_users',$userId)->get();
        $shedules = DB::table('schedule_exam')->where('group_id',$groupId[0]->id)->get(); 
    }
    $allPredmet = DB::table('predmet')->get();
    $groupAll = DB::table('group_students')->get();
    $result = [];
    foreach($shedules as $shedule){
        $shedule->date = substr($shedule->date,0,-3);
        $groupId = $shedule->group_id;
        $predmetId = $shedule->predmet_id;
        $group = DB::table('group_students')->where('id',$groupId)->get();
        $predmet = DB::table('predmet')->where('id',$predmetId)->get();
        $arr = array('shedule'=>$shedule,'group'=>$group[0],'predmet'=>$predmet[0]);
        array_push($result,$arr);         
    }
    return view('verstka.shedule_exam.shedule_exam',['groupAll'=>$groupAll,'allPredmet'=>$allPredmet,'result'=>$result]);
})->name('sheduleExam');

Route::post('/createSheduleExam',function(Request $request){
    $group = $request->get('group');
    $predmet = $request->get('predmet');
    $date = $request->get('date');
    $kabinet = $request->get('kabinet');

    SheduleExam::create([
        'group_id'=>$group,
        'predmet_id'=>$predmet,
        'date'=>$date,
        'kabinet'=>$kabinet
    ]);
    return redirect()->route('sheduleExam');
})->name('createSheduleExam');

Route::get('/statments',function(){
    $fakultets = DB::table('fakultet')->get();
    $vidkontrolya = DB::table('vid_kontrolya')->get();
    return view('verstka.statments.statments',['fakultets'=>$fakultets,'vidkontrolya'=>$vidkontrolya]);
})->name('statments');

Route::post('/getTeachers',function(Request $request){
    $fakultet = $request->get('fakultet');
    $teachers = DB::table('prepodavatel')->where('fakultet_id',$fakultet)->get();
    $result = [];
    foreach($teachers as $teacher){
       $user = DB::table('users')->where('id',$teacher->user_id)->get();
       $arr = array('user'=>$user[0],'teacher'=>$teacher);
       array_push($result,$arr);
    }
    return response()->json(['teachers'=>$result]);
});
Route::post('/getPredmets',function(Request $request){
    $teacherId = $request->get('teacher');
    $predmets = DB::table('predmet')->where('prepod_id',$teacherId)->get();
    return response()->json(['predmets'=>$predmets]);
});

Route::post('/saveStatments',function(Request $request){
    $students = $request->get('students');
    $teacher = $request->get('teacher');
    $predmet = $request->get('predmet');
    $group = $request->get('group');
    $vidkontr = $request->get('vidkontr');
    $kurs = DB::table('group_students')->where('id',$group)->get();
    $date = date("Y-m-d");
    $statement = Statement::create([
        'vidkontr_id'=>$vidkontr,
        'predmet_id'=>$predmet,
        'prepod_id'=>$teacher,
        'date'=>$date,
        'nomdok'=>$predmet . $vidkontr . $teacher . $date . $group,
        'id_groupstud'=>$group,
        'kurs'=>$kurs[0]->kurs,
    ]);
    $id_statement = $statement->id;
    foreach($students as $student){
        StatmentStudent::create([
            'id_statement'=>$id_statement,
            'id_stud'=>$student['student']['id'],
            'ocenka'=>$student['finally'],
            'ocenka_exam'=>$student['exam']
        ]);
    }
    return response()->json(['status'=>'Ведомость успешно создана']);
});
Route::post('/searchStatement',function(Request $request){
    $students = $request->get('students');
    $teacher = $request->get('teacher');
    $predmet = $request->get('predmet');
    $group = $request->get('group');
    $vidkontr = $request->get('vidkontr');

    $statementSearch = DB::table('statement')->where([
        ['prepod_id',$teacher],
        ['predmet_id',$predmet],
        ['id_groupstud',$group],
        ['vidkontr_id',$vidkontr]
    ])->get();
    // dd($statementSearch);
    $students = DB::table('statement_student')->where('id_statement',$statementSearch[0]->id)->get();
    $predmet1 = DB::table('predmet')->where('id',$predmet)->get();
    $getModule = DB::table('module_predmets_group')->where('predmet_id',$predmet)->get();
    $module1 = $getModule[0]->module;
    $ocenka = DB::table('ocenka')->where([
        ['group_id',$group],
        ['predmet_id',$predmet]
        ])->get()->values()->all();
    
    $result = [];
    foreach($students as $student){
        
       $studentTable = DB::table('students')->where('id',$student->id_stud)->get();
       $user = DB::table('users')->where('id',$studentTable[0]->id_users)->get();
       $ocnStud = array_filter($ocenka,fn($ocen)=>$ocen->stud_id==$studentTable[0]->id);
       $SrBall = 0;
       foreach($ocnStud as $ocenk){
          $SrBall = $SrBall + $ocenk->ocenka;
       }
       $SrBall = ($SrBall / (int)$module1) * 0.6;
       $arr = array('dataStatement'=>$student,'student'=>$studentTable[0],'user'=>$user,'srBall'=>$SrBall); 
       array_push($result,$arr);
    }   
    return response()->json(['statement'=>$statementSearch,'result'=>$result,'predmet'=>$predmet1[0]]);
});
Route::get('/progress',function(){
    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    $student = DB::table('students')->where('id_users',$userId)->get();
    $group = DB::table('group_students')->where('id',$student[0]->id_group)->get();
    $fakultet_corrent = $group[0]->id_fakultet;

    $predmets = DB::table('predmet')->get();
    $result = [];
    foreach($predmets as $predmet){
        $teacher = DB::table('prepodavatel')->where('id',$predmet->prepod_id)->get();
        $fakultet = $teacher[0]->fakultet_id;
        if($fakultet_corrent==$fakultet){
            $arr = array('predmet'=>$predmet,'fakultet'=>$fakultet);
            array_push($result,$arr);
        }
    }
    return view('verstka.progress.progress',['result'=>$result]);
})->name('progress');
Route::post('/getModuleOcenkaForStudent',function(Request $request){
    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    $student = DB::table('students')->where('id_users',$userId)->get();

    $predmet = $request->get('predmet');
    $module = $request->get('module');
    $ocenka = DB::table('ocenka')->where([
        ['stud_id',$student[0]->id],
        ['predmet_id',$predmet['id']],
        ['module',$module]
    ])->get();
    return response()->json(['ocenka'=>$ocenka]);
});
Route::get('/recordBook',function(){

    $userRole = Auth::user()->role_id;
    $userId = Auth::user()->id;
    $student = DB::table('students')->where('id_users',$userId)->get();

    $statement = DB::table('statement')->where('id_groupstud',$student[0]->id_group)->get();
    $result = [];
    foreach($statement as $state){
       $state->date = substr($state->date,0,-8);
       $vidkontr = DB::table('vid_kontrolya')->where('id',$state->vidkontr_id)->get();
       $predmet = DB::table('predmet')->where('id',$state->predmet_id)->get();
       $teacher = DB::table('prepodavatel')->where('id',$state->prepod_id)->get();
       $userTeacher = DB::table('users')->where('id',$teacher[0]->user_id)->get();
       $ocenka = DB::table('statement_student')->where([
        'id_statement'=>$state->id,
        'id_stud'=>$student[0]->id
       ])->get();

       $arr = array('statement'=>$state,'vidkontr'=>$vidkontr[0],'ocenka'=>$ocenka[0],
       'predmet'=>$predmet[0],'teacher'=>$userTeacher[0]);
       array_push($result,$arr);
    }
    return view('verstka.recordBook.recordBook',['statement'=>$result]);
})->name('recordBook');
Route::post('/getStatementResult',function(Request $request){
    
    $userId = Auth::user()->id;
    $student = DB::table('students')->where('id_users',$userId)->get();

    $statementId = $request->get('statementId');
    $result = DB::table('statement_student')->where([
        ['id_statement',$statementId],
        ['id_stud',$student[0]->id]
    ])->get();
    return response()->json(['result'=>$result]);
});
Route::get('/info',function(){
    // function translit($st)
    // {
    //     $st = mb_strtolower($st, "utf-8");
    //     $st = str_replace([
    //         '?', '!', '.', ',', ':', ';', '*', '(', ')', '{', '}', '[', ']', '%', '#', '№', '@', '$', '^', '-', '+', '/', '\\', '=', '|', '"', '\'',
    //         'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'з', 'и', 'й', 'к',
    //         'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х',
    //         'ъ', 'ы', 'э', ' ', 'ж', 'ц', 'ч', 'ш', 'щ', 'ь', 'ю', 'я'
    //     ], [
    //         '_', '_', '.', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_',
    //         'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k',
    //         'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h',
    //         'j', 'i', 'e', '_', 'zh', 'ts', 'ch', 'sh', 'shch',
    //         '', 'yu', 'ya'
    //     ], $st);
    //     $st = preg_replace("/[^a-z0-9_.]/", "", $st);
    //     $st = trim($st, '_');

    //     $prev_st = '';
    //     do {
    //         $prev_st = $st;
    //         $st = preg_replace("/_[a-z0-9]_/", "_", $st);
    //     } while ($st != $prev_st);

    //     $st = preg_replace("/_{2,}/", "_", $st);
    //     return $st;
    // }
    $userId = Auth::user()->id;
    $user = DB::table('users')->where('id',$userId)->get();
   
    $email = Auth::user()->email;
    $roleId = Auth::user()->role_id;
    $pasport = Auth::user()->pasport;
    $qrcode = QrCode::size(200)->generate($userId .' '. $email .' '. $roleId .' '. $pasport);
 return view('verstka.info.info',['user'=>$user,'qrcode'=>$qrcode]);
})->name('info');
require __DIR__.'/auth.php';
