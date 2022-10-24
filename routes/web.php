<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CampaignController as AdminCampaign;
use App\Http\Controllers\Admin\ArchivesController as AdminArchives;
use App\Http\Controllers\Admin\AssetController as AdminAsset;
use App\Http\Controllers\Admin\RoleController as AdminRole;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\BrandController as AdminBrand;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\NotifyController as NotifyController;
use App\Mail\SendMail as SendMail;
use App\Mail\MyDemoMail as MyDemoMail;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('/auth/login');
});

//Route for mailing
Route::get('/email', function() {
    Mail::to('jinsunglee.8033@gmail.com')->send(new SendMail());
    return new SendMail();
});


Route::get('/email_test', [SendMail::class, 'email_send'])->name('email_send');
//Route::get('/my_demo_mail',[MyDemoMail::class, 'myDemoMail'])->name('my_demo_mail');

Route::get('/email_copy_request', [NotifyController::class, 'copy_request']);
Route::get('/email_copy_review', [NotifyController::class, 'copy_review']);

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/test', [AdminDashboard::class, 'test'])->name('dashboard.test');

    Route::get('roles/reload-permissions/{id}', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::get('roles/reload-permissions', [AdminRole::class, 'reloadPermissions'])->name('roles.update');
    Route::resource('roles', AdminRole::class);

    Route::resource('users', AdminUser::class);
    Route::resource('brands', AdminBrand::class);

    Route::get('settings/remove/{id}', [AdminSetting::class, 'remove'])->name('settings.update');

    Route::get('settings', [AdminSetting::class, 'index'])->name('settings.update');
    Route::post('settings', [AdminSetting::class, 'update'])->name('settings.update');

    Route::get('campaign', [AdminCampaign::class, 'index'])->name('campaign.index');
    Route::resource('campaign', AdminCampaign::class);
    Route::get('campaign/archives', [AdminCampaign::class, 'archives'])->name('campaign.archives');

    Route::get('archives', [AdminArchives::class, 'index'])->name('archives.index');
    Route::resource('archives', AdminArchives::class);

    Route::get('asset_approval', [AdminAsset::class, 'asset_approval'])->name('asset.approval');
    Route::get('asset_assign', [AdminAsset::class, 'asset_assign'])->name('asset.assign');
    Route::get('asset_jira', [AdminAsset::class, 'asset_jira'])->name('asset.jira');
    Route::get('asset_jira_kec', [AdminAsset::class, 'asset_jira_kec'])->name('asset.jira_kec');
    Route::get('asset_jira_copywriter', [AdminAsset::class, 'asset_jira_copywriter'])->name('asset.jira_copywriter');
    Route::get('asset/{a_id}/{c_id}/{a_type}/detail', [AdminAsset::class, 'asset_detail'])->name('asset.detail');

    Route::post('asset/assign', [AdminAsset::class, 'asset_assign'])->name('asset.assign');
    Route::post('asset/assign_change', [AdminAsset::class, 'asset_assign_change'])->name('asset.assign_change');
    Route::post('asset/decline_copy', [AdminAsset::class, 'asset_decline_copy'])->name('asset.decline_copy');
    Route::post('asset/decline_creative', [AdminAsset::class, 'asset_decline_creative'])->name('asset.decline_creative');
    Route::post('asset/decline_kec', [AdminAsset::class, 'asset_decline_kec'])->name('asset.decline_kec');

    Route::post('asset/asset_notification_user', [AdminAsset::class, 'asset_notification_user'])->name('asset.asset_notification_user');

    Route::get('asset/copyReview/{id}', [AdminAsset::class, 'copyReview'])->name('campaign.copyReview');
    Route::get('asset/copyComplete/{id}', [AdminAsset::class, 'copyComplete'])->name('campaign.copyComplete');
    Route::get('asset/inProgress/{id}', [AdminAsset::class, 'inProgress'])->name('campaign.inProgress');
    Route::get('asset/done/{id}', [AdminAsset::class, 'done'])->name('campaign.done');
    Route::get('asset/finalApproval/{id}', [AdminAsset::class, 'finalApproval'])->name('campaign.finalApproval');

    Route::get('campaign/fileRemove/{id}', [AdminCampaign::class, 'fileRemove'])->name('campaign.fileRemove');

    Route::get('campaign/assetRemove/{a_id}/{type}', [AdminCampaign::class, 'assetRemove'])->name('campaign.assetRemove');
    Route::get('campaign/campaignRemove/{c_id}', [AdminCampaign::class, 'campaignRemove'])->name('campaign.campaignRemove');

    Route::post('campaign/add_email_blast', [AdminCampaign::class, 'add_email_blast'])->name('campaign.add_email_blast');
    Route::post('campaign/add_social_ad', [AdminCampaign::class, 'add_social_ad'])->name('campaign.add_social_ad');
    Route::post('campaign/add_website_banners', [AdminCampaign::class, 'add_website_banners'])->name('campaign.add_website_banners');
    Route::post('campaign/add_website_changes', [AdminCampaign::class, 'add_website_changes'])->name('campaign.add_website_changes');
    Route::post('campaign/add_landing_page', [AdminCampaign::class, 'add_landing_page'])->name('campaign.add_landing_page');
    Route::post('campaign/add_misc', [AdminCampaign::class, 'add_misc'])->name('campaign.add_misc');
    Route::post('campaign/add_topcategories_copy', [AdminCampaign::class, 'add_topcategories_copy'])->name('campaign.add_topcategories_copy');
    Route::post('campaign/add_programmatic_banners', [AdminCampaign::class, 'add_programmatic_banners'])->name('campaign.add_programmatic_banners');
    Route::post('campaign/add_image_request', [AdminCampaign::class, 'add_image_request'])->name('campaign.add_image_request');
    Route::post('campaign/add_roll_over', [AdminCampaign::class, 'add_roll_over'])->name('campaign.add_roll_over');
    Route::post('campaign/add_store_front', [AdminCampaign::class, 'add_store_front'])->name('campaign.add_store_front');
    Route::post('campaign/add_a_content', [AdminCampaign::class, 'add_a_content'])->name('campaign.add_a_content');

    Route::post('campaign/edit_email_blast/{asset_id}', [AdminCampaign::class, 'edit_email_blast'])->name('campaign.edit_email_blast');
    Route::post('campaign/edit_social_ad/{asset_id}', [AdminCampaign::class, 'edit_social_ad'])->name('campaign.edit_social_ad');
    Route::post('campaign/edit_website_banners/{asset_id}', [AdminCampaign::class, 'edit_website_banners'])->name('campaign.edit_website_banners');
    Route::post('campaign/edit_website_changes/{asset_id}', [AdminCampaign::class, 'edit_website_changes'])->name('campaign.edit_website_changes');
    Route::post('campaign/edit_landing_page/{asset_id}', [AdminCampaign::class, 'edit_landing_page'])->name('campaign.edit_landing_page');
    Route::post('campaign/edit_misc/{asset_id}', [AdminCampaign::class, 'edit_misc'])->name('campaign.edit_misc');
    Route::post('campaign/edit_topcategories_copy/{asset_id}', [AdminCampaign::class, 'edit_topcategories_copy'])->name('campaign.edit_topcategories_copy');
    Route::post('campaign/edit_programmatic_banners/{asset_id}', [AdminCampaign::class, 'edit_programmatic_banners'])->name('campaign.edit_programmatic_banners');
    Route::post('campaign/edit_image_request/{asset_id}', [AdminCampaign::class, 'edit_image_request'])->name('campaign.edit_image_request');
    Route::post('campaign/edit_roll_over/{asset_id}', [AdminCampaign::class, 'edit_roll_over'])->name('campaign.edit_roll_over');
    Route::post('campaign/edit_store_front/{asset_id}', [AdminCampaign::class, 'edit_store_front'])->name('campaign.edit_store_front');
    Route::post('campaign/edit_a_content/{asset_id}', [AdminCampaign::class, 'edit_a_content'])->name('campaign.edit_a_content');

});
