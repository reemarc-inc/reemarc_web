<?php

namespace App\Http\Controllers;

use App\Mail\AssignToDo;
use App\Mail\CopyComplete;
use App\Mail\CopyRequest;
use App\Mail\CopyReview;
use App\Mail\DeclineCopy;
use App\Mail\DeclineCreative;
use App\Mail\DeclineKec;
use App\Mail\FinalApproval;
use App\Mail\SendMail;
use App\Mail\Todo;
use App\Models\CampaignBrands;
use App\Models\User;
use App\Repositories\Admin\AssetNotificationUserRepository;
use App\Repositories\Admin\CampaignAssetIndexRepository;
use App\Repositories\Admin\CampaignBrandsRepository;
use App\Repositories\Admin\CampaignRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use App\Mail\MyDemoMail;
use App\Mail\ReminderDueAfter;
use App\Mail\ReminderDueBefore;
use App\Mail\ReminderDueToday;
use Mail;

class NotifyController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function copy_request($c_id, $a_id)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $campaign_brand_id = $campaign_rs['campaign_brand'];

        $brand_obj = new CampaignBrandsRepository();
        $brand = $brand_obj->findById($campaign_brand_id);
        $brand_name = $brand['campaign_name'];

        $user_obj = new UserRepository();
        $user_rs = $user_obj->getWriterByBrandName($brand_name); // copywriters who has that brand

        if($user_rs) {
            foreach ($user_rs as $user){
                $details = [
                    'who'           => $user['first_name'],
                    'c_id'          => $c_id,
                    'a_id'          => $a_id,
                    'task_name'     => $campaign_rs['name'],
                    'asset_type'    => $asset_type,
                    'asset_status'  => $asset_status,
                    'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
                ];

                Mail::to($user['email'])->send(new CopyRequest($details));
            }
        }

    }

    public function copy_review($c_id, $a_id)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];
        $asset_author_id = $asset_index_rs['author_id'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $author_id = $campaign_rs['author_id'];

        $user_obj = new UserRepository();
        $user_rs = $user_obj->findById($author_id);

        $details = [
            'who'           => $user_rs['first_name'],
            'c_id'          => $c_id,
            'a_id'          => $a_id,
            'task_name'     => $campaign_rs['name'],
            'asset_type'    => $asset_type,
            'asset_status'  => $asset_status,
            'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
        ];

        // Email to task creator..
        Mail::to($user_rs['email'])->send(new CopyReview($details));

        if($asset_author_id) {
            if ($author_id != $asset_author_id) {
                $asset_author_rs = $user_obj->findById($asset_author_id);
                $details = [
                    'who' => $asset_author_rs['first_name'],
                    'c_id' => $c_id,
                    'a_id' => $a_id,
                    'task_name' => $campaign_rs['name'],
                    'asset_type' => $asset_type,
                    'asset_status' => $asset_status,
                    'url' => '/admin/campaign/' . $c_id . '/edit#' . $a_id,
                ];
                // Eamil to asset creator..
                Mail::to($asset_author_rs['email'])->send(new CopyReview($details));
            }
        }

        // Email to asset_notification_user
        $anu_obj = new AssetNotificationUserRepository();
        $anu_rs = $anu_obj->getByAssetId($a_id);
        if(isset($anu_rs[0])){
            if($anu_rs[0]->user_id_list != "" ) {
                $reciver_list = explode(', ', $anu_rs[0]->user_id_list);
            }else{
                $reciver_list = '';
            }
        }else{
            $reciver_list = '';
        }
        if($reciver_list != ''){
            foreach ($reciver_list as $reciver_id){
                $reciver_rs = $user_obj->findById($reciver_id);
                $details = [
                    'who' => $reciver_rs['first_name'],
                    'c_id' => $c_id,
                    'a_id' => $a_id,
                    'task_name' => $campaign_rs['name'],
                    'asset_type' => $asset_type,
                    'asset_status' => $asset_status,
                    'url' => '/admin/campaign/' . $c_id . '/edit#' . $a_id,
                ];
                // Eamil to asset_notification_user
                Mail::to($reciver_rs['email'])->send(new CopyReview($details));
            }
        }

    }

    public function copy_complete($c_id, $a_id)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $campaign_brand = $campaign_rs['campaign_brand'];
        $user_obj = new UserRepository();

        if($campaign_brand == 5){ // if Joah -> Joah Director
            $user_rs = $user_obj->getJoahDirector();
            if($user_rs) {
                foreach ($user_rs as $user){
                    $details = [
                        'who'           => $user['first_name'],
                        'c_id'          => $c_id,
                        'a_id'          => $a_id,
                        'task_name'     => $campaign_rs['name'],
                        'asset_type'    => $asset_type,
                        'asset_status'  => $asset_status,
                        'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
                    ];
                    Mail::to($user['email'])->send(new CopyComplete($details));
                }
            }
        }else{ // others -> Creative Director
            $user_rs = $user_obj->getCreativeDirector();
            if($user_rs) {
                foreach ($user_rs as $user){
                    $details = [
                        'who'           => $user['first_name'],
                        'c_id'          => $c_id,
                        'a_id'          => $a_id,
                        'task_name'     => $campaign_rs['name'],
                        'asset_type'    => $asset_type,
                        'asset_status'  => $asset_status,
                        'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
                    ];
                    Mail::to($user['email'])->send(new CopyComplete($details));
                }
            }
        }
    }

    public function to_do($c_id, $a_id, $assignee)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $user_obj = new UserRepository();
        $names = $user_obj->getEmailByDesignerName($assignee);

        foreach ($names as $name){
            $details = [
                'who'           => $name['first_name'],
                'c_id'          => $c_id,
                'a_id'          => $a_id,
                'task_name'     => $campaign_rs['name'],
                'asset_type'    => $asset_type,
                'asset_status'  => $asset_status,
                'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
            ];
//            Mail::to($name['email'])->send(new Todo($details));
            Mail::to($name['email'])->send(new AssignToDo($details));
        }
    }

    public function final_approval($c_id, $a_id)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];
        $asset_author_id = $asset_index_rs['author_id'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $author_id = $campaign_rs['author_id'];

        $user_obj = new UserRepository();
        $user_rs = $user_obj->findById($author_id);

        if($user_rs) {
            $details = [
                'who'           => $user_rs['first_name'],
                'c_id'          => $c_id,
                'a_id'          => $a_id,
                'task_name'     => $campaign_rs['name'],
                'asset_type'    => $asset_type,
                'asset_status'  => $asset_status,
                'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
            ];

            Mail::to($user_rs['email'])->send(new FinalApproval($details));
        }

        if($asset_author_id) {
            if ($author_id != $asset_author_id) {
                $asset_author_rs = $user_obj->findById($asset_author_id);
                $details = [
                    'who' => $asset_author_rs['first_name'],
                    'c_id' => $c_id,
                    'a_id' => $a_id,
                    'task_name' => $campaign_rs['name'],
                    'asset_type' => $asset_type,
                    'asset_status' => $asset_status,
                    'url' => '/admin/campaign/' . $c_id . '/edit#' . $a_id,
                ];
                // Eamil to asset creator..
                Mail::to($asset_author_rs['email'])->send(new FinalApproval($details));
            }
        }

        // Email to asset_notification_user
        $anu_obj = new AssetNotificationUserRepository();
        $anu_rs = $anu_obj->getByAssetId($a_id);
        if(isset($anu_rs[0])){
            if($anu_rs[0]->user_id_list != "" ) {
                $reciver_list = explode(', ', $anu_rs[0]->user_id_list);
            }else{
                $reciver_list = '';
            }
        }else{
            $reciver_list = '';
        }
        if($reciver_list != ''){
            foreach ($reciver_list as $reciver_id){
                $reciver_rs = $user_obj->findById($reciver_id);
                $details = [
                    'who' => $reciver_rs['first_name'],
                    'c_id' => $c_id,
                    'a_id' => $a_id,
                    'task_name' => $campaign_rs['name'],
                    'asset_type' => $asset_type,
                    'asset_status' => $asset_status,
                    'url' => '/admin/campaign/' . $c_id . '/edit#' . $a_id,
                ];
                // Eamil to asset_notification_user
                Mail::to($reciver_rs['email'])->send(new FinalApproval($details));
            }
        }

    }

    public function decline_from_copy($c_id, $a_id, $params)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $brand_id = $campaign_rs['campaign_brand'];

        $brand_obj = new CampaignBrandsRepository();
        $brand_rs = $brand_obj->findById($brand_id);

        $user_obj = new UserRepository();

        // Send email to copy writers
        $copywriter_rs = $user_obj->getWriterByBrandName($brand_rs['campaign_name']);
        if($copywriter_rs) {
            foreach ($copywriter_rs as $copywriter){
                $details = [
                    'who'           => $copywriter['first_name'],
                    'c_id'          => $c_id,
                    'a_id'          => $a_id,
                    'task_name'     => $campaign_rs['name'],
                    'asset_type'    => $asset_type,
                    'asset_status'  => $asset_status,
                    'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
                ];
                Mail::to($copywriter['email'])->send(new DeclineCopy($details));
            }
        }
    }

    public function decline_from_kec($c_id, $a_id, $params)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];
        $asset_assignee = $asset_index_rs['assignee'];

        $user_obj = new UserRepository();
        $names = $user_obj->getEmailByDesignerName($asset_assignee);

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        foreach ($names as $name){
            $details = [
                'who'           => $name['first_name'],
                'c_id'          => $c_id,
                'a_id'          => $a_id,
                'task_name'     => $campaign_rs['name'],
                'asset_type'    => $asset_type,
                'asset_status'  => $asset_status,
                'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
            ];
            Mail::to($name['email'])->send(new DeclineKec($details));
        }

    }

    public function decline_from_creative($c_id, $a_id, $params)
    {
        $asset_index_obj = new CampaignAssetIndexRepository();
        $asset_index_rs = $asset_index_obj->findById($a_id);

        $asset_type = $asset_index_rs['type'];
        $asset_status = $asset_index_rs['status'];

        $campaign_obj = new CampaignRepository();
        $campaign_rs = $campaign_obj->findById($c_id);

        $author_id = $campaign_rs['author_id'];

        $user_obj = new UserRepository();
        $user_rs = $user_obj->findById($author_id); // task creator

        if($user_rs) {
            $details = [
                'who'           => $user_rs['first_name'],
                'c_id'          => $c_id,
                'a_id'          => $a_id,
                'task_name'     => $campaign_rs['name'],
                'asset_type'    => $asset_type,
                'asset_status'  => $asset_status,
                'url'           => '/admin/campaign/'.$c_id.'/edit#'.$a_id,
            ];
            Mail::to($user_rs['email'])->send(new DeclineCreative($details));
        }
    }

    public static function reminder_email()
    {
//        $details = [
//            'due' => '2022-10-21',
//            'who' => 'Jordan',
//            'c_id' => 1111,
//            'a_id' => 2222,
//            'task_name' => 'Template Assets for Catalog Flow Emails - imPRESS',
//            'asset_type' => 'Misc',
//            'asset_status' => 'Copy Request',
//            'url' => '/admin/campaign/1111/edit#2222',
//        ];
//
//        $cc_list = array();
//
//        $cc_list[] = 'jilee2@kissusa.com';
//
//        Mail::to('jinjin33s@gmail.com')
//            ->cc($cc_list)
//            ->send(new ReminderDueAfter($details));
//
//        ddd("done");


        // This is for template preview!!!
//        $send_email = new SendMail();
//        return $send_email->build();


        $obj = new AssetNotificationUserRepository();
        $user_obj = new UserRepository();

        $today = date('Y-m-d');
        $day_after_tomorrow = date('Y-m-d', strtotime($today . '2 day'));

        // copy_request for copy writer!!!
//        $result_copy_request = $obj->getCopyRequestStatus();
//        foreach ($result_copy_request as $item) {
//
//            $asset_type = $item->asset_type;
//            $copywriter_start_due = date('Y-m-d');
//
//            if($asset_type == 'email_blast'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-16 weekday'));
//            }else if($asset_type == 'social_ad'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-16 weekday'));
//            }else if($asset_type == 'website_banners'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-17 weekday'));
//            }else if($asset_type == 'landing_page'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-30 weekday'));
//            }else if($asset_type == 'misc'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
//            }else if($asset_type == 'topcategories_copy'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-5 weekday'));
//            }else if($asset_type == 'programmatic_banners'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-19 weekday'));
//            }else if($asset_type == 'a_content'){
//                $copywriter_start_due = date('Y-m-d', strtotime($item->due . '-27 weekday'));
//            }
//
//            if($copywriter_start_due == $today){
//                // sending 'today is due' email => send to copy writers
//                $brand_name = $item->brand_name;
//                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
//                foreach ($copy_writers as $person){
//                    $details = [
//                        'due' => $copywriter_start_due,
//                        'who' => $person['first_name'],
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Request',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Email to asset creator!
////                    Mail::to($person['email'])->send(new ReminderDueToday($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
//                }
//
//            }else if($copywriter_start_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => send to copy writers
//                $brand_name = $item->brand_name;
//                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
//                foreach ($copy_writers as $person) {
//                    $details = [
//                        'due' => $copywriter_start_due,
//                        'who' => $person['first_name'],
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Request',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Email to asset creator!
////                    Mail::to($person['email'])->send(new ReminderDueBefore($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
//                }
//            }else if($copywriter_start_due < $today){
//                // sending 'past due date' email => send to copy writers and directors
//                $brand_name = $item->brand_name;
//                $copy_writers = $user_obj->getWriterByBrandName($brand_name); // get copywriters belong to that brand
//                foreach ($copy_writers as $person) {
//                    $details = [
//                        'due' => $copywriter_start_due,
//                        'who' => $person['first_name'],
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Request',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Email to copy writer! and director Frank and Ji
////                    Mail::to($person['email'])
////                        ->cc('frank.russo@kissusa.com', 'jikim@kissusa.com')
////                        ->send(new ReminderDueAfter($details));
//                    Mail::to('jilee2@kissusa.com')
//                        ->cc('jinsunglee.8033@gmail.com', 'jinsunglee.8033@gmail.com')
//                        ->send(new ReminderDueAfter($details));
//
//                }
//            }
//        }

        // copy_review for Asset Creator!!!
//        $result_copy_review = $obj->getCopyReviewStatus();
//        foreach ($result_copy_review as $item) {
//
//            $asset_type = $item->asset_type;
//            $copyreview_start_due = date('Y-m-d');
//
//            if($asset_type == 'email_blast'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-14 weekday'));
//            }else if($asset_type == 'social_ad'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-14 weekday'));
//            }else if($asset_type == 'website_banners'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-15 weekday'));
//            }else if($asset_type == 'landing_page'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-26 weekday'));
//            }else if($asset_type == 'misc'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-13 weekday'));
//            }else if($asset_type == 'topcategories_copy'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
//            }else if($asset_type == 'programmatic_banners'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-17 weekday'));
//            }else if($asset_type == 'a_content'){
//                $copyreview_start_due = date('Y-m-d', strtotime($item->due . '-25 weekday'));
//            }
//
//            if($copyreview_start_due == $today){
//                // sending 'today is due' email => to asset creator
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $copyreview_start_due,
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Eamil to asset creator!
////                    Mail::to($item->asset_author_email)->send(new ReminderDueToday($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
//                }
//            }else if($copyreview_start_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => to asset creator (okay)
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $copyreview_start_due, // tomorrow date!
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Eamil to asset creator
////                    Mail::to($item->asset_author_email)->send(new ReminderDueBefore($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
//                }
//            }else if($copyreview_start_due < $today){
//                // sending 'over due' email => to asset creator and directors (okay)
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $copyreview_start_due,
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Copy Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Email to asset creator and Director!
//                    $cc_list = array();
//                    if($item->brand_id == 1){
//                        $cc_list[] = 'kristing@kissusa.com';
//                    }else if($item->brand_id == 2){
//                        $cc_list[] = 'kibremer@kissusa.com';
//                    }else if($item->brand_id == 3){
//                        $cc_list[] = 'jennifer.clark@kissusa.com';
//                    }else if($item->brand_id == 4){
//                        $cc_list[] = 'kristing@kissusa.com';
//                    }else if($item->brand_id == 5){
//                        $cc_list[] = 'haejin.chang@kissusa.com';
//                    }else if($item->brand_id == 6){
//                        $cc_list[] = 'jennifer.clark@kissusa.com';
//                    }else if($item->brand_id == 7){
//                        $cc_list[] = 'frank.russo@kissusa.com';
//                        $cc_list[] = 'jikim@kissusa.com';
//                        $cc_list[] = 'annette.goldstein@kissusa.com';
//                    }else if($item->brand_id == 8){
//                        $cc_list[] = 'frank.russo@kissusa.com';
//                        $cc_list[] = 'jikim@kissusa.com';
//                        $cc_list[] = 'annette.goldstein@kissusa.com';
//                    }else if($item->brand_id == 10){
//                        $cc_list[] = 'carriec@kissusa.com';
//                    }else if($item->brand_id == 13){
//                        $cc_list[] = 'kibremer@kissusa.com';
//                    }
//                    // Send email to director
////                    Mail::to($item->asset_author_email)
////                        ->cc($cc_list)
////                        ->send(new ReminderDueAfter($details));
//                    Mail::to('jilee2@kissusa.com')
//                        ->cc('jinsunglee.8033@gmail.com', '33.jinsunglee@gmail.com')
//                        ->send(new ReminderDueAfter($details));
//                }
//            }
//        }

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
//            if($creative_assign_start_due == $today){
//                // sending 'today is due' email => Hong, Geunho
//                if($item->brand_id == 5){ // If Joah.. => Geunho
//                    $joah_team_leaders = $user_obj->getJoahDirector();
//                    if(isset($joah_team_leaders)) {
//                        foreach ($joah_team_leaders as $joah_team_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $joah_team_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
////                            Mail::to($joah_team_leader['email'])->send(new ReminderDueToday($details));
//                            Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
//                        }
//                    }
//                }else{ // If NOT Joah.. => Hong Jung
//                    $creative_leaders = $user_obj->getCreativeDirector();
//                    if(isset($creative_leaders)) {
//                        foreach ($creative_leaders as $creative_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $creative_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
////                            Mail::to($creative_leader['email'])->send(new ReminderDueToday($details));
//                            Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
//                        }
//                    }
//                }
//            }else if($creative_assign_start_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => send to hong, geunho
//                if($item->brand_id == 5){ // If Joah.. => Geunho
//                    $joah_team_leaders = $user_obj->getJoahDirector();
//                    if(isset($joah_team_leaders)) {
//                        foreach ($joah_team_leaders as $joah_team_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $joah_team_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
////                            Mail::to($joah_team_leader['email'])->send(new ReminderDueBefore($details));
//                            Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
//                        }
//                    }
//                }else{ // If NOT Joah.. => Hong Jung
//                    $creative_leaders = $user_obj->getCreativeDirector();
//                    if(isset($creative_leaders)) {
//                        foreach ($creative_leaders as $creative_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $creative_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
////                            Mail::to($creative_leader['email'])->send(new ReminderDueBefore($details));
//                            Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
//                        }
//                    }
//                }
//            }else if($creative_assign_start_due < $today){
//                // sending 'past due date' if late, email to => hong, geunho and Flori, Haejin (their directors)
//                if($item->brand_id == 5){ // If Joah.. => Geunho
//                    $joah_team_leaders = $user_obj->getJoahDirector();
//                    if(isset($joah_team_leaders)) {
//                        foreach ($joah_team_leaders as $joah_team_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $joah_team_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
//                            // Send to director Haejin
////                            Mail::to($joah_team_leader['email'])
////                                ->cc('haejin.chang@kissusa.com')
////                                ->send(new ReminderDueAfter($details));
//
//                            Mail::to('jilee2@kissusa.com')
//                                ->cc('jinsunglee.8033@gmail.com')
//                                ->send(new ReminderDueAfter($details));
//
//                        }
//                    }
//                }else{ // If NOT Joah.. => Hong Jung
//                    $creative_leaders = $user_obj->getCreativeDirector();
//                    if(isset($creative_leaders)) {
//                        foreach ($creative_leaders as $creative_leader){
//                            $details = [
//                                'due'           => $creative_assign_start_due,
//                                'who'           => $creative_leader['first_name'],
//                                'c_id'          => $item->campaign_id,
//                                'a_id'          => $item->asset_id,
//                                'task_name'     => $item->project_name,
//                                'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
//                                'asset_status'  => 'Creative Assign',
//                                'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
//                            ];
//                            // Send to director Flori
////                            Mail::to($creative_leader['email'])
////                                ->cc('flori.ohm@kissusa.com')
////                                ->send(new ReminderDueAfter($details));
//                            Mail::to('jilee2@kissusa.com')
//                                ->cc('jinsunglee.8033@gmail.com')
//                                ->send(new ReminderDueAfter($details));
//                        }
//                    }
//                }
//            }
//
//        }

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

            if($creative_work_start_due == $today){
                // sending 'today is due' email => send to designer
                $designer = $user_obj->getDesignerByFirstName($item->assignee);
                if(isset($designer[0])) {
                    $details = [
                        'due'           => $creative_work_start_due,
                        'who'           => $item->assignee,
                        'c_id'          => $item->campaign_id,
                        'a_id'          => $item->asset_id,
                        'task_name'     => $item->project_name,
                        'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status'  => 'Creative Work',
                        'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
                    ];
//                    Mail::to($designer[0]->email)->send(new ReminderDueToday($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
                }

            }else if($creative_work_start_due == $day_after_tomorrow){
                // sending 'tomorrow is due' email => send to designer
                $designer = $user_obj->getDesignerByFirstName($item->assignee);
                if(isset($designer[0])) {
                    $details = [
                        'due'           => $creative_work_start_due,
                        'who'           => $item->assignee,
                        'c_id'          => $item->campaign_id,
                        'a_id'          => $item->asset_id,
                        'task_name'     => $item->project_name,
                        'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status'  => 'Creative Work',
                        'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
                    ];
//                    Mail::to($designer[0]->email)->send(new ReminderDueBefore($details));
                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
                }

            }else if($creative_work_start_due < $today){
                // sending 'past due date' if late, email to => Hong, Geunho
                $designer = $user_obj->getDesignerByFirstName($item->assignee);
                if(isset($designer[0])) {
                    $details = [
                        'due'           => $creative_work_start_due,
                        'who'           => $item->assignee,
                        'c_id'          => $item->campaign_id,
                        'a_id'          => $item->asset_id,
                        'task_name'     => $item->project_name,
                        'asset_type'    => ucwords(str_replace('_', ' ', $item->asset_type)),
                        'asset_status'  => 'Creative Work',
                        'url'           => '/admin/campaign/'.$item->campaign_id.'/edit#'.$item->asset_id,
                    ];
                    // Send to leader .. Hong, Geunho-joah
                    if($item->brand_id == 5){ // if joah, Geunho
//                        Mail::to($designer[0]->email)
//                            ->cc('geunho.kang@kissusa.com')
//                            ->send(new ReminderDueAfter($details));
                        Mail::to('jilee2@kissusa.com')
                            ->cc('jinsunglee.8033@gmail.com')
                            ->send(new ReminderDueAfter($details));
                    }else{ // others, Hong
//                        Mail::to($designer[0]->email)
//                            ->cc('hojung@kissusa.com')
//                            ->send(new ReminderDueAfter($details));
                        Mail::to('jilee2@kissusa.com')
                            ->cc('jinsunglee.8033@gmail.com')
                            ->send(new ReminderDueAfter($details));

                    }
                }
            }
        }

        // waiting_approval (creative review) for asset creator!!! (Final Review start)
