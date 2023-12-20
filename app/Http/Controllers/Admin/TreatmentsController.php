<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\FileAttachmentsRepository;
use App\Repositories\Admin\PackageRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Repositories\Admin\TreatmentsRepository;
use App\Repositories\Admin\ClinicRepository;

use Illuminate\Support\Facades\Hash;

class TreatmentsController extends Controller
{
    private $treatmentsRepository;
    private $appointmentsRepository;
    private $clinicRepository;
    private $packageRepository;
    private $fileAttachmentsRepository;
    private $userRepository;

    public function __construct(TreatmentsRepository $treatmentsRepository,
                                AppointmentsRepository $appointmentsRepository,
                                ClinicRepository $clinicRepository,
                                PackageRepository $packageRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                UserRepository $userRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->treatmentsRepository = $treatmentsRepository;
        $this->appointmentsRepository = $appointmentsRepository;
        $this->clinicRepository = $clinicRepository;
        $this->packageRepository = $packageRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->userRepository = $userRepository;

        $this->data['currentAdminMenu'] = 'treatments';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->data['treatments'] = $this->treatmentsRepository->findAll();
        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['filter'] = $params;
        $this->data['treatments'] = $this->treatmentsRepository->findAll($options);

        $this->data['regions_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];

        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Operator' => 'operator',
        ];
        $this->data['region_'] = !empty($params['region']) ? $params['region'] : '';
        $this->data['role_'] = !empty($params['role']) ? $params['role'] : '';

        if(isset($_GET['region'])) {
            $region = $params['region'];
        }else{
            $region = !empty($params['region']) ? $params['region'] : '';
        }


        $this->data['follow_up_completed_list'] = $this->treatmentsRepository->get_follow_up_complete_list($region);
        $this->data['package_ready_list'] = $this->treatmentsRepository->get_package_ready_list($region);
        $this->data['package_ordered_list'] = $this->treatmentsRepository->get_package_ordered_list($region);
        $this->data['package_shipped_list'] = $this->treatmentsRepository->get_package_shipped_list($region);

        return view('admin.treatments.jira_treatments', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];

        $this->data['roleId'] = null;
        $this->data['access_level'] = null;
        $this->data['team'] = null;
        $this->data['region'] = null;
        $this->data['user_brand'] = null;

        return view('admin.treatments.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($this->treatmentsRepository->create($request->all())) {
            return redirect('admin/treatments')
                ->with('success', 'Success to create new treatments');
        }

        return redirect('admin/treatments/create')
            ->with('error', 'Fail to create new treatments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = $this->userRepository->findById($id);

        return view('admin.users.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $treatment = $this->treatmentsRepository->findById($id);

        $this->data['treatment'] = $treatment;
        $this->data['appointment'] = $this->appointmentsRepository->findById($treatment->appointment_id);

        $user_id = $treatment->user_id;
        $this->data['user'] = $user = $this->userRepository->findById($user_id);
        $this->data['gender'] = $user->gender;
        $this->data['yob'] = $user->yob;
        $this->data['email'] = $user->email;

        $this->data['package'] = $treatment->package_id;

        if($this->data['package']) {
            $this->data['package_obj'] = $this->packageRepository->findById($treatment->package_id);
        }else{
            $this->data['package_obj'] = null;
        }
        $clinic_id = $treatment->clinic_id;
        $this->data['clinic'] = $this->clinicRepository->findById($clinic_id);
        $this->data['ship_to_office'] = $treatment->ship_to_office;

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];

        $this->data['genders_'] = [
            'M' => 'M',
            'F' => 'F',
        ];

        $this->data['packages'] = $this->packageRepository->findAll();

        return view('admin.treatments.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $treatment = $this->treatmentsRepository->findById($id);
        $param = $request->request->all();

        $user_id = $treatment->user_id;
        $user_param['gender'] = $param['user_gender'];
        $user_param['yob'] = $param['user_yob'];
        $this->userRepository->update($user_id, $user_param);

        $treatment_param['ship_to_office'] = $param['ship_to_office'];
        if(isset($param['package'])) {
            $treatment_param['package_id'] = $param['package'];
            $treatment_param['status'] = 'package_option_ready';
        }
        $treatment_param['updated_at'] = Carbon::now();

        if ($this->treatmentsRepository->update($id, $treatment_param)) {
            return redirect('admin/treatments/'.$id.'/edit')
                ->with('success', 'Success update.');
        }

        return redirect('admin/treatments/'.$id.'/edit')
                ->with('error','Fail update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treatments = $this->treatmentsRepository->findById($id);

        if ($this->treatmentsRepository->delete($id)) {
            return redirect('admin/treatments_list')
                ->with('success', __('users.success_deleted_message', ['name' => $treatments->name]));
        }
        return redirect('admin/treatments_list')
                ->with('error', __('users.fail_to_delete_message', ['name' => $treatments->name]));
    }

    public function package_order(Request $request)
    {
        try{
            $param = $request->all();

            $treatment_id = $param['id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);

            $user_id = $treatment_obj->user_id;

            $user_obj = $this->userRepository->findById($user_id);
            $user_device_token = $user_obj->device_token;

            $package_id = $treatment_obj->package_id;
            $package_obj = $this->packageRepository->findById($package_id);

            if(!$user_device_token){
                return "Device token not found";
            }

            // send push notification
            $url = "https://us-central1-denti-find.cloudfunctions.net/sendFCM";
            $header = [
                'content-type: application/json'
            ];

            $postdata = '{
                "token":  "'.$user_device_token.'",
                "notification": {
                    "title": "Your package request has been sent",
                    "body": "'.$package_obj->name.'"
                },
                "data": {
                    "notification_type": "package_ordered",
                    "appointment_id": "'.$treatment_obj->appointment_id.'",
                    "treatment_id": "'.$treatment_obj->id.'",
                    "user_id": "'.$treatment_obj->user_id.'",
                    "clinic_id": "'.$treatment_obj->clinic_id.'",
                    "package_id": "'.$treatment_obj->package_id.'",
                    "created_at" : "'.Carbon::now().'"
                }
            }';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $result = curl_exec($ch);
            curl_close($ch);

            $param_treatment['status'] = 'package_ordered';
            $param_treatment['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $param_treatment);

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $user_obj->id;
            $notification['user_first_name']    = $user_obj->first_name;
            $notification['user_last_name']     = $user_obj->last_name;
            $notification['user_email']         = $user_obj->email;
            $notification['appointment_id']     = $treatment_obj->appointment_id;
            $notification['treatment_id']       = $treatment_id;
            $notification['type']               = 'package_ordered';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = $package_obj->name;
            $notification->save();

            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function package_ship(Request $request)
    {
        try{
            $param = $request->all();

            $treatment_id = $param['id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);

            $user_id = $treatment_obj->user_id;

            $user_obj = $this->userRepository->findById($user_id);
            $user_device_token = $user_obj->device_token;

            $package_id = $treatment_obj->package_id;
            $package_obj = $this->packageRepository->findById($package_id);

            if(!$user_device_token){
                return "Device token not found";
            }

            // send push notification
            $url = "https://us-central1-denti-find.cloudfunctions.net/sendFCM";
            $header = [
                'content-type: application/json'
            ];

            $postdata = '{
                "token":  "'.$user_device_token.'",
                "notification": {
                    "title": "Your package request has been sent",
                    "body": "'.$package_obj->name.'"
                },
                "data": {
                    "notification_type": "package_shipped",
                    "appointment_id": "'.$treatment_obj->appointment_id.'",
                    "treatment_id": "'.$treatment_obj->id.'",
                    "user_id": "'.$treatment_obj->user_id.'",
                    "clinic_id": "'.$treatment_obj->clinic_id.'",
                    "package_id": "'.$treatment_obj->package_id.'",
                    "created_at" : "'.Carbon::now().'"
                }
            }';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $result = curl_exec($ch);
            curl_close($ch);

            $param_treatment['status'] = 'package_shipped';
            $param_treatment['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $param_treatment);

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $user_obj->id;
            $notification['user_first_name']    = $user_obj->first_name;
            $notification['user_last_name']     = $user_obj->last_name;
            $notification['user_email']         = $user_obj->email;
            $notification['appointment_id']     = $treatment_obj->appointment_id;
            $notification['treatment_id']       = $treatment_id;
            $notification['type']               = 'package_shipped';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = $package_obj->name;
            $notification->save();

            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
