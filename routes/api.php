<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
include('salah.php');
Route::group(['prefix'=>'{lang}','middleware'=>'apiLocale'],function (){

    Route::get('regions',"Api\RegionsController@getRegions");

    Route::group(['middleware'=>'apiLocale'],function (){
    include('amir.php');
        // This for Creating School
        Route::group(['prefix'=>'schools/create'],function (){
            Route::post('create',"Api\School\CreateSchoolsController@create");
            Route::get('educationtypes',"Api\School\CreateSchoolsController@getEducationTypes");
      /*      Route::post('step2',"Api\CreateSchoolsController@step2");
            Route::post('step3',"Api\CreateSchoolsController@step3");
            Route::post('step4',"Api\CreateSchoolsController@step4");*/
            Route::post('step5',"Api\School\CreateSchoolsController@step5");
            Route::post('getgrades',"Api\School\CreateSchoolsController@getGrades");

        });
        Route::group(['prefix'=>'school'],function (){
            Route::post('EditSchool','Api\School\EditSchool@EditSchool');
            Route::post('DeleteSchool','Api\School\DeleteSchool@DeleteSchool');
            Route::get('TeacherList','Api\School\TeacherList@TeacherList');
            Route::post('StudentList','Api\School\StudentList@StudentList');
            Route::post('editstudent','Api\Admin\editstudent@editstudent');
            Route::post('editteacher','Api\Admin\editteacher@editteacher');
        });
        // This Routes for School admin
        Route::group(['prefix'=>'admin/grades'],function(){
            Route::get('student',"Api\Student\StudentController@getStudent");
            Route::get('any',"Api\Student\StudentController@any");
            Route::get('division',"Api\Division\getDivisions@getDivisions");
            Route::post('createcalendar',"Api\Calendar\CalendarController@createCalender");
            Route::post('studentclass','Api\Student\StudentController@getstudentclass');
            Route::get('test','Api\Grades\GradesController@getGradeClassesSubjects');
        });

        // This Routes for Homework
            Route::group(['prefix'=>'homework/create'],function (){
          Route::post('createhomework','Api\Homework\HomeWorksController@createHomeWork');
          Route::get('gethomework','Api\Homework\HomeWorksController@getHomeWorks');
          Route::get('gethomework','Api\Homework\HomeWorksController@getHomeWorks');
          Route::post('EditHomework','Api\Homework\EditHomework@EditHomework');
          Route::post('DeleteHomework','Api\Homework\DeleteHomework@DeleteHomework');
        });
        Route::group(['prefix'=>'homework'],function (){
            Route::post('TeacherHomework','Api\Teacher\TeacherHomwork@TeacherHomwork');
        });

   /*     Route::group(['prefix'=>'gardes'],function (){
            Route::post('createGrades','Api\GradesController@createGrades');
            Route::post('edit','Api\GradesController@editGrades');
            Route::get('edit','Api\GradesController@editGrades');
            Route::post('delete','Api\GradesController@deleteGrade');
        });*/

        // Student Grades routes this should be in the teacher Routes
        Route::group(['prefix'=>'student/grades'],function (){
            Route::post('create','Api\Student\StudentGradesController@createStudentGrades');
            Route::post('delete','Api\Student\StudentGradesController@Delete');
            Route::post('edit','Api\Student\StudentGradesController@edit');
            Route::get('get','Api\Student\StudentGradesController@getGrades');
        });

        // User register and login routes
       Route::group(['prefix'=>'users'],function (){
          Route::post('register','Api\UserController@createUser');
          Route::post('login',"Api\UserController@login");
          Route::post('logout',"Api\UserController@logout");
          });
        Route::group(['prefix'=>'division'],function (){
            Route::post('create','Api\Division\CreateDivision@CreateDivivsion');
            Route::post('EditDivision','Api\Division\EditDivision@EditDivision');
            Route::post('DeleteDivision','Api\Division\DeleteDivision@DeleteDivision');
        });

        Route::group(['prefix'=>'getschools'],function (){
            Route::get('getSchools', 'Api\School\GetSchoolsController@getSchools');
            Route::post('singleSchool', 'Api\School\GetSchoolsController@singleSchool');
        });
        Route::group(['prefix'=>'subject'],function (){

            Route::post('createsubject','Api\Subject\CreateSubject@CreateSubject');

            Route::get('getsubject','Api\Subject\getTeacherSubject@getsubject');
            Route::post('DeleteSubject','Api\Subject\DeleteSubject@DeleteSubject');
            Route::post('EditSubject','Api\Subject\EditSubject@EditSubject');
        });

        Route::group(['prefix'=>'attendance'],function (){
            Route::post('createattendance','Api\Attendance\CreateAttendance@CreateAttendance');
            Route::post('editattendance','Api\Attendance\EditAttendance@EditAttendance');
            Route::post('delete','Api\Attendance\DeleteAttendance@DeleteAttendance');
            Route::post('getattendance','Api\Attendance\getAttendance@getAttendance');
        });

        Route::group(['prefix'=>'school/type'],function (){
            Route::post('types','Api\School\SchoolEducationType@SchoolEducationType');

        });
        Route::group(['prefix'=>'material'],function (){
            Route::post('creatematerial','Api\Material\CreateMaterial@CreateMaterial');
        });
        Route::group(['prefix'=>'school'],function (){
            Route::get('search','Api\School\GetSchoolsController@Search');
        });
        Route::group(['prefix'=>'classes'],function (){
            Route::get('class','Api\Classes\TeacherClasses@TeacherClasses');
            Route::post('create','Api\Classes\CreateClasses@CreateClasses');
        });
        Route::group(['prefix'=>'student'],function (){
            Route::post('profile','Api\Student\StudentProfile@StudentProfile');
            Route::post('changepassword','Api\Student\ChangePassword@ChangePassword');
            Route::post('ForgetPassword','Api\Student\ForgetPassword@ForgetPassword');
            Route::post('EditProfile','Api\Student\EditProfile@EditProfile');
            Route::get('SearchStudentName','Api\Student\SearchStudentName@SearchStudentName');
            Route::post('getStudentGradeSubjectClassAndSubjectgrades','Api\Student\getStudentGradeSubjectClassAndSubjectgrades@getStudentGradeSubjectClassAndSubjectgrades');
            Route::post('studentBehavior','Api\Behavior\studentBehavior@studentBehavior');
        });
            Route::group(['prefix'=>'schedule'],function (){
            Route::post('create','Api\Schedule\CreateSchedule@CreateSchedule');
            Route::get('divisionInfo','Api\Schedule\getDivisionInfoOnCreateSchedule@getDivisionInfoOnCreateSchedule');
            Route::get('class','Api\Schedule\getClassesOnCreateSchedule@getClassesOnCreateSchedule');
            Route::get('subject','Api\Schedule\getSubjectsOnCreateSchedule@getSubjectsOnCreateSchedule');
            Route::post('getStudentSchedule','Api\Schedule\getStudentSchedule@getStudentSchedule');
            Route::post('EditSchedule','Api\Schedule\EditSchedule@EditSchedule');
            Route::post('DeleteSchedule','Api\Schedule\DeleteSchedule@DeleteSchedule');
        });
        Route::group(['prefix'=>'material'],function (){
            Route::post('createMaterial','Api\Material\CreateMaterialController@createMaterialSubject');
            Route::post('createMaterialQuestion','Api\Material\AddMaterialQuestions@addMaterialQuestion');
            Route::get('getMaterialSubject','Api\Material\GetMaterialForSubject@getMaterialSubject');
            Route::post('EditMaterial','Api\Material\EditMaterial@EditMaterial');
            Route::post('DeleteMaterial','Api\Material\DeleteMaterial@DeleteMaterial');
        });
        Route::group(['prefix'=>'teacher'],function (){
            Route::post('TeacherSubjectClass','Api\Teacher\TeacherSubjectClass@TeacherSubjectClass');
            Route::post('TeacherStudentOnClass','Api\Teacher\TeacherStudentOnClass@TeacherStudentOnClass');
            Route::post('TeacherStudentGrades','Api\Teacher\TeacherStudentGrades@TeacherStudentGrades');
            Route::post('TeacherStudentEditGrade','Api\Teacher\TeacherStudentEditGrade@TeacherStudentEditGrade');
            Route::post('TeacherProfile','Api\Teacher\TeacherProfile@TeacherProfile');
            Route::post('getTeacherGradeSubjectClassAndSubjectgrades','Api\Teacher\getTeacherGradeSubjectClassAndSubjectgrades@getTeacherGradeSubjectClassAndSubjectgrades');
        });
        Route::group(['prefix'=>'grades'],function (){
            Route::post('CreateGrades','Api\Grades\CreateGrades@CreateGrades');
            Route::post('EditGrade','Api\Grades\EditGrade@EditGrade');
            Route::post('DeleteGrade','Api\Grades\DeleteGrade@DeleteGrade');
        });
        Route::group(['prefix'=>'messages'],function (){
            Route::post('getmessagesNotification','Api\Messages\CreateMessage@getMessagesNotification');//get all messages for this user where not read yet.
            Route::post('getMessages','Api\Messages\CreateMessage@getMessages');//get all messages for this user
            Route::post('getMessageById','Api\Messages\CreateMessage@getMessageById');//get message by id
            Route::post('getMessageSent','Api\Messages\CreateMessage@getMessageSent');//get message that has been sent
            Route::post('createMessage','Api\Messages\CreateMessage@createMessage');//create message
        });
        Route::group(['prefix'=>'grades'],function (){
            Route::get('gradeSubjects','Api\GradeInfo\GradeSubjects@GradeSubjects');
            Route::post('gradeTeachers','Api\GradeInfo\GradeTeachers@GradeTeachers');
            Route::post('AddSubjectToClass','Api\GradeInfo\AddSubjectToClass@AddSubjectToClass');
        });

        Route::group(['prefix'=>'classes'],function () {
            Route::post('classStudents', 'Api\ClassInfo\ClassStudents@ClassStudents');
            Route::post('AddStudentsToClass', 'Api\ClassInfo\AddStudentsToClass@AddStudentsToClass');
            Route::post('EditClass', 'Api\Classes\EditClass@EditClass');
            Route::post('DeleteClass', 'Api\Classes\DeleteClass@DeleteClass');
            Route::post('AddSubjectsToClass', 'Api\Classes\AddSubjectsToClass@AddSubjectsToClass');
        });

        Route::group(['prefix'=>'calendar'],function () {
            Route::post('EditCalendar','Api\Calendar\EditCalendar@EditCalendar');
        });
        Route::group(['prefix'=>'behavior'],function () {
            Route::post('getAllBehaviorForClassSubject','Api\Behavior\getAllBehaviorForClassSubject@getAllBehaviorForClassSubject');
        });
        Route::group(['prefix'=>'rooms'],function () {
            Route::post('createroom','Api\Messages\createroom@createroom');
            Route::get('UserToSend','Api\Messages\UserToSend@UserToSend');
            Route::post('getuserroom','Api\Messages\getuserroom@getuserroom');
            Route::post('roommessages','Api\Messages\roommessages@roomMessages');
        });
        Route::group(['prefix'=>'notification'],function () {
            Route::post('getNotification','Api\Notification\getNotification@getNotification');
            Route::post('getNotificationById','Api\Notification\getNotification@getNotificationById');
        });
    });
});

