<?php
/**
Routes that created by Amir
 */
Route::group(['prefix'=>'homework'],function (){
    Route::get('getAllHomework','Api\Homework\GetAllHomework@getAllHomeworkForSubject');
    Route::post('uploadHomeworkFile','Api\Homework\GetAllHomework@UploadHomeworkFile');
});

Route::group(['prefix'=>'behavior'],function (){
    //behavior for subject to all students
    Route::post('createBehavior','Api\Behavior\CreateBehaviorForStudent@createSubjectBehavior');
    Route::post('updateBehavior','Api\Behavior\UpdateBehaviorForSubject@updateSubjectBehavior');
    Route::post('deleteBehavior','Api\Behavior\DeleteBehaviorForSubject@deleteSubjectBehavior');
    //behavior for an student
    Route::post('addStudentDegree','Api\Behavior\AddStudentBehavior@addStudentDegree');
    Route::get('getStudentBehavior','Api\Behavior\GetStudentBehaviors@getStudentBehaviors');
});