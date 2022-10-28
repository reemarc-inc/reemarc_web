<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotifyController;
use App\Mail\AssignToDo;
use App\Mail\FinalApproval;
use App\Mail\ReminderDueAfter;
use App\Mail\ReminderDueBefore;
use App\Mail\ReminderDueToday;
use App\Mail\SendMail;
use App\Repositories\Admin\AssetNotificationUserRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Mail;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['currentAdminMenu'] = 'dashboard';
        return view('admin.dashboard.index', $this->data);
    }

    public function test()
    {
        $this->data['currentAdminMenu'] = 'dashboard';

        // This is for template preview!!!
//        $send_email = new SendMail();
//        return $send_email->build();

        $obj = new AssetNotificationUserRepository();
        $user_obj = new UserRepository();

        $today = date('Y-m-d');

        $info = array();

        // copy_request for copy writer!!!
        $result_copy_request = $obj->getCopyRequestStatus();

        foreach ($result_copy_request as $item) {

            $asset_type = $item->asset_type;
            $copywriter_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-16 weekday'));
            }else if($asset_type == 'social_ad'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-16 weekday'));
            }else if($asset_type == 'website_banners'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-17 weekday'));
            }else if($asset_type == 'landing_page'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-30 weekday'));
            }else if($asset_type == 'misc'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
            }else if($asset_type == 'topcategories_copy'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-5 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-19 weekday'));
            }else if($asset_type == 'a_content'){
                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-27 weekday'));
            }

            $next_day_of_due = date('Y-m-d', strtotime($copywriter_start_due . '1 day'));

            if($copywriter_start_due == $today){
                // sending 'today is due' email => send to copy writers

            }else if($next_day_of_due == $today){
                // sending 'tomorrow is due' email => send to copy writers

            }else if($copywriter_start_due < $today){
                // sending 'past due date' email => send to copy writers and directors

            }

        }

        // copy_review for Asset Creator!!!
        $result_copy_review = $obj->getCopyReviewStatus();
        foreach ($result_copy_review as $item) {

            $asset_type = $item->asset_type;
            $copyreview_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-14 weekday'));
            }else if($asset_type == 'social_ad'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-14 weekday'));
            }else if($asset_type == 'website_banners'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
            }else if($asset_type == 'landing_page'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-26 weekday'));
            }else if($asset_type == 'misc'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
            }else if($asset_type == 'topcategories_copy'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-5 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-17 weekday'));
            }else if($asset_type == 'a_content'){
                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-25 weekday'));
            }

            $next_day_of_due = date('Y-m-d', strtotime($copyreview_start_due . '1 day'));

            if($copyreview_start_due == $today){
                // sending 'today is due' email => to asset creator
                if(isset($item->author_id)){
                    $asset_creator_rs = $user_obj->findById($item->author_id);
                    $details = [
                        'due' => $copyreview_start_due,
                        'who' => $asset_creator_rs['first_name'],
                        'c_id' => $asset_creator_rs['campaign_id'],
                        'a_id' => $asset_creator_rs['asset_id'],
                        'task_name' => $asset_creator_rs['name'],
                        'asset_type' => $asset_creator_rs['asset_type'],
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $asset_creator_rs['campaign_id'] . '/edit#' . $asset_creator_rs['asset_id'],
                    ];
                    // Eamil to asset creator!
//                    Mail::to($asset_creator_rs['email'])->send(new ReminderDueToday($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details)); // TEST to ME!
                }


            }else if($next_day_of_due == $today){
                // sending 'tomorrow is due' email => to asset creator (okay)
                if(isset($item->asset_author_email)){
                    $details = [
                        'due' => $next_day_of_due, // tomorrow date!
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->name,
                        'asset_type' => $item->asset_type,
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator
//                    Mail::to($asset_creator_rs['email'])->send(new AssignToDo($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
                }
            }else if($copyreview_start_due < $today){
                // sending 'past due date' email => to asset creator and directors (okay)
                if(isset($item->asset_author_email)){
                    $details = [
                        'due' => $copyreview_start_due,
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->name,
                        'asset_type' => $item->asset_type,
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator
//                    Mail::to($asset_creator_rs['email'])->send(new AssignToDo($details));
//                    $info[] = $details;
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueAfter($details));
                }

            }

        }

        // copy_complete for Creative Director!!! (Creative Assign start)
        $result_copy_complete = $obj->getCopyCompleteStatus();
        foreach ($result_copy_complete as $item) {

            $asset_type = $item->asset_type;
            $creative_assign_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
            }else if($asset_type == 'social_ad'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
            }else if($asset_type == 'website_banners'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
            }else if($asset_type == 'landing_page'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
            }else if($asset_type == 'misc'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
            }else if($asset_type == 'a_content'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
            }else if($asset_type == 'image_request'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
            }else if($asset_type == 'roll_over'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
            }else if($asset_type == 'store_front'){
                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
            }

            $next_day_of_due = date('Y-m-d', strtotime($creative_assign_start_due . '1 day'));

            if($creative_assign_start_due == $today){
                // sending 'today is due' email => Hong, Geunho

            }else if($next_day_of_due == $today){
                // sending 'tomorrow is due' email => send to hong, geunho

            }else if($creative_assign_start_due < $today){
                // sending 'past due date' if late, email to => hong, geunho and Flori, Haejin (their directors)

            }

        }

        // to_do for designer!!! (Creative Work start)
        $result_to_do = $obj->getToDoStatus();
        foreach ($result_to_do as $item) {

            $asset_type = $item->asset_type;
            $creative_work_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
            }else if($asset_type == 'social_ad'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
            }else if($asset_type == 'website_banners'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
            }else if($asset_type == 'landing_page'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
            }else if($asset_type == 'misc'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-9 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
            }else if($asset_type == 'a_content'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
            }else if($asset_type == 'image_request'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-9 weekday'));
            }else if($asset_type == 'roll_over'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
            }else if($asset_type == 'store_front'){
                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
            }

            $next_day_of_due = date('Y-m-d', strtotime($creative_work_start_due . '1 day'));

            if($creative_work_start_due == $today){
                // sending 'today is due' email => send to designer

            }else if($next_day_of_due == $today){
                // sending 'tomorrow is due' email => send to designer

            }else if($creative_work_start_due < $today){
                // sending 'past due date' if late, email to => Hong, Geunho

            }

        }


        // waiting_approval for asset creator!!! (Final Review start)
        $result_done = $obj->getDoneStatus();
        foreach ($result_done as $item) {

            $asset_type = $item->asset_type;
            $Final_review_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'social_ad'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'website_banners'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-4 weekday'));
            }else if($asset_type == 'landing_page'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
            }else if($asset_type == 'misc'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'a_content'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
            }else if($asset_type == 'image_request'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
            }else if($asset_type == 'roll_over'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'store_front'){
                $Final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
            }

            $next_day_of_due = date('Y-m-d', strtotime($Final_review_start_due . '1 day'));

            if($Final_review_start_due == $today){
                // sending 'today is due' email => asset creator

            }else if($next_day_of_due == $today){
                // sending 'tomorrow is due' email => send to asset creator

            }else if($Final_review_start_due < $today){
                // sending 'past due date' if late, email to => asset creator and directors. same as copy_review

            }

        }

//        $this->data['info'] = $info;
//
//        return view('admin.dashboard.test', $this->data);
    }
}
