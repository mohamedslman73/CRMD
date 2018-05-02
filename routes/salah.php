<?php
Route::group(['prefix'=>'{lang}','middleware'=>'apiLocale'],function (){
  Route::post('attendance/getStudentAttendance', 'Api\Attendance\getStudentAttendance@getStudentAttendance');
  Route::post('grades/getSubjectGradesForStudent', 'Api\Grades\getSubjectGradesForStudent@getSubjectGradesForStudent');
  Route::post('subject/getAllSubjects', 'Api\Subject\getAllSubjects@getAllSubjects');
  Route::post('calendar/getAllEvents', 'Api\Calendar\getAllEvents@getAllEvents');

});


// 'api_token' = 123456
// http://192.168.1.17:5000/api/en/grades/getSubjectGradesForStudent
// 'api_token' = 123456, 'subject_id' = 1
// http://192.168.1.17:5000/api/en/attendance/getStudentAttendance
?>
