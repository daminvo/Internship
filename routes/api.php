<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;


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
Route::get('user', 'Auth\UserController@current');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');


    Route::post('user/avatar', 'Auth\UserController@uploadAvatar');
    Route::delete('user/avatar', 'Auth\UserController@deleteAvatar');
    Route::post('user/cv', 'Auth\UserController@uploadCV');
    Route::delete('user/cv', 'Auth\UserController@deleteCV');

    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::post('user/saveprofile/1', 'Auth\UserController@saveProfile1');
    Route::post('user/saveprofile/2', 'Auth\UserController@saveProfile2');

    Route::post('project/{project:project_url}/apply/individual', 'Project\ApplyController@applyAsIndividual');

    Route::post('project/{project:project_url}/wishlist', 'Project\ProjectStudentController@addToWishlist');

    Route::post('project/{project:project_url}/save', 'Project\ProjectLecturerController@updateProject');
    Route::post('project/post', 'Project\ProjectLecturerController@postProject');
    Route::post('project/thumbnail', 'InternshipOfferController@uploadTempThumbnail');
    Route::delete('project/thumbnail', 'InternshipOfferController@deleteTempThumbnail');
    Route::post('project/{project:project_url}/thumbnail', 'Project\ProjectLecturerController@uploadThumbnail');
    Route::delete('project/{project:project_url}/thumbnail', 'Project\ProjectLecturerController@deleteThumbnail');
    Route::post('user/{user:tagname}/invite/project', 'Project\ProjectLecturerController@inviteToProject');

    Route::get('project/{project:project_url}/review', 'ProjectBox\ReviewController@show');
    Route::post('project/{project:project_url}/review', 'ProjectBox\ReviewController@postReview');

    Route::get('inbox', 'Inbox\InboxController@index');
    Route::post('inbox/invitation/team', 'Inbox\InboxStudentController@acceptTeamInvitation');
    Route::post('inbox/invitation/project', 'Inbox\InboxStudentController@acceptProjectInvitation');

    Route::get('projectbox', 'ProjectBox\ProjectBoxController@index');
    Route::post('projectbox/confirmation', 'ProjectBox\ProjectBoxStudentController@confirmProject');

    Route::post('projectbox/start', 'ProjectBox\ProjectBoxLecturerController@startProject');
    Route::post('projectbox/cancelProjectInvitation', 'ProjectBox\ProjectBoxLecturerController@cancelProjectInvitation');
    Route::post('projectbox/{project:project_url}/publish', 'ProjectBox\ProjectBoxLecturerController@publishProject');
    Route::post('projectbox/{project:project_url}/cancel', 'ProjectBox\ProjectBoxLecturerController@cancelProject');
    Route::post('projectbox/{project:project_url}/terminate', 'ProjectBox\ProjectBoxLecturerController@terminateProject');
    Route::post('projectbox/{project:project_url}/endapplication', 'ProjectBox\ProjectBoxLecturerController@endApplication');

    Route::get('project/{project:project_url}/shortlist', 'ProjectBox\ShortlistController@index');
    Route::post('project/{project:project_url}/shortlist', 'ProjectBox\ShortlistController@proceedShortlist');

    Route::post('user/{user:tagname}/message', 'MessageController@index');
    Route::post('user/{user:tagname}/message/send', 'MessageController@sendMessage');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');
});

Route::group([], function () {
    Route::get('home', 'HomeController@index');


    Route::get('projects', 'Project\ProjectController@explore');
    Route::get('projects/search/', 'Project\ProjectController@search');
    Route::get('project/{project:project_url}', 'Project\ProjectController@show');
    Route::get('project/{project:project_url}/similar', 'Project\ProjectController@similarProjects');

});

Route::get('user/{user:id}', 'ProfileController@getUser');


Route::post('newRequest', 'StudentController@createRequest');

//select options
Route::get('universities', 'UniversityController@index');
Route::get('faculties', 'FacultyController@index');
Route::get('departments', 'DepartmentController@index');
Route::get('companies', 'CompanyController@index');
Route::get('managers', 'InternshipManagerController@index');

//intern fcts

Route::get('getPendingRequests/{id}', 'InternController@getPendingRequests');
Route::Post('getOngoinginternships', 'InternController@getOngoinginternships');
Route::get('getFinishedinternships/{id}', 'InternController@getFinishedinternships');
Route::get('getAcceptedinternships/{id}', 'InternController@getAcceptedinternships');
Route::Post('deleteRequest', 'InternController@deleteRequest');
Route::Post('studentSubmition', 'InternController@studentSubmition');
Route::Post('studentRefuse', 'InternController@studentRefuse');






//offers
Route::Post('applyOffer', 'StudentController@applyOffer');
Route::Post('getOffre', 'StudentController@getOffre');
Route::Get('getAllOffres', 'StudentController@getAllOffres');
Route::get('/search//', 'InternshipOfferController@search');

//favorites
Route::post('{offer:id}/favorite', 'FavoriteController@addToFavorite');
//header fcts
Route::post('showRequests', 'DepartmentHeaderController@showRequests');
Route::post('acceptRequest', 'DepartmentHeaderController@acceptRequest');
Route::post('refuseRequest', 'DepartmentHeaderController@refuseRequest');
Route::post('getOngoingInternsNumber', 'DepartmentHeaderController@getOngoingInternsNumber');
Route::post('getAllStudentsNumber', 'DepartmentHeaderController@getAllStudentsNumber');
Route::post('getOngoingInterns', 'DepartmentHeaderController@getOngoingInterns');
Route::post('getIntern', 'DepartmentHeaderController@getIntern');

// manager fct
Route::get('generatePDF/intern:id', 'PDFController@generatePDF');
Route::post('refuseHeaderRequest', 'ManagerController@refuseRequest');
Route::post('acceptHeaderRequest', 'ManagerController@acceptRequest');
Route::post('getInternshipIterns', 'ManagerController@getInternshipIterns');
Route::post('createOffer', 'ManagerController@createOffer');
Route::post('evaluateIntern', 'ManagerController@evaluateIntern');
Route::post('internPresence', 'ManagerController@internPresence');
Route::post('showManagerRequests', 'ManagerController@showManagerRequests');













