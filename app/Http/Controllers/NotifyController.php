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
use App\Repositories\Admin\CampaignAssetIndexRepository;
use App\Repositories\Admin\CampaignBrandsRepository;
use App\Repositories\Admin\CampaignRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use App\Mail\MyDemoMail;
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

}
