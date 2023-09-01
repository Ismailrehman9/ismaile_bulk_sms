<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\SourceListController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('db:wipe');
 });

 Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:cache');
 });
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/voicepostback', 'Admin\RvmController@voicepostback')->name('voicepostback');
Route::POST('/voicepostback', 'Admin\RvmController@voicepostback')->name('voicepostback');
Route::get('admin/email/unsub/{id}','Admin\SendGridEmailController@unsubMail');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['as'=>'admin.','middleware'=>'auth','prefix'=>'admin'], function () {



    // user list
    Route::get('user-list/index','UserController@index')->name('user-list.index');
    Route::get('user/create','UserController@create')->name('user.create');
    Route::post('user/store','UserController@store')->name('user.store');

    Route::get('user/edit/{id}','UserController@edit')->name('user.edit');
    Route::post('user/destroy/{id}','UserController@destroy')->name('user.destroy');
    Route::post('user/update/{id}','UserController@update')->name('user.update');

    // roles list
    Route::get('roles/index','RoleController@index')->name('roles.index');
    Route::get('roles/create','RoleController@create')->name('roles.create');
    Route::post('roles/store','RoleController@store')->name('roles.store');
    Route::get('roles/edit/{id}','RoleController@edit')->name('roles.edit');
    Route::post('roles/destroy/{id}','RoleController@destroy')->name('roles.destroy');
    Route::post('roles/update/{id}','RoleController@update')->name('roles.update');

    // permission list
    Route::get('permissions/index','PermissionController@index')->name('permissions.index');
    Route::get('permissions/create','PermissionController@create')->name('permissions.create');
    Route::post('permissions/store','PermissionController@store')->name('permissions.store');
    Route::get('permissions/edit/{id}','PermissionController@edit')->name('permissions.edit');
    Route::post('permissions/update/{id}','PermissionController@update')->name('permissions.update');
    Route::post('permissions/destroy/{id}','PermissionController@destroy')->name('permissions.destroy');

    Route::get('/account','Admin\AccountController@index')->name('account.index');
    Route::get('/dashboard', 'Admin\AdminController@index')->name('dashboard');
    Route::get('/send-email', 'Admin\SendGridEmailController@sendMail')->name('sendMail');
    Route::get('/test-rvm', 'Admin\RvmController@sendrvm')->name('sendrvm');

    // Source list route
    Route::get('/source-list', 'Admin\SourceListController@index')->name('source.list');

    // Profile page route
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Campaigns
    Route::resource('/campaigns', Admin\CampaignController::class);
    // Route::get('/admin/campaigns', 'Admin\CampaignController@index')->name('admin.campaigns.index');

    // Route::get('/campaigns', [CampaignController::class, 'index'])->name('admin.campaign');

//    Route::resource('account','Admin\RoleController');
    Route::resource('account','Admin\AccountController');
    Route::resource('quick-response','Admin\QuickResponseController');
    Route::resource('lead-category','Admin\LeadCategoryController');
    Route::resource('dnc-database','Admin\DNCController');
    Route::resource('auto-reply','Admin\AutoReplyController');
    Route::resource('number','Admin\NumberController');
    Route::resource('single-sms','Admin\SingleSMSController');
    Route::get('/bulk-category', 'Admin\BulkSMSController@bulkCategory')->name('bulksmscategory.index');
    Route::post('/bulk-category/store', 'Admin\BulkSMSController@bulkCategoryStore')->name('bulksmscategory.store');
    Route::resource('bulk-sms','Admin\BulkSMSController');
    Route::post('one-at-time/details','Admin\OneSMSController@showDetails')->name('one-at-time.details');
    Route::resource('one-at-time','Admin\OneSMSController');
    Route::resource('template','Admin\TemplateController');
    Route::resource('campaign','Admin\CampaignController');
    Route::resource('campaignlist','Admin\CampaignListController');
    //Route::resource('single-sms','Admin\SingleSMSController');
    Route::resource('campaignlistNew','Admin\CampaignListController');
    Route::resource('group','Admin\GroupController');
    Route::get('group-contacts-all','Admin\GroupController@getAllContacts')->name('group-contacts-all');
    Route::resource('auto-responder','Admin\AutoResponderController');
    Route::get('failed-sms','Admin\SMSController@failedSms')->name('sms.failed');
    Route::delete('failed-sms/destroy','Admin\SMSController@failedSmsDestroy')->name('failed-sms.destroy');
    Route::get('received-sms','Admin\SMSController@receivedSms')->name('sms.success');
     Route::get('receive','Admin\ReceiveController@index');
    Route::post('sms/thread','Admin\SMSController@saveThread')->name('thread.save');
    Route::get('sms/thread','Admin\SMSController@threads')->name('thread.show');
    Route::get('sms/{sms}','Admin\SMSController@show')->name('sms.show');
    Route::post('sms/add-to-dnc','Admin\SMSController@addToDNC')->name('sms.add-to-dnc');
    Route::resource('reply','Admin\ReplyController');
    Route::resource('blacklist','Admin\BlacklistController');
    Route::resource('category','Admin\CategoryController');
    Route::resource('tag','Admin\TagController');
    Route::resource('rvm','Admin\CreateRvmController');
    Route::resource('market','Admin\MarketController');
    Route::resource('settings','Admin\SettingsController');
    Route::resource('adminsettings','Admin\AdminSettingsController');

    Route::get('get/template/{id}','Admin\TemplateController@getTemplate');
    Route::get('schedual/campaign','Admin\CampaignListController@schedual');
    Route::get('/auto-reply/status_update/{id}','Admin\AutoReplyController@status_update');

    Route::get('compaign/copy/{id}','Admin\CampaignController@copy')->name('compaign.copy');

    Route::get('campaign/list/{id}','Admin\CampaignListController@compaignList')->name('campaign.list');

    Route::get('get/message/{type}/{id}','Admin\CampaignListController@getTemplate');

});



Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/receive-sms','Admin\ReceiveController@store')->name('sms.receive');

