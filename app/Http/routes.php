<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeCtrl@index');
Route::post('/store', 'HomeCtrl@store');
Route::post('/subscribe', 'HomeCtrl@subscribe');
Route::get('/subjects/{center_id}', 'HomeCtrl@show_subjects');

//PARAMETERS
Route::post('param/checkProfile','Parameter@checkProfile');
Route::post('param/checkUsername','Parameter@checkUsername');
//..PARAMETERS

//LOGIN PROCESS
Route::post('login/validate','LoginCtrl@validateLogin');
Route::get('logout',function(){
    \Illuminate\Support\Facades\Session::flush();
    return redirect('/');
});
//..LOGIN PROCESS

//VALIDATE LOGIN
Route::get('validate',function(){

    $user = \Illuminate\Support\Facades\Session::get('access');
    if($user){
        if($user->level==='admin'){
            return redirect('admin/home');
        }else if($user->level==='center'){
            $center_id = \App\Center::where('user_id',$user->id)->first()->id;
            \Illuminate\Support\Facades\Session::put('center',$center_id);
            return redirect('center/home');
        }else if($user->level==='instructor'){
            return redirect('instructor/home');
        }else if($user->level==='reviewee'){
            return redirect('reviewee/home');
        }else{
            return redirect('/');
        }
    }else{
        return redirect('/');
    }

});
//...VALIDATE LOGIN

//LOCATION ROUTES
Route::get('location/muncity/{provCode}','LocationCtrl@muncity');
Route::get('location/barangay/{muncityCode}','LocationCtrl@barangay');
//...LOCATION ROUTES

//ADMIN PAGE
Route::get('admin/home', 'admin\HomeCtrl@index');

Route::get('admin/center', 'admin\CenterCtrl@index');
Route::get('admin/center/add', 'admin\CenterCtrl@add');
Route::post('admin/center/save','admin\CenterCtrl@save');
Route::get('admin/center/{id}','admin\CenterCtrl@edit');
Route::post('admin/center/update','admin\CenterCtrl@update');
Route::post('admin/center/delete','admin\CenterCtrl@delete');
Route::post('admin/center/accept', 'admin\CenterCtrl@accept');
Route::post('admin/center/ignore', 'admin\CenterCtrl@ignore');

Route::get('admin/announcement','admin\AnnouncementCtrl@index');
//..ADMIN PAGE

//CENTER PAGE
Route::get('center/home', 'center\HomeCtrl@index');

Route::get('center/instructor', 'center\InstructorCtrl@index');
Route::get('center/instructor/add', 'center\InstructorCtrl@add');
Route::post('center/instructor/save', 'center\InstructorCtrl@save');
Route::get('center/instructor/{id}', 'center\InstructorCtrl@edit');
Route::post('center/instructor/update', 'center\InstructorCtrl@update');
Route::post('center/instructor/delete', 'center\InstructorCtrl@delete');
Route::post('center/instructor/search', 'center\InstructorCtrl@search');

Route::resource('center/reviewee', 'center\RevieweeCtrl');
Route::post('center/reviewee/accept', 'center\RevieweeCtrl@accept');
Route::post('center/reviewee/ignore', 'center\RevieweeCtrl@ignore');
Route::post('center/reviewee/search', 'center\RevieweeCtrl@search');

Route::resource('center/class', 'center\ClassCtrl');
Route::get('center/class/enroll/{id}', 'center\ClassCtrl@enroll');
Route::post('center/class/enroll/{id}', 'center\ClassCtrl@enrollReviewee');
Route::post('center/class/remove/{id}', 'center\ClassCtrl@removeReviewee');

Route::get('center/announcement','center\AnnouncementCtrl@index');
//..CENTER PAGE

//INSTRUCTOR PAGE
Route::get('instructor/home','instructor\HomeCtrl@index');
Route::get('instructor/class','instructor\ClassCtrl@index');
Route::get('instructor/reviewee/{id}','instructor\ClassCtrl@reviewee');
Route::post('instructor/reviewee/search/{id}','instructor\ClassCtrl@searchReviewee');

