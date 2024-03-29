<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\Notification;
use App\Models\Record;
use App\Models\User;
use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\FileAttachmentsRepository;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\PackageRepository;
use App\Repositories\Admin\RecordRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Faker\Core\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Repositories\Admin\TreatmentsRepository;
use App\Repositories\Admin\ClinicRepository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TreatmentsController extends Controller
{
    private $treatmentsRepository;
    private $appointmentsRepository;
    private $clinicRepository;
    private $packageRepository;
    private $notificationRepository;
    private $recordRepository;
    private $fileAttachmentsRepository;
    private $userRepository;

    public function __construct(TreatmentsRepository $treatmentsRepository,
                                AppointmentsRepository $appointmentsRepository,
                                ClinicRepository $clinicRepository,
                                PackageRepository $packageRepository,
                                NotificationRepository $notificationRepository,
                                RecordRepository $recordRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                UserRepository $userRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->treatmentsRepository = $treatmentsRepository;
        $this->appointmentsRepository = $appointmentsRepository;
        $this->clinicRepository = $clinicRepository;
        $this->packageRepository = $packageRepository;
        $this->notificationRepository = $notificationRepository;
        $this->recordRepository = $recordRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->userRepository = $userRepository;


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->data['treatments'] = $this->treatmentsRepository->findAll();

        $this->data['currentAdminMenu'] = 'treatments';
        $param = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $param,
        ];

        $this->data['filter'] = $param;

        $this->data['clinics'] = $this->clinicRepository->findAll();
        $clinic_id = auth()->user()->clinic_id;

        if($clinic_id == null){  // if Admin....
            if(isset($_GET['clinic_id'])) {
                $clinic_id = $param['clinic_id'];
            }else{
                $clinic_id = !empty($param['clinic_id']) ? $param['clinic_id'] : '';
            }
        }else{  // if Doctor....
            $clinic_id = $clinic_id;
        }

        $this->data['clinic_'] = $clinic_id;
        $this->data['treatments'] = $this->treatmentsRepository->get_treatment_list($clinic_id);

        return view('admin.treatments.index', $this->data);
    }

    public function patient_jira(Request $request)
    {
        $this->data['currentAdminMenu'] = 'patient_jira';

        $param = $request->all();

        $clinic_id = auth()->user()->clinic_id;

        if($clinic_id == null){ // if Admin....
            if(isset($_GET['clinic'])) {
                $clinic = $param['clinic'];
            }else{
                $clinic = !empty($param['clinic']) ? $param['clinic'] : '';
            }
        }else{ // if Clinic Doctor,,
            $clinic = $clinic_id;
        }

        $this->data['clinic'] = $clinic;
        $this->data['clinics'] = $this->clinicRepository->findAll();

        $this->data['follow_up_list'] = $this->appointmentsRepository->get_follow_up_list_by_filter($clinic);
        $this->data['package_ready_list'] = $this->appointmentsRepository->get_package_ready_list_by_filter($clinic);
        $this->data['package_ordered_list'] = $this->appointmentsRepository->get_package_ordered_list_by_filter($clinic);
        $this->data['visit_confirm_list'] = $this->appointmentsRepository->get_visit_confirm_list_by_filter($clinic);
        $this->data['treatment_complete_list'] = null;
        $this->data['user_pending_list'] = $this->appointmentsRepository->get_user_pending_list_list_by_filter($clinic);

        return view('admin.patient.jira_patient', $this->data);
    }

    public function package_jira(Request $request)
    {
//        $this->data['treatments'] = $this->treatmentsRepository->findAll();
        $this->data['currentAdminMenu'] = 'package_jira';

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
            'China'
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
        $this->data['location_sent_list'] = $this->treatmentsRepository->get_location_sent_list($region);
        $this->data['location_confirmed_list'] = $this->treatmentsRepository->get_location_confirmed_list($region);
        $this->data['package_shipped_list'] = $this->treatmentsRepository->get_package_shipped_list($region);
        $this->data['package_delivered_list'] = $this->treatmentsRepository->get_package_delivered_list($region);

        return view('admin.treatments.jira_package', $this->data);
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
            'China'
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
        $treatment_obj = $this->treatmentsRepository->findById($id);

        $this->data['treatment'] = $treatment_obj;
        $this->data['appointment'] = $this->appointmentsRepository->findById($treatment_obj->appointment_id);

        $user_id = $treatment_obj->user_id;
        $this->data['user'] = $user = $this->userRepository->findById($user_id);
        $this->data['gender'] = $user->gender;
        $this->data['yob'] = $user->yob;
        $this->data['email'] = $user->email;

        $this->data['package'] = $treatment_obj->package_id;
        $this->data['session'] = $total = $treatment_obj->session;
        $this->data['month'] = $treatment_obj->month;

        $this->data['current_session'] = $sessions = $this->appointmentsRepository->get_current_session($id);
        $first_session = $this->appointmentsRepository->get_first_session($id);
        $first_session_date = date("Y-m-d");
        if($first_session){
            $first_session_date = $first_session->booked_date;
        }
        $this->data['last_session_status'] = $this->appointmentsRepository->get_last_treatment_session_status($id);
        $month_rule = [
            1 => '0 Month',
            2 => '1 Month',
            3 => '3 Month',
            4 => '6 Month',
            5 => '9 Month',
            6 => '12 Month',
            7 => '15 Month',
            8 => '18 Month',
            9 => '21 Month',
            10 => '24 Month',
            11 => '27 Month',
            12 => '30 Month',
            13 => '33 Month',
            14 => '36 Month',
        ];

        $session_list = array();

        for($i=1; $i<=$total; $i++) {
            if(isset($sessions[$i - 1])) {
                if($sessions[$i - 1]->status == 'first_session_booked'){
                    $status = 'Upcoming';
                }else if($sessions[$i - 1]->status == 'session_booked'){
                    $status = 'Upcoming';
                }else if($sessions[$i - 1]->status == 'session_completed'){
                    $status = 'Completed';
                }else if($sessions[$i - 1]->status == 'visit_confirming'){
                    $status = 'Visit Confirming';
                }

                $session_list[] = [
                    'num' => $i,
                    'appointment_id' => $sessions[$i - 1]->id,
                    'session' => 'SESSION '.$i,
                    'booked_start' => date('M j', strtotime($sessions[$i - 1]->booked_start)),
                    'rec_date' => date('M j', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                    'clinic' => $sessions[$i - 1]->clinic_name,
                    'status' => $status
                ];
            }else{
                $session_list[] = [
                    'num' => $i,
                    'appointment_id' => null,
                    'session' => 'SESSION '.$i,
                    'booked_start' => 'TBD',
                    'rec_date' => date('M j', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                    'clinic' => 'TBD',
                    'status' => 'Not Scheduled'
                ];
            }
        }

        $this->data['session_list'] = $session_list;

        if($this->data['package']) {
            $this->data['package_obj'] = $this->packageRepository->findById($treatment_obj->package_id);
        }else{
            $this->data['package_obj'] = null;
        }

        $clinic_id = $treatment_obj->clinic_id;
        $this->data['clinic'] = $this->clinicRepository->findById($clinic_id);
        $this->data['ship_to_office'] = $treatment_obj->ship_to_office;

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
            'China'
        ];

        $this->data['genders_'] = [
            'M' => 'M',
            'F' => 'F',
        ];

        $this->data['packages'] = $this->packageRepository->findAll();

        $this->data['sessions'] = [
            5 => '9',
            6 => '12',
            7 => '15',
            8 => '18',
            9 => '21',
            10 => '24',
            11 => '27',
            12 => '30',
            13 => '33',
            14 => '36'
        ];

        // Campaign_notes
        $options = [
            'id' => $id,
            'order' => [
                'created_at' => 'desc',
            ]
        ];
        $this->data['record'] = $this->recordRepository->findAll($options);
        return view('admin.treatments.form', $this->data);
    }

    public function get_treatment_progress_by_user_id(Request $request)
    {
        $param = $request->all();
        $user_id = $param['user_id'];

        $treatment_obj = $this->treatmentsRepository->get_treatment_status_by_user_id($user_id);
        $treatment_id = $treatment_obj->id;
        $total = $treatment_obj->session;
        $this->data['current_session'] = $sessions = $this->appointmentsRepository->get_current_session($treatment_id);

        if($sessions) {
            $first_session = $this->appointmentsRepository->get_first_session($treatment_id);
            $first_session_date = date("Y-m-d");
            if($first_session){
                $first_session_date = $first_session->booked_date;
            }
            Log::info($treatment_id . " - " . $first_session_date);

            $this->data['last_session_status'] = $this->appointmentsRepository->get_last_treatment_session_status($treatment_id);

            $month_rule = [
                1 => '0 Month',
                2 => '1 Month',
                3 => '3 Month',
                4 => '6 Month',
                5 => '9 Month',
                6 => '12 Month',
                7 => '15 Month',
                8 => '18 Month',
                9 => '21 Month',
                10 => '24 Month',
                11 => '27 Month',
                12 => '30 Month',
                13 => '33 Month',
                14 => '36 Month',
            ];

            $session_list = array();

            for ($i = 1; $i <= $total; $i++) {
                if (isset($sessions[$i - 1])) {
                    if ($sessions[$i - 1]->status == 'first_session_booked') {
                        $status = 'Upcoming';
                    } elseif ($sessions[$i - 1]->status == 'session_booked') {
                        $status = 'Upcoming';
                    } elseif ($sessions[$i - 1]->status == 'visit_confirming') {
                        $status = 'Visit Confirming';
                    } elseif ($sessions[$i - 1]->status == 'session_completed') {
                        $status = 'Completed';
                    }

                    $session_list[] = [
                        'appointment_id' => $sessions[$i - 1]->id,
                        'session' => 'SESSION ' . $i,
                        'booked_start' => date('M j', strtotime($sessions[$i - 1]->booked_start)),
                        'rec_date' => date('M j', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                        'status' => $status
                    ];
                } else {
                    $session_list[] = [
                        'appointment_id' => null,
                        'session' => 'SESSION ' . $i,
                        'booked_start' => 'TBD',
                        'rec_date' => date('M j', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                        'status' => 'Not Scheduled'
                    ];
                }
            }

            $data = [
                'data' => [
                    'treatment_list' => $session_list
                ]
            ];
        }else{
            $data = [
                'error' => [
                    'message' => "There is no treatment data."
                ]
            ];
        }

        return response()->json($data);

    }

    public function get_treatment_progress(Request $request)
    {
        $param = $request->all();
        $treatment_id = $param['treatment_id'];
        $treatment_obj = $this->treatmentsRepository->findById($treatment_id);

        $total = $treatment_obj->session;
        $this->data['current_session'] = $sessions = $this->appointmentsRepository->get_current_session($treatment_id);
        $this->data['last_session_status'] = $this->appointmentsRepository->get_last_treatment_session_status($treatment_id);
        $month_rule = [
            1 => 'TBD',
            2 => '1 Month',
            3 => '3 Month',
            4 => '6 Month',
            5 => '9 Month',
            6 => '12 Month',
            7 => '15 Month',
            8 => '18 Month',
            9 => '21 Month',
            10 => '24 Month',
            11 => '27 Month',
            12 => '30 Month',
            13 => '33 Month',
            14 => '36 Month',
        ];

        $session_list = array();

        for($i=1; $i<=$total; $i++) {
            if(isset($sessions[$i - 1])) {
                if($sessions[$i - 1]->status == 'first_session_booked'){
                    $status = 'Upcoming';
                }elseif ($sessions[$i - 1]->status == 'session_booked'){
                    $status = 'Upcoming';
                }elseif($sessions[$i - 1]->status == 'visit_confirming'){
                    $status = 'Visit Confirming';
                }elseif($sessions[$i - 1]->status == 'session_completed'){
                    $status = 'Completed';
                }
                $session_list[] = [
                    'appointment_id' => $sessions[$i - 1]->id,
                    'session' => 'SESSION '.$i,
                    'booked_start' => date("M d, Y", strtotime($sessions[$i - 1]->booked_date)),
                    'rec_date' => date("M d, Y", strtotime($sessions[$i - 1]->booked_date)),
                    'status' => $status
                ];
            }else{
                $session_list[] = [
                    'appointment_id' => null,
                    'session' => 'SESSION '.$i,
                    'booked_start' => $month_rule[$i],
                    'status' => 'Not Scheduled'
                ];
            }
        }

        $data = [
            'data' => [
                'treatment_list' => $session_list
            ]
        ];
        return response()->json($data);

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
        $user_obj = $this->userRepository->findById($user_id);

        $user_param['gender'] = isset($param['user_gender']) ? $param['user_gender'] : '';
        $user_param['yob'] = isset($param['user_yob']) ? $param['user_yob'] : '';

        $new = array(
            'yob'       => $param['user_yob'],
            'gender'    => $param['user_gender'],
        );

        $origin = $user_obj->toArray();
        foreach ($new as $key => $value) {
            if (array_key_exists($key, $origin)) {
                if (html_entity_decode($new[$key]) != html_entity_decode($origin[$key])) {
                    $changed[$key]['new'] = $new[$key];
                    $changed[$key]['original'] = $origin[$key];
                }
            }
        }
        if(!empty($changed)){
            $change_line  = "<p>Admin made a change to a patient</p>";
            foreach ($changed as $label => $change) {
                $label = ucwords(str_replace('_', ' ', $label));
                $from  = trim($change['original']); // Remove strip tags
                $to    = trim($change['new']);      // Remove strip tags
                $change_line .= "<div class='change_label'><p>$label:</p></div>"
                    . "<div class='change_to'><p>$to</p></div>"
                    . "<div class='change_from'><del><p>$from</p></del></div>";
            }
            $record = new Record();
            $record['type'] = 'follow_up_completed';
            $record['appointment_id'] = $treatment->appointment_id;
            $record['treatment_id'] = $treatment->id;
            $record['user_id'] = $treatment->user_id;
            $record['note'] = $change_line;
            $record['created_at'] = Carbon::now();
            $record->save();
        }

        $this->userRepository->update($user_id, $user_param);

        if(isset($param['package'])) {
            $treatment_param['package_id'] = $param['package'];
            $temp = explode('-', $param['session']);
            $treatment_param['session'] = $temp[0];
            $treatment_param['month'] = $temp[1];
            $treatment_param['status'] = 'package_ready';

            $record = new Record();
            $record['type'] = 'package_ready';
            $record['appointment_id'] = $treatment->appointment_id;
            $record['treatment_id'] = $treatment->id;
            $record['user_id'] = $treatment->user_id;
            $record['note'] = "<p>The package selection has been completed.</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'package_ready';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($user_id, $u_params);

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
            $notification['clinic_id']          = $treatment_obj->clinic_id;
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'package_ordered';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = "Estimated treatment duration " . $treatment_obj->month . " months" ;
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'package_ordered';
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>The package order has been successfully completed.</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'package_ordered';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($user_id, $u_params);

            if(!$user_device_token){
                Log::info('package_ordered (No device token - '.$user_obj->email.')');
                return "No device token";
            }else {
                Log::info('package_ordered (Device token exist - '.$user_obj->email.')');
                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "' . $user_device_token . '",
                "notification": {
                    "title": "reemarc",
                    "body": "reemarc doctors have chosen a treatment package for you"
                },
                "data": {
                    "notification_type": "package_ordered",
                    "id": "' . $notification->id . '",
                    "user_id": "' . $notification['user_id'] . '",
                    "appointment_id": "' . $notification['appointment_id'] . '",
                    "treatment_id": "' . $notification['treatment_id'] . '",
                    "appointment_status": "complete",
                    "treatment_status": "package_ordered",
                    "clinic_id": "' . $notification['clinic_id'] . '",
                    "package_id": "' . $notification['package_id'] . '",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "' . $notification['note'] . '",
                    "created_at" : "' . Carbon::now() . '"
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

                return $result;
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function location_send(Request $request)
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

            $param_treatment['status'] = 'location_sent';
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
            $notification['clinic_id']          = $treatment_obj->clinic_id;
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'location_sent';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = "Your package has arrived reemarc. Please confirm your treatment location.";
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'location_sent';
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>The notification has been successfully sent.</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'location_sent';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($user_id, $u_params);

            if(!$user_device_token){
                Log::info('location_send (No device token - '.$user_obj->email.')');
                return "No device token";
            }else{
                Log::info('location_send (Device token exist - '.$user_obj->email.')');
                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                    "token":  "' . $user_device_token . '",
                    "notification": {
                        "title": "reemarc",
                        "body": "Your package has arrived reemarc. Please confirm your treatment location."
                    },
                    "data": {
                        "notification_type": "location_sent",
                        "id": "' . $notification->id . '",
                        "user_id": "' . $notification['user_id'] . '",
                        "appointment_id": "' . $notification['appointment_id'] . '",
                        "treatment_id": "' . $notification['treatment_id'] . '",
                        "appointment_status": "complete",
                        "treatment_status": "location_sent",
                        "clinic_id": "' . $notification['clinic_id'] . '",
                        "package_id": "' . $notification['package_id'] . '",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "' . $notification['note'] . '",
                        "created_at" : "' . Carbon::now() . '"
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

                return $result;
            }

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

            $param_treatment['status'] = 'package_shipped';
            $param_treatment['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $param_treatment);

            // Add Notification
//            $notification = new Notification();
//            $notification['user_id']            = $user_obj->id;
//            $notification['user_first_name']    = $user_obj->first_name;
//            $notification['user_last_name']     = $user_obj->last_name;
//            $notification['user_email']         = $user_obj->email;
//            $notification['appointment_id']     = $treatment_obj->appointment_id;
//            $notification['treatment_id']       = $treatment_id;
//            $notification['type']               = 'package_shipped';
//            $notification['is_read']            = 'no';
//            $notification['is_delete']          = 'no';
//            $notification['created_at']         = Carbon::now();
//            $notification['note']               = 'The package shipped to ' . $treatment_obj->ship_to_office;
//            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'package_shipped';
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>The package has been successfully shipped. </p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'package_shipped';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($user_id, $u_params);

            return "success";

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function package_delivery(Request $request)
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

            $param_treatment['status'] = 'package_delivered';
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
            $notification['clinic_id']          = $treatment_obj->clinic_id;
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'package_delivered';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = "To receive a treatment, Please make an appointment with reemarc";
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'package_delivered';
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>This package has been successfully delivered.</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'package_delivered';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($user_id, $u_params);

            if(!$user_device_token){
                Log::info('package_ordered (No device token - '.$user_obj->email.')');
                return "No device token";
            }else{
                Log::info('package_ordered (Device token exist - '.$user_obj->email.')');
                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "' . $user_device_token . '",
                "notification": {
                    "title": "reemarc",
                    "body": "You are all set to receive a treatment and package."
                },
                "data": {
                    "notification_type": "package_delivered",
                    "id": "' . $notification->id . '",
                    "user_id": "' . $notification['user_id'] . '",
                    "appointment_id": "' . $notification['appointment_id'] . '",
                    "treatment_id": "' . $notification['treatment_id'] . '",
                    "appointment_status": "complete",
                    "treatment_status": "package_delivered",
                    "clinic_id": "' . $notification['clinic_id'] . '",
                    "package_id": "' . $notification['package_id'] . '",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "' . $notification['note'] . '",
                    "created_at" : "' . Carbon::now() . '"
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

                return $result;
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function visit_confirm(Request $request)
    {
        try{
            $param = $request->all();
            $treatment_id = $param['id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
            $user_id = $treatment_obj->user_id;
            $aptmt_rs =$this->appointmentsRepository->get_last_treatment_upcoming_appointment($treatment_id);
            $user_obj = $this->userRepository->findById($user_id);
            $user_device_token = $user_obj->device_token;

//            if(!$user_device_token){
//                return "Device token not found";
//            }

            // Update appointment status to visit_confirming
            $param_appointment['status'] = 'visit_confirming';
            $param_appointment['updated_at'] = Carbon::now();
            $this->appointmentsRepository->update($aptmt_rs['id'], $param_appointment);

            $clinic_obj = $this->clinicRepository->findById($aptmt_rs['clinic_id']);
            $clinic_name = $clinic_obj->name;
            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $aptmt_rs['booked_start']);
            $start_format = $start->format('F j');

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $user_obj->id;
            $notification['user_first_name']    = $user_obj->first_name;
            $notification['user_last_name']     = $user_obj->last_name;
            $notification['user_email']         = $user_obj->email;
            $notification['appointment_id']     = $aptmt_rs['id'];
            $notification['treatment_id']       = $treatment_id;
            $notification['clinic_id']          = $aptmt_rs['clinic_id'];
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'visit_confirm';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = $clinic_name . " " . $aptmt_rs['booked_time'] . ", " . $start_format;
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'visit_confirming';
            $record['appointment_id'] = $aptmt_rs['id'];
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>The notification has been successfully sent.</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['appointment_status'] = 'visit_confirming';
            $u_params['treatment_status'] = 'visit_confirming';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($treatment_obj->user_id, $u_params);

            $t_params['status'] = 'visit_confirming';
            $t_params['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $t_params);

            return 'success';

            // send push notification
//            $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
//            $header = [
//                'content-type: application/json'
//            ];
//
//            $postdata = '{
//                "token":  "'.$user_device_token.'",
//                "notification": {
//                    "title": "reemarc",
//                    "body": "Please confirm your visit at '.$clinic_name.' at ' .$aptmt_rs['booked_time']. ' on ' . $start_format.'"
//                },
//                "data": {
//                    "notification_type": "visit_confirm",
//                    "id": "'.$notification->id.'",
//                    "user_id": "'.$notification['user_id'].'",
//                    "appointment_id": "'.$notification['appointment_id'].'",
//                    "treatment_id": "'.$notification['treatment_id'].'",
//                    "appointment_status": "visit_confirming",
//                    "treatment_status": "visit_confirming",
//                    "clinic_id": "'.$notification['clinic_id'].'",
//                    "package_id": "'.$notification['package_id'].'",
//                    "is_read": "no",
//                    "is_delete": "no",
//                    "note": "'.$notification['note'].'",
//                    "created_at" : "'.Carbon::now().'"
//                }
//            }';
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//
//            $result = curl_exec($ch);
//            curl_close($ch);
//
//            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function to_visit_confirmed(Request $request)
    {
        try{
            $param = $request->all();
            $treatment_id = $param['id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
            $aptmt_rs =$this->appointmentsRepository->get_last_treatment_visit_confirming_appointment($treatment_id);
            $user_id = $treatment_obj->user_id;
            $user_obj = $this->userRepository->findById($user_id);
            $user_device_token = $user_obj->device_token;

            // Update appointment status to visit_confirming
            $param_appointment['status'] = 'session_completed';
            $param_appointment['updated_at'] = Carbon::now();
            $this->appointmentsRepository->update($aptmt_rs['id'], $param_appointment);

            $clinic_obj = $this->clinicRepository->findById($aptmt_rs['clinic_id']);
            $clinic_name = $clinic_obj->name;
            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $aptmt_rs['booked_start']);
            $start_format = $start->format('F j');

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $user_obj->id;
            $notification['user_first_name']    = $user_obj->first_name;
            $notification['user_last_name']     = $user_obj->last_name;
            $notification['user_email']         = $user_obj->email;
            $notification['appointment_id']     = $aptmt_rs['id'];
            $notification['treatment_id']       = $treatment_id;
            $notification['clinic_id']          = $aptmt_rs['clinic_id'];
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'visit_confirm';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = 'Confirmed your visit';
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'session_completed';
            $record['appointment_id'] = $aptmt_rs['id'];
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = '<p>Patient visit has been confirmed.</p><br/>'.$clinic_name . " " . $aptmt_rs["booked_time"] . ", " . $start_format;
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on user table
            $u_params['treatment_status'] = 'session_completed';
            $u_params['appointment_status'] = 'session_completed';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($treatment_obj->user_id, $u_params);

            $t_params['status'] = 'session_completed';
            $t_params['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $t_params);

            if(!$user_device_token){
                Log::info('session_completed (No device token - '.$user_obj->email.')');
                return "No device token";
            }else{
                Log::info('session_completed (Device token exist - '.$user_obj->email.')');
                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "' . $user_device_token . '",
                "notification": {
                    "title": "reemarc",
                    "body": "Confirmed your visit"
                },
                "data": {
                    "notification_type": "visit_confirm",
                    "id": "' . $notification->id . '",
                    "user_id": "' . $notification['user_id'] . '",
                    "appointment_id": "' . $notification['appointment_id'] . '",
                    "treatment_id": "' . $notification['treatment_id'] . '",
                    "appointment_status": "visit_confirming",
                    "treatment_status": "visit_confirming",
                    "clinic_id": "' . $notification['clinic_id'] . '",
                    "package_id": "' . $notification['package_id'] . '",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "' . $notification['note'] . '",
                    "created_at" : "' . Carbon::now() . '"
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

                return $result;
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function no_show(Request $request)
    {
        try{
            $param = $request->all();
            $treatment_id = $param['id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
            $aptmt_rs =$this->appointmentsRepository->get_last_treatment_visit_confirming_appointment($treatment_id);
            $user_id = $treatment_obj->user_id;
            $user_obj = $this->userRepository->findById($user_id);
            $user_device_token = $user_obj->device_token;

            // Update appointment status to No Show
            $param_appointment['status'] = 'cancel';
            $param_appointment['no_show'] = 'y';
            $param_appointment['updated_at'] = Carbon::now();
            $this->appointmentsRepository->update($aptmt_rs['id'], $param_appointment);

            $clinic_obj = $this->clinicRepository->findById($aptmt_rs['clinic_id']);
            $clinic_name = $clinic_obj->name;
            $start = \DateTime::createFromFormat('Y-m-d H:i:s', $aptmt_rs['booked_start']);
            $start_format = $start->format('F j');

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $user_obj->id;
            $notification['user_first_name']    = $user_obj->first_name;
            $notification['user_last_name']     = $user_obj->last_name;
            $notification['user_email']         = $user_obj->email;
            $notification['appointment_id']     = $aptmt_rs['id'];
            $notification['treatment_id']       = $treatment_id;
            $notification['clinic_id']          = $aptmt_rs['clinic_id'];
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'visit_confirm';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['no_show']            = 'yes';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = 'Missed your visit';
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'session_missed';
            $record['appointment_id'] = $aptmt_rs['id'];
            $record['treatment_id'] = $treatment_id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = '<p>Patient No Show.</p><br/>'.$clinic_name . " " . $aptmt_rs["booked_time"] . ", " . $start_format;
            $record['created_at'] = Carbon::now();
            $record->save();

            // if session_completed exist,,, it should be 2nd, 3rd session..
            $is_first_session = $this->appointmentsRepository->check_first_session($treatment_obj->user_id);

            if(!$is_first_session){ // if first_session
                $t_status = 'package_delivered';
            }else{ // if 2,3 session...
                $t_status = 'session_completed';
            }

            // Update status on user table
            $u_params['treatment_status'] = $t_status;
            $u_params['appointment_status'] = 'cancel';
            $u_params['updated_at'] = Carbon::now();
            $this->userRepository->update($treatment_obj->user_id, $u_params);

            $t_params['status'] = $t_status;
            $t_params['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_id, $t_params);

            if(!$user_device_token){
                return "No device token";
            }else {
                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "' . $user_device_token . '",
                "notification": {
                    "title": "reemarc",
                    "body": "Missed your visit"
                },
                "data": {
                    "notification_type": "visit_confirm",
                    "id": "' . $notification->id . '",
                    "user_id": "' . $notification['user_id'] . '",
                    "appointment_id": "' . $notification['appointment_id'] . '",
                    "treatment_id": "' . $notification['treatment_id'] . '",
                    "appointment_status": "visit_confirming",
                    "treatment_status": "visit_confirming",
                    "clinic_id": "' . $notification['clinic_id'] . '",
                    "package_id": "' . $notification['package_id'] . '",
                    "is_read": "no",
                    "is_delete": "no",
                    "no_show": "yes",
                    "note": "' . $notification['note'] . '",
                    "created_at" : "' . Carbon::now() . '"
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

                return $result;
            }


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
