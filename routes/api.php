<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('logout', 'Auth\LoginController@logout');

  // Users
  Route::post('/user', 'UserController@addUser');
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
  Route::get('/user/{id}', function (Request $request, $id) {
    return \App\User::find($id);
  })->where('id', '[0-9]+');
  Route::get('user/search/{role?}', 'UserController@searchUsers');
  Route::get('user/teacher', 'UserController@getTeachers');
  Route::get('user/student/paginate', 'UserController@getStudentsPaginate');
  Route::get('user/student/by-teacher-id/{id}', 'UserController@getStudentsByTeacherID');
  Route::get('user/staff/paginate', 'UserController@getStaffsPaginate');
  Route::delete('user', 'UserController@destroy');

  // Export
  Route::get('export/excel/students/', 'ExportToExcel@students');
  //    Route::post('export/pdf/students', 'ExportToPdfController@students');
  Route::get('export/excel/function-state/calculation/{userId}', 'ExportToExcel@functionalStateCalculation');
  Route::get('export/excel/physical-fitness/calculation/{userId}', 'ExportToExcel@physicalFitnessCalculation');


  // Faculties
  Route::resource('faculty', 'FacultyController');

  // Health Group
  Route::resource('health-group', 'HealthGroupController');

  // Disease Group
  Route::resource('disease-group', 'DiseaseGroupController');

  // Profile
  Route::get('profile/student', 'Profile\ProfileStudentController@get');
  Route::patch('profile/student', 'Profile\ProfileStudentController@update');

  Route::get('profile/staff', 'Profile\ProfileStaffController@get');
  Route::patch('profile/staff', 'Profile\ProfileStaffController@update');

  Route::patch('change-auth-data', 'Profile\ProfileController@update');
  Route::patch('change-password', 'Profile\PasswordController@update');

  // Admin (Staff Page)
  Route::patch('set-user-role-admin/{id}', 'UserController@setUserRoleAdmin');

  // Measurement
  Route::get('measurements/semester/{semester}', 'MeasurementController@getMeasurementBySemester');
  Route::patch('measurements/semester/{semester}', 'MeasurementController@updateMeasurementBySemester');

  // FunctionalState
  Route::get('functional-state/initial-data/{semester}', 'FunctionalStateController@getInitialData');
  Route::patch('functional-state/calculation/{semester}', 'FunctionalStateController@updateСalculation');
  Route::get('functional-state/calculation/{userId}', 'FunctionalStateController@getСalculationFromTableByID');
  Route::get('functional-state/calculation/chart/points/{id}', 'FunctionalStateController@getСalculationPointsFromChartByID');
  Route::get('functional-state/chart/assessment/{id}', 'FunctionalStateController@getAssessmentFromChartByID');
  Route::get('functional-state/chart/common/assessment/{id}', 'FunctionalStateController@getCommonAssessmentFromChartByID');

  // PhysicalFitness
  Route::get('physical-fitness/initial-data/{semester}', 'PhysicalFitnessController@getInitialData');
  Route::patch('physical-fitness/calculation/{semester}', 'PhysicalFitnessController@updateСalculation');
  Route::get('physical-fitness/calculation/{userId}', 'PhysicalFitnessController@getСalculationFromTableByID');
  Route::get('physical-fitness/calculation/chart/points/{id}', 'PhysicalFitnessController@getСalculationPointsFromChartByID');
  Route::get('physical-fitness/chart/assessment/{id}', 'PhysicalFitnessController@getAssessmentFromChartByID');

  // Messages
  Route::get('messages/{id}', 'MessageController@getMessageByID')->where('id', '[0-9]+');
  Route::get('messages/notifications', 'MessageController@getNotifications');
  Route::get('messages/inbox', 'MessageController@getInbox');
  Route::get('messages/starred', 'MessageController@getStarred');
  Route::patch('messages/starred/{id}', 'MessageController@toggleStarred');
  Route::get('messages/sent', 'MessageController@getSent');
  Route::post('messages/send', 'MessageController@sendMessage');
  Route::get('messages/trash', 'MessageController@getTrash');
  Route::patch('messages/trash/in', 'MessageController@inTrash');
  Route::patch('messages/trash/out', 'MessageController@outTrash');
  Route::delete('/messages', 'MessageController@delete');

  // Files
  Route::get('files', 'FileController@index');
  Route::post('files/add', 'FileController@store');
  Route::post('files/edit/{id}', 'FileController@edit');
  Route::delete('files/delete/{id}', 'FileController@destroy');

  // Share files
  Route::post('files/share', 'FileController@share');
  Route::get('files/share', 'FileController@getShareFiles');
  Route::get('files/share/{file_id}/users', 'FileController@getShareUsers');
  Route::delete('files/share/{file_id}/users/{user_id}', 'FileController@deleteShareUser');
  
});

Route::group(['middleware' => 'guest:api'], function () {
  Route::post('login', 'Auth\LoginController@login');
  Route::post('register', 'Auth\RegisterController@register');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset');

  Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
  Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