Route::get('instructor/lesson/{id}/create','instructor\LessonCtrl@create');
Route::post('instructor/lesson/{id}/store','instructor\LessonCtrl@store');

Route::get('instructor/lesson/{id}/{lesson_id}','instructor\LessonCtrl@show');
Route::post('instructor/lesson/{lesson_id}','instructor\LessonCtrl@update');
Route::post('instructor/lesson/{id}/destroy','instructor\LessonCtrl@destroy');

Route::post('instructor/lesson/{id}/{lesson_id}/destroy','instructor\LessonCtrl@destroy');

Route::resource('view/file','FileCtrl');
Route::get('view/file/{file}','FileCtrl@show');
Route::get('destroy/file/{id}','FileCtrl@destroy');

Route::get('instructor/lesson/{id}','instructor\LessonCtrl@index');
Route::post('instructor/lesson/search/{id}','instructor\LessonCtrl@searchLesson');

Route::get('instructor/quiz/{lesson_id}','instructor\QuizCtrl@index');
Route::get('instructor/quiz/{lesson_id}/create','instructor\QuizCtrl@create');
Route::post('instructor/quiz/store','instructor\QuizCtrl@store');
Route::get('instructor/quiz/show/{quiz_id}','instructor\QuizCtrl@show');
Route::post('instructor/quiz/update/{quiz_id}','instructor\QuizCtrl@update');
Route::post('instructor/quiz/destroy','instructor\QuizCtrl@destroy');

Route::get('/instructor/question/{quiz_id}','instructor\QuestionCtrl@index');
Route::post('/instructor/question/{quiz_id}/store','instructor\QuestionCtrl@store');
Route::post('/instructor/question/{quiz_id}/bulk','instructor\QuestionCtrl@bulk');
Route::post('/instructor/question/{quiz_id}/update','instructor\QuestionCtrl@update');
Route::post('/instructor/question/{quiz_id}/destroy','instructor\QuestionCtrl@destroy');
Route::get('/instructor/question/{question_id}/show','instructor\QuestionCtrl@show');

Route::get('instructor/announcement','instructor\AnnouncementCtrl@index');
Route::get('instructor/announcement/add','instructor\AnnouncementCtrl@create');
Route::post('instructor/announcement/store','instructor\AnnouncementCtrl@store');
//...INSTRUCTOR PAGE

//REVIEWEE PAGE
Route::get('reviewee/home','reviewee\HomeCtrl@index');

Route::get('reviewee/class','reviewee\ClassCtrl@index');
Route::get('reviewee/class/{class_id}','reviewee\ClassCtrl@show');

Route::get('reviewee/lesson/{lesson_id}','reviewee\LessonCtrl@show');
Route::get('reviewee/lesson/review/{lesson_id}','reviewee\LessonCtrl@showReview');

Route::get('reviewee/lesson/finish/{lesson_id}','reviewee\LessonCtrl@finish');

Route::get('reviewee/quiz/{lesson_id}','reviewee\LessonCtrl@quiz');

Route::get('reviewee/quiz/take/{quiz_id}','reviewee\QuizCtrl@take_quiz');
Route::post('reviewee/quiz/take/{quiz_id}','reviewee\QuizCtrl@get_score');

Route::get('reviewee/quiz/practice/{quiz_id}','reviewee\QuizCtrl@practice_quiz');
Route::post('reviewee/quiz/practice/{quiz_id}','reviewee\QuizCtrl@practice_score');

Route::get('reviewee/quiz/review/{quiz_id}','reviewee\QuizCtrl@review_quiz');

Route::post('reviewee/quiz/store/time/','reviewee\QuizCtrl@timer');
Route::post('reviewee/quiz/store/answer/','reviewee\QuizCtrl@answer');

Route::get('reviewee/announcement','reviewee\AnnouncementCtrl@index');
Route::get('reviewee/announcement/seen/{id}','reviewee\AnnouncementCtrl@seen');
//..REVIEWEE PAGE

