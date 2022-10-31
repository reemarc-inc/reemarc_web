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
        $tomorrow = date('Y-m-d', strtotime($today . '1 day'));
        $day_after_tomorrow = date('Y-m-d', strtotime($today . '2 day'));

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

            if($copywriter_start_due == $today){
                // sending 'today is due' email => send to copy writers

                $brand_name = $item->brand_name;
                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
                foreach ($copy_writers as $person){
                    $details = [
                        'due' => $copywriter_start_due,
                        'who' => $person['first_name'],
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Request',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator!
//                    Mail::to($person['email'])->send(new ReminderDueToday($details));
//                    $info[] = $details;
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details)); // TEST to ME!
                }

            }else if($copywriter_start_due == $day_after_tomorrow){
                // sending 'tomorrow is due' email => send to copy writers
                $brand_name = $item->brand_name;
                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
                foreach ($copy_writers as $person) {
                    $details = [
                        'due' => $copywriter_start_due,
                        'who' => $person['first_name'],
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Request',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator!
//                    Mail::to($person['email'])->send(new ReminderDueBefore($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details)); // TEST to ME!
                }
            }else if($copywriter_start_due < $today){
                // sending 'past due date' email => send to copy writers and directors
                $brand_name = $item->brand_name;
                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
                foreach ($copy_writers as $person) {
                    $details = [
                        'due' => $copywriter_start_due,
                        'who' => $person['first_name'],
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Request',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to copy writer! and director
//                    Mail::to($person['email'])->send(new ReminderDueAfter($details));
//                    $info[] = $details;
                    Mail::to('jilee2@kissusa.com')->bcc('jinsunglee.8033@gmail.com')->send(new ReminderDueAfter($details));
//                    Mail::to('frank.russo@kissusa.com')->send(new ReminderDueAfter($details)); // To Frank
//                    Mail::to('jikim@kissusa.com')->send(new ReminderDueAfter($details)); // To Ji

                }

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

            if($copyreview_start_due == $today){
                // sending 'today is due' email => to asset creator (okay)
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $copyreview_start_due,
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator!
//                    Mail::to($item->asset_author_email)->send(new ReminderDueToday($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details)); // TEST to ME!
                }


            }else if($copyreview_start_due == $day_after_tomorrow){
                // sending 'tomorrow is due' email => to asset creator (okay)
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $copyreview_start_due, // tomorrow date!
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator
//                    Mail::to($item->asset_author_email)->send(new ReminderDueBefore($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
                }
            }else if($copyreview_start_due < $today){
                // sending 'over due' email => to asset creator and directors (okay)
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $copyreview_start_due,
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Copy Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Email to asset creator and Director!
//                    Mail::to($item->asset_author_email)->send(new ReminderDueAfter($details));
                    Mail::to('jilee2@kissusa.com')->bcc('jinsunglee.8033@gmail.com')->send(new ReminderDueAfter($details));
                }

            }

        }

        // copy_complete for Creative Director!!! (Creative Assign start)
//        $result_copy_complete = $obj->getCopyCompleteStatus();
//        foreach ($result_copy_complete as $item) {
//
//            $asset_type = $item->asset_type;
//            $creative_assign_start_due = date('Y-m-d');
//
//            if($asset_type == 'email_blast'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
//            }else if($asset_type == 'social_ad'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
//            }else if($asset_type == 'website_banners'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
//            }else if($asset_type == 'landing_page'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
//            }else if($asset_type == 'misc'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
//            }else if($asset_type == 'programmatic_banners'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
//            }else if($asset_type == 'a_content'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
//            }else if($asset_type == 'image_request'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
//            }else if($asset_type == 'roll_over'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-12 weekday'));
//            }else if($asset_type == 'store_front'){
//                $creative_assign_start_due = date('Y-m-d', strtotime($item->due . '-23 weekday'));
//            }
//
//            $next_day_of_due = date('Y-m-d', strtotime($creative_assign_start_due . '1 day'));
//
//            if($creative_assign_start_due == $today){
//                // sending 'today is due' email => Hong, Geunho
//
//            }else if($next_day_of_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => send to hong, geunho
//
//            }else if($creative_assign_start_due < $today){
//                // sending 'past due date' if late, email to => hong, geunho and Flori, Haejin (their directors)
//
//            }
//
//        }
//
//        // to_do for designer!!! (Creative Work start)
//        $result_to_do = $obj->getToDoStatus();
//        foreach ($result_to_do as $item) {
//
//            $asset_type = $item->asset_type;
//            $creative_work_start_due = date('Y-m-d');
//
//            if($asset_type == 'email_blast'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
//            }else if($asset_type == 'social_ad'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
//            }else if($asset_type == 'website_banners'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
//            }else if($asset_type == 'landing_page'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
//            }else if($asset_type == 'misc'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-9 weekday'));
//            }else if($asset_type == 'programmatic_banners'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
//            }else if($asset_type == 'a_content'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
//            }else if($asset_type == 'image_request'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-9 weekday'));
//            }else if($asset_type == 'roll_over'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-10 weekday'));
//            }else if($asset_type == 'store_front'){
//                $creative_work_start_due = date('Y-m-d', strtotime($item->due . '-21 weekday'));
//            }
//
//            $next_day_of_due = date('Y-m-d', strtotime($creative_work_start_due . '1 day'));
//
//            if($creative_work_start_due == $today){
//                // sending 'today is due' email => send to designer
//
//            }else if($creative_work_start_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => send to designer
//
//            }else if($creative_work_start_due < $today){
//                // sending 'past due date' if late, email to => Hong, Geunho
//
//            }
//
//        }


        // waiting_approval for asset creator!!! (Final Review start)
        $result_done = $obj->getDoneStatus();
        foreach ($result_done as $item) {

            $asset_type = $item->asset_type;
            $final_review_start_due = date('Y-m-d');

            if($asset_type == 'email_blast'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'social_ad'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'website_banners'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-4 weekday'));
            }else if($asset_type == 'landing_page'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
            }else if($asset_type == 'misc'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
            }else if($asset_type == 'programmatic_banners'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'a_content'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
            }else if($asset_type == 'image_request'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
            }else if($asset_type == 'roll_over'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
            }else if($asset_type == 'store_front'){
                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
            }

            if($final_review_start_due == $today){
                // sending 'today is due' email => asset creator
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $final_review_start_due,
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Final Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator!
//                    Mail::to($item->asset_author_email)->send(new ReminderDueToday($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details)); // TEST to ME!
                }


            }else if($final_review_start_due == $day_after_tomorrow){
                // sending 'tomorrow is due' email => send to asset creator
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $final_review_start_due, // tomorrow date!
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Final Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Eamil to asset creator
//                    Mail::to($item->asset_author_email)->send(new ReminderDueBefore($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
                }

            }else if($final_review_start_due < $today){
                // sending 'past due date' if late, email to => asset creator and directors. same as copy_review
                if(isset($item->asset_author_id)){
                    $details = [
                        'due' => $final_review_start_due,
                        'who' => $item->asset_author_name,
                        'c_id' => $item->campaign_id,
                        'a_id' => $item->asset_id,
                        'task_name' => $item->project_name,
                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status' => 'Final Review',
                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
                    ];
                    // Email to asset creator and Director!
//                    Mail::to($item->asset_author_email)->send(new ReminderDueAfter($details));
                    Mail::to('jilee2@kissusa.com')->bcc('jinsunglee.8033@gmail.com')->send(new ReminderDueAfter($details));
                }
            }

        }

//        $this->data['info'] = $info;
//
//        return view('admin.dashboard.test', $this->data);
    }
}