//        $result_done = $obj->getDoneStatus();
//        foreach ($result_done as $item) {
//
//            $asset_type = $item->asset_type;
//            $final_review_start_due = date('Y-m-d');
//
//            if($asset_type == 'email_blast'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
//            }else if($asset_type == 'social_ad'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
//            }else if($asset_type == 'website_banners'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-4 weekday'));
//            }else if($asset_type == 'landing_page'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-11 weekday'));
//            }else if($asset_type == 'misc'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
//            }else if($asset_type == 'programmatic_banners'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
//            }else if($asset_type == 'a_content'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
//            }else if($asset_type == 'image_request'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-2 weekday'));
//            }else if($asset_type == 'roll_over'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-3 weekday'));
//            }else if($asset_type == 'store_front'){
//                $final_review_start_due = date('Y-m-d', strtotime($item->due . '-6 weekday'));
//            }
//
//            if($final_review_start_due == $today){
//                // sending 'today is due' email => asset creator
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $final_review_start_due,
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Final Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Eamil to asset creator!
////                    Mail::to($item->asset_author_email)->send(new ReminderDueToday($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueToday($details));
//                }
//
//
//            }else if($final_review_start_due == $day_after_tomorrow){
//                // sending 'tomorrow is due' email => send to asset creator
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $final_review_start_due, // tomorrow date!
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Final Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//                    // Eamil to asset creator
////                    Mail::to($item->asset_author_email)->send(new ReminderDueBefore($details));
//                    Mail::to('jilee2@kissusa.com')->send(new ReminderDueBefore($details));
//                }
//
//            }else if($final_review_start_due < $today){
//                // sending 'past due date' if late, email to => asset creator and directors. same as copy_review
//                if(isset($item->asset_author_id)){
//                    $details = [
//                        'due' => $final_review_start_due,
//                        'who' => $item->asset_author_name,
//                        'c_id' => $item->campaign_id,
//                        'a_id' => $item->asset_id,
//                        'task_name' => $item->project_name,
//                        'asset_type' => ucwords(str_replace('_', ' ', $item->asset_type)),
//                        'asset_status' => 'Final Review',
//                        'url' => '/admin/campaign/' . $item->campaign_id . '/edit#' . $item->asset_id,
//                    ];
//
//                    $cc_list = array();
//                    if($item->brand_id == 1){
//                        $cc_list[] = 'kristing@kissusa.com';
//                    }else if($item->brand_id == 2){
//                        $cc_list[] = 'kibremer@kissusa.com';
//                    }else if($item->brand_id == 3){
//                        $cc_list[] = 'jennifer.clark@kissusa.com';
//                    }else if($item->brand_id == 4){
//                        $cc_list[] = 'kristing@kissusa.com';
//                    }else if($item->brand_id == 5){
//                        $cc_list[] = 'haejin.chang@kissusa.com';
//                    }else if($item->brand_id == 6){
//                        $cc_list[] = 'jennifer.clark@kissusa.com';
//                    }else if($item->brand_id == 7){
//                        $cc_list[] = 'frank.russo@kissusa.com';
//                        $cc_list[] = 'jikim@kissusa.com';
//                        $cc_list[] = 'annette.goldstein@kissusa.com';
//                    }else if($item->brand_id == 8){
//                        $cc_list[] = 'frank.russo@kissusa.com';
//                        $cc_list[] = 'jikim@kissusa.com';
//                        $cc_list[] = 'annette.goldstein@kissusa.com';
//                    }else if($item->brand_id == 10){
//                        $cc_list[] = 'carriec@kissusa.com';
//                    }else if($item->brand_id == 13){
//                        $cc_list[] = 'kibremer@kissusa.com';
//                    }
//                    // Send email to director
////                    Mail::to($item->asset_author_email)
////                        ->cc($cc_list)
////                        ->send(new ReminderDueAfter($details));
//
//                    Mail::to('jilee2@kissusa.com')
//                        ->cc('jinsunglee.8033@gmail.com')
//                        ->send(new ReminderDueAfter($details));
//                }
//            }
//        }
    }


}
