<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\Notification;
use App\Models\Record;
use App\Models\Treatments;
use App\Models\User;
use App\Repositories\Admin\FileAttachmentsRepository;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\TreatmentsRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\ClinicRepository;

use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    private $appointmentsRepository;
    private $treatmentsRepository;
    private $clinicRepository;
    private $notificationRepository;
    private $fileAttachmentsRepository;
    private $userRepository;

    public function __construct(AppointmentsRepository $appointmentsRepository,
                                TreatmentsRepository $treatmentsRepository,
                                ClinicRepository $clinicRepository,
                                NotificationRepository $notificationRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                UserRepository $userRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->appointmentsRepository = $appointmentsRepository;
        $this->treatmentsRepository = $treatmentsRepository;
        $this->clinicRepository = $clinicRepository;
        $this->notificationRepository = $notificationRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->userRepository = $userRepository;

        $this->data['currentAdminMenu'] = 'appointments_list';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->data['appointments'] = $this->appointmentsRepository->findAll();
        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['filter'] = $params;
        $this->data['appointments'] = $this->appointmentsRepository->findAll($options);
        $this->data['teams_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];

        $this->data['statuss_'] = [
            'Upcoming',
            'Complete',
            'Cancel'
        ];

        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Operator' => 'operator',
        ];
        $this->data['region_'] = !empty($params['region']) ? $params['region'] : '';
        $this->data['role_'] = !empty($params['role']) ? $params['role'] : '';
        $this->data['status_'] = !empty($params['status']) ? $params['status'] : '';

        return view('admin.appointments.index', $this->data);
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

        return view('admin.appointments.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($this->appointmentsRepository->create($request->all())) {
            return redirect('admin/appointments')
                ->with('success', 'Success to create new appointments');
        }

        return redirect('admin/appointments/create')
            ->with('error', 'Fail to create new appointments');
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
        $appointments = $this->appointmentsRepository->findById($id);

        $this->data['appointments'] = $appointments;
        $this->data['user_id'] = $appointments->user_id;
        $this->data['user_first_name'] = $appointments->user_first_name;
        $this->data['user_last_name'] = $appointments->user_last_name;
        $this->data['user_email'] = $appointments->user_email;
        $this->data['user_phone'] = $appointments->user_phone;
        $this->data['clinic_id'] = $appointments->clinic_id;
        $this->data['clinic_name'] = $appointments->clinic_name;
        $this->data['clinic_phone'] = $appointments->clinic_phone;
        $this->data['clinic_address'] = $appointments->clinic_address;
        $this->data['clinic_region'] = $appointments->clinic_region;
        $this->data['booked_date'] = $appointments->booked_date;
        $this->data['booked_start'] = $appointments->booked_start;
        $this->data['booked_end'] = $appointments->booked_end;
        $this->data['booked_day'] = $appointments->booked_day;
        $this->data['booked_time'] = $appointments->booked_time;
        $this->data['status'] = $appointments->status;
        $this->data['created_at'] = $appointments->created_at;

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];

        $this->data['status_'] = [
            'Upcoming',
            'Complete',
            'Cancel'
        ];

        return view('admin.appointments.form', $this->data);
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
        $appointments = $this->appointmentsRepository->findById($id);
        $param = $request->request->all();

        if ($this->appointmentsRepository->update($id, $param)) {
            return redirect('admin/appointments_list')
                ->with('success', __('users.success_updated_message', ['name' => $appointments->name]));
        }

        return redirect('admin/appointments_list')
                ->with('error', __('users.fail_to_update_message', ['name' => $appointments->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointments = $this->appointmentsRepository->findById($id);

        if ($this->appointmentsRepository->delete($id)) {
            return redirect('admin/appointments_list')
                ->with('success', __('users.success_deleted_message', ['name' => $appointments->name]));
        }
        return redirect('admin/appointments_list')
                ->with('error', __('users.fail_to_delete_message', ['name' => $appointments->name]));
    }


    public function clinic_list(Request $request)
    {

        $this->data['currentAdminMenu'] = 'appointment_make';

        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['filter'] = $params;
        $this->data['clinics'] = $clinic_list = $this->clinicRepository->findAll($options);

        if(sizeof($clinic_list)>0){
            foreach ($clinic_list as $k => $clinic){
                $c_id = $clinic->id;
                $appointment_detail = $this->appointmentsRepository->get_appointment_detail($c_id);
                $clinic_list[$k]->appointment = $appointment_detail;
            }
        }


        $appointments_list = $this->appointmentsRepository->get_upcoming_appointments();

        // Campaign_asset_detail
        if(sizeof($appointments_list)>0){
            foreach ($appointments_list as $k => $appointment){
                $a_id = $appointment->id;
                $appointment_detail = $this->appointmentsRepository->get_appointment_detail($a_id);
                $appointments_list[$k]->appointment = $appointment_detail;
            }
        }
        $this->data['teams_'] = [
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

        $this->data['team_'] = !empty($params['team']) ? $params['team'] : '';
        $this->data['role_'] = !empty($params['role']) ? $params['role'] : '';

        for ($i=0 ; $i < 7 ;$i++)
        {
//            $date[]=date('D, M j',strtotime("+{$i} day",time()));
            $date[]=date('Y-m-d',strtotime("+{$i} day",time()));
//            $date[]=date('Y-m-d H:i:s',strtotime("+{$i} day",time()));
        }
        $this->data['next_week_dates'] = $date;

        $this->data['time_spots'] = [
            '9:00 am' => '9:00',
            '10:00 am' => '10:00',
            '11:00 am' => '11:00',
            '12:00 pm' => '12:00',
            '1:00 pm' => '13:00',
            '2:00 pm' => '14:00',
            '3:00 pm' => '15:00',
            '4:00 pm' => '16:00',
            '5:00 pm' => '17:00'
        ];

        return view('admin.appointment_make.index', $this->data);
    }

    public function booking(Request $request)
    {
        $param = $request->all();

        $temp = explode(',', $param['date_time']);

        $start = \DateTime::createFromFormat('Y-m-d H:i', $temp[0].$temp[1]);
        $end = (\DateTime::createFromFormat("Y-m-d H:i", $temp[0].$temp[1]))->add(new \DateInterval("PT".$param['duration']."M"));
        $params['booked_start'] = $start->format('Y-m-d H:i');
        $params['booked_end'] = $end->format('Y-m-d H:i');

        $params['booked_day'] = date_format($start,'D');
        $params['booked_date'] = date_format($start,'Y-m-d');
        $params['booked_time'] = date_format($start,'g:i a');

        $params['clinic_id'] = $param['clinic_id'];
        $clinic_obj = $this->clinicRepository->findById($params['clinic_id']);
        $params['clinic_name'] = $clinic_obj->name;
        $params['clinic_phone'] = $clinic_obj->phone;
        $params['clinic_address'] = $clinic_obj->address;
        $params['clinic_region'] = $clinic_obj->region;

        $user = auth()->user();
        $params['user_id'] = $user->id;
        $params['user_first_name'] = $user->first_name;
        $params['user_last_name'] = $user->last_name;
        $params['user_email'] = $user->email;
        $params['user_phone'] = $user->phone;
        $params['status'] = 'Upcoming';
        $params['created_at'] = Carbon::now();

        $this->appointmentsRepository->create($params);

        $this->data['currentAdminMenu'] = 'appointment_make';

        return redirect('admin/appointment_make/')
            ->with('success', __('Data has been Booked.'));
    }

    public function follow_up(Request $request)
    {
        $param = $request->all();
        $this->data['currentAdminMenu'] = 'appointment_follow_up';

//        $params = $request->all();

        $this->data['filter'] = $param;

        if(isset($_GET['clinic'])) {
            $clinic = $param['clinic'];
        }else{
            $clinic = !empty($param['clinic']) ? $param['clinic'] : '';
        }
        if(isset($_GET['status'])) {
            $status = $param['status'];
        }else{
            $status = !empty($param['status']) ? $param['status'] : '';
        }
        $this->data['clinic'] = $clinic;
        $this->data['status'] = $status;
        $this->data['clinics'] = $this->clinicRepository->findAll();
        $this->data['statuss_'] = [
            'Upcoming',
            'Complete'
        ];

        $this->data['appointments'] = $this->appointmentsRepository->get_patients_list_by_filter($clinic, $status);

        return view('admin.appointment_follow_up.index', $this->data);
    }

    public function pending(Request $request)
    {


        $param = $request->all();
        $this->data['currentAdminMenu'] = 'appointment_pending';

//        $params = $request->all();

        $this->data['filter'] = $param;

        if(isset($_GET['clinic'])) {
            $clinic = $param['clinic'];
        }else{
            $clinic = !empty($param['clinic']) ? $param['clinic'] : '';
        }
//        if(isset($_GET['status'])) {
//            $status = $param['status'];
//        }else{
//            $status = !empty($param['status']) ? $param['status'] : '';
//        }

        $status = 'pending';

        $this->data['clinic'] = $clinic;
        $this->data['status'] = $status;
        $this->data['clinics'] = $this->clinicRepository->findAll();
        $this->data['statuss_'] = [
            'Upcoming',
            'Complete',
            'Cancel'
        ];

        $this->data['appointments'] = $this->appointmentsRepository->update_pending_appointment($clinic);

        return view('admin.appointment_pending.index', $this->data);
    }

    public function follow_up_complete(Request $request)
    {
        $this->data['currentAdminMenu'] = 'appointment_follow_up';

        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $params['status'] = 'complete';
        $params['updated_at'] = Carbon::now();

        if ($this->appointmentsRepository->update($appointment_id, $params)) {

            $appointment = $this->appointmentsRepository->findById($appointment_id);

            $t_params['appointment_id'] = $appointment->id;
            $t_params['user_id'] = $appointment->user_id;
            $t_params['clinic_id'] = $appointment->clinic_id;
            $t_params['status'] = 'follow_up_completed';
            $t_params['created_at'] = Carbon::now();

            $treatment_obj = $this->treatmentsRepository->create($t_params);

            $record = new Record();
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_obj->id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['type'] = 'follow_up_completed';
            $record['note'] = 'A new patient has been registered in the system.';
            $record['created_at'] = Carbon::now();
            $record->save();

            // Update status on User table
            $u_params['treatment_status'] = 'follow_up_completed';
            $u_params['appointment_status'] = 'complete';
            $u_params['treatment_id'] = $treatment_obj->id;
            $this->userRepository->update($appointment->user_id, $u_params);

        }

        $param_ap['treatment_id'] = $treatment_obj->id;
        $this->appointmentsRepository->update($appointment_id, $param_ap);



        return redirect('admin/appointment_follow_up')
            ->with('success', 'Follow Up Success!');


    }

    public function follow_up_pending(Request $request)
    {

        // Going to sending follow up email to patient!! todo
        $this->data['currentAdminMenu'] = 'appointment_follow_up';

        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $params['status'] = 'Complete';
        $params['updated_at'] = Carbon::now();

        if ($this->appointmentsRepository->update($appointment_id, $params)) {

            $appointment = $this->appointmentsRepository->findById($appointment_id);

            $t_params['appointment_id'] = $appointment->id;
            $t_params['user_id'] = $appointment->user_id;
            $t_params['clinic_id'] = $appointment->clinic_id;
            $t_params['status'] = 'follow_up_completed';
            $t_params['created_at'] = Carbon::now();

            $this->treatmentsRepository->create($t_params);

            return redirect('admin/appointment_pending')
                ->with('success', 'Follow Up Success!');
        }
    }

    public function treatment_booking(Request $request)
    {
        $param = $request->all();
        $params['user_id'] = $param['user_id'];
        $user_obj = User::where('id', $params['user_id'])->first();
        $params['user_first_name'] = $user_obj->first_name;
        $params['user_last_name'] = $user_obj->last_name;
        $params['user_email'] = $user_obj->email;
        $params['user_phone'] = $user_obj->phone;
        $user_device_token = $user_obj->device_token;

        $params['treatment_id'] = $param['treatment_id'];
        $treatment_obj = Treatments::where('id', $params['treatment_id'])->first();
        $params['clinic_id'] = $treatment_obj->clinic_id;

        $clinic_obj = Clinic::where('id', $params['clinic_id'])->first();
        $params['clinic_name'] = $clinic_obj->name;
        $params['clinic_phone'] = $clinic_obj->phone;
        $params['clinic_address'] = $clinic_obj->address;
        $params['clinic_region'] = $clinic_obj->region;

        $start = \DateTime::createFromFormat('Y-m-d H:i', $param['booked_start']);
        $end = (\DateTime::createFromFormat("Y-m-d H:i", $param['booked_start']))->add(new \DateInterval("PT".$clinic_obj->duration."M"));
        $params['booked_start'] = $start->format('Y-m-d H:i');
        $date_for_notification = $start->format('M j, Y');
        $params['booked_end'] = $end->format('Y-m-d H:i');
        $params['booked_day'] = date_format($start,'D');
        $params['booked_date'] = date_format($start,'Y-m-d');
        $params['booked_time'] = date_format($start,'g:i a');

        $params['status'] = 'First_Session_Upcoming';
        $params['created_at'] = Carbon::now();

        $cancel_exist = $this->appointmentsRepository->check_cancel_exist($params['user_id'],$params['clinic_id'],$params['booked_start']);
        if($cancel_exist){
            $a_id = $cancel_exist['id'];

            $params['updated_at'] = Carbon::now();
            $updated_appointment = $this->appointmentsRepository->update($a_id, $params);
            if($updated_appointment){

                // Treatment status update to treatment_processing
                $param_treatment['status'] = 'first_session_booked';
                $param_treatment['updated_at'] = Carbon::now();
                $this->treatmentsRepository->update($treatment_obj->id, $param_treatment);

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $params['user_id'];
                $notification['user_first_name']    = $params['user_first_name'];
                $notification['user_last_name']     = $params['user_last_name'];
                $notification['user_email']         = $params['user_email'];
                $notification['appointment_id']     = $a_id;
                $notification['treatment_id']       = $params['treatment_id'];
                $notification['clinic_id']          = $params['clinic_id'];
                $notification['package_id']         = $treatment_obj->package_id;
                $notification['type']               = 'booking_completed';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();
                $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                $notification->save();

                // Add Record
                $record = new Record();
                $record['type'] = 'first_session_booked';
                $record['appointment_id'] = $treatment_obj->appointment_id;
                $record['treatment_id'] = $treatment_obj->id;
                $record['user_id'] = $treatment_obj->user_id;
                $record['note'] = "<p>The Booking was completed.</p><br><p>Clinic to address : ".$params['clinic_address']." at ".$params['booked_start']."</p>";
                $record['created_at'] = Carbon::now();
                $record->save();

                // Update status on user table
                $u_params['treatment_status'] = 'first_session_booked';
                $u_params['appointment_status'] = 'first_session_booked';
                $u_params['updated_at'] = Carbon::now();
                $this->userRepository->update($treatment_obj->user_id, $u_params);

                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                    "token":  "'.$user_device_token.'",
                    "notification": {
                        "title": "reemarc",
                        "body": "'.$notification['note'].'"
                    },
                    "data": {
                        "notification_type": "booking_completed",
                        "id": "'.$notification->id.'",
                        "user_id": "'.$notification['user_id'].'",
                        "appointment_id": "'.$notification['appointment_id'].'",
                        "treatment_id": "'.$treatment_obj->id.'",
                        "clinic_id": "'.$notification['clinic_id'].'",
                        "package_id": "'.$treatment_obj->package_id.'",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "'.$notification['note'].'",
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

                $data = [
                    'data' => [
                        "code" => 200,
                        "appointment" => $updated_appointment,
                        "message" => "Data has been updated"
                    ]
                ];

            }else{
                $data = [
                    'error' => [
                        'code' => 404,
                        'message' => "Data transaction filed"
                    ]
                ];
            }
            return response()->json($data);
        }

        $double_book_a_day = $this->appointmentsRepository->check_double_book_a_day($params['user_id'], $params['booked_date']);
        if($double_book_a_day){
            $data = [
                'error' => [
                    'code' => 400,
                    'message' => "You have a reservation on the same day. Please reschedule or cancel existing booking."
                ]
            ];
            return response()->json($data);
        }

        $taken_book = $this->appointmentsRepository->check_taken_book($params['clinic_id'], $params['booked_start']);
        if($taken_book){
            $data = [
                'error' => [
                    'code' => 400,
                    'message' => "We apologize, but the reservation time you selected is already booked. Please choose a different time or check our availability for other dates."
                ]
            ];
            return response()->json($data);
        }

        $appointment = $this->appointmentsRepository->create($params);
        if($appointment){

            // Treatment status update to treatment_processing
            $param_treatment['status'] = 'treatment_started';
            $param_treatment['updated_at'] = Carbon::now();
            $this->treatmentsRepository->update($treatment_obj->id, $param_treatment);

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $params['user_id'];
            $notification['user_first_name']    = $params['user_first_name'];
            $notification['user_last_name']     = $params['user_last_name'];
            $notification['user_email']         = $params['user_email'];
            $notification['appointment_id']     = $appointment->id;
            $notification['treatment_id']       = $params['treatment_id'];
            $notification['clinic_id']          = $params['clinic_id'];
            $notification['package_id']         = $treatment_obj->package_id;
            $notification['type']               = 'booking_completed';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
            $notification->save();

            // Add Record
            $record = new Record();
            $record['type'] = 'booking_completed';
            $record['appointment_id'] = $treatment_obj->appointment_id;
            $record['treatment_id'] = $treatment_obj->id;
            $record['user_id'] = $treatment_obj->user_id;
            $record['note'] = "<p>The Booking was completed.</p><br><p>Clinic to address : ".$params['clinic_address']." at ".$params['booked_start']."</p>";
            $record['created_at'] = Carbon::now();
            $record->save();

            // send push notification
            $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
            $header = [
                'content-type: application/json'
            ];

            $postdata = '{
                "token":  "'.$user_device_token.'",
                "notification": {
                    "title": "reemarc",
                    "body": "'.$notification['note'].'"
                },
                "data": {
                    "notification_type": "booking_completed",
                    "id": "'.$notification->id.'",
                    "user_id": "'.$notification['user_id'].'",
                    "appointment_id": "'.$notification['appointment_id'].'",
                    "treatment_id": "'.$notification['treatment_id'].'",
                    "clinic_id": "'.$notification['clinic_id'].'",
                    "package_id": "null",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "'.$notification['note'].'",
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

            $data = [
                'data' => [
                    "code" => 200,
                    'appointment' => $appointment,
                    "message" => "Data has been created"
                ]
            ];
            return response()->json($data);
        }else{
            $data = [
                'error' => [
                    'code' => 404,
                    'message' => "Data transaction filed"
                ]
            ];
            return response()->json($data);
        }
    }

    public function session_cancel(Request $request)
    {
        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $treatment_id = $param['treatment_id'];
        $params['status'] = 'Cancel';
        $params['updated_at'] = Carbon::now();

        try {

            $appt = $this->appointmentsRepository->update($appointment_id, $params);
            $user_obj = $this->userRepository->findById($appt->user_id);
            $user_device_token = $user_obj->device_token;
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
            if ($appt) {

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $appt->user_id;
                $notification['user_first_name']    = $appt->user_first_name;
                $notification['user_last_name']     = $appt->user_last_name;
                $notification['user_email']         = $appt->user_email;
                $notification['appointment_id']     = $appt->id;
                $notification['treatment_id']       = $appt->treatment_id;
                $notification['clinic_id']          = $appt->clinic_id;
                $notification['package_id']         = $treatment_obj->package_id;
                $notification['type']               = 'booking_cancelled';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();

                $start = \DateTime::createFromFormat('Y-m-d H:i:s', $appt->booked_start);
                $date_for_notification = $start->format('M j');

                $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                $notification->save();

                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                    "token":  "'.$user_device_token.'",
                    "notification": {
                        "title": "reemarc",
                        "body": "'.$notification['note'].'"
                    },
                    "data": {
                        "notification_type": "booking_cancelled",
                        "id": "'.$notification->id.'",
                        "user_id": "'.$notification['user_id'].'",
                        "appointment_id": "'.$notification['appointment_id'].'",
                        "treatment_id": "'.$treatment_id.'",
                        "clinic_id": "'.$notification['clinic_id'].'",
                        "package_id": "null",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "'.$notification['note'].'",
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

                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Appointment has been cancelled"
                    ]
                ];
                return response()->json($data);
            }else{
                $data = [
                    'error' => [
                        'code' => 404,
                        'message' => "Data transaction filed"
                    ]
                ];
                return response()->json($data);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function booking_from_app(Request $request)
    {
        $param = $request->all();
        Log::info($param);
        $params['user_id'] = $param['user_id'];
        $params['clinic_id'] = $param['clinic_id'];

        $session_exist = $this->appointmentsRepository->check_session_exist($params['user_id']);
//        Log::info($session_exist);
        if(!$session_exist){ // for first visit booking

            $init_appointment = $this->appointmentsRepository->get_recent_appointment($params['user_id']);
            if($init_appointment){
                $noti_rs = $this->notificationRepository->get_notification_id_by_appointment_id($init_appointment->id);
                // delete for notification table
                $this->notificationRepository->delete($noti_rs->id);
                // delete for appointment table
                $this->appointmentsRepository->delete($init_appointment->id);
            }

            $user_obj = User::where('id', $params['user_id'])->first();
            $params['user_first_name'] = $user_obj->first_name;
            $params['user_last_name'] = $user_obj->last_name;
            $params['user_email'] = $user_obj->email;
            $params['user_phone'] = $user_obj->phone;
            $user_device_token = $user_obj->device_token;

            $clinic_obj = Clinic::where('id', $params['clinic_id'])->first();
            $params['clinic_name'] = $clinic_obj->name;
            $params['clinic_phone'] = $clinic_obj->phone;
            $params['clinic_address'] = $clinic_obj->address;
            $params['clinic_region'] = $clinic_obj->region;

            $start = \DateTime::createFromFormat('Y-m-d H:i', $param['booked_start']);
            $end = (\DateTime::createFromFormat("Y-m-d H:i", $param['booked_start']))->add(new \DateInterval("PT".$clinic_obj->duration."M"));
            $params['booked_start'] = $start->format('Y-m-d H:i');
            $date_for_notification = $start->format('M j');
            $params['booked_end'] = $end->format('Y-m-d H:i');
            $params['booked_day'] = date_format($start,'D');
            $params['booked_date'] = date_format($start,'Y-m-d');
            $params['booked_time'] = date_format($start,'g:i a');

            $treatment_id = null;
            $params['treatment_id'] = $treatment_id;
            $params['created_at'] = Carbon::now();
            $params['status'] = 'upcoming';

            $cancel_exist = $this->appointmentsRepository->check_cancel_exist($params['user_id'],$params['clinic_id'],$params['booked_start']);
            if($cancel_exist){
                $a_id = $cancel_exist['id'];

                $params['updated_at'] = Carbon::now();
                $updated_appointment = $this->appointmentsRepository->update($a_id, $params);
                if($updated_appointment){

                    // Update status on User table
                    $u_params['appointment_status'] = 'upcoming';
                    $u_params['clinic_id'] = $params['clinic_id'];
                    $this->userRepository->update($params['user_id'], $u_params);

                    // Add Notification
                    $notification = new Notification();
                    $notification['user_id']            = $params['user_id'];
                    $notification['user_first_name']    = $params['user_first_name'];
                    $notification['user_last_name']     = $params['user_last_name'];
                    $notification['user_email']         = $params['user_email'];
                    $notification['appointment_id']     = $a_id;
                    $notification['clinic_id']          = $params['clinic_id'];
                    $notification['type']               = 'booking_completed';
                    $notification['is_read']            = 'no';
                    $notification['is_delete']          = 'no';
                    $notification['created_at']         = Carbon::now();
                    $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                    $notification->save();

                    // send push notification
                    $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                    $header = [
                        'content-type: application/json'
                    ];

                    $postdata = '{
                    "token":  "'.$user_device_token.'",
                    "notification": {
                        "title": "reemarc",
                        "body": "'.$notification['note'].'"
                    },
                    "data": {
                        "notification_type": "booking_completed",
                        "id": "'.$notification->id.'",
                        "user_id": "'.$notification['user_id'].'",
                        "appointment_id": "'.$notification['appointment_id'].'",
                        "treatment_id": "'.$treatment_id.'",
                        "clinic_id": "'.$notification['clinic_id'].'",
                        "package_id": "null",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "'.$notification['note'].'",
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

                    $data = [
                        'data' => [
                            "code" => 200,
                            "appointment" => $updated_appointment,
                            "message" => "Data has been updated"
                        ]
                    ];



                }else{
                    $data = [
                        'error' => [
                            'code' => 404,
                            'message' => "Data transaction filed"
                        ]
                    ];
                }
                return response()->json($data);
            }

            $double_book_a_day = $this->appointmentsRepository->check_double_book_a_day($params['user_id'], $params['booked_date']);
            if($double_book_a_day){
                $data = [
                    'error' => [
                        'code' => 400,
                        'message' => "You have a reservation on the same day. Please reschedule or cancel existing booking."
                    ]
                ];
                return response()->json($data);
            }

            $taken_book = $this->appointmentsRepository->check_taken_book($params['clinic_id'], $params['booked_start']);
            if($taken_book){
                $data = [
                    'error' => [
                        'code' => 400,
                        'message' => "We apologize, but the reservation time you selected is already booked. Please choose a different time or check our availability for other dates."
                    ]
                ];
                return response()->json($data);
            }

            $appointment = $this->appointmentsRepository->create($params);
            if($appointment){

                // Update status on user table
                $u_params['appointment_status'] = 'upcoming';
                $u_params['clinic_id'] = $params['clinic_id'];
                $this->userRepository->update($params['user_id'], $u_params);

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $params['user_id'];
                $notification['user_first_name']    = $params['user_first_name'];
                $notification['user_last_name']     = $params['user_last_name'];
                $notification['user_email']         = $params['user_email'];
                $notification['appointment_id']     = $appointment->id;
                $notification['treatment_id']       = null;
                $notification['clinic_id']          = $params['clinic_id'];
                $notification['package_id']         = null;
                $notification['type']               = 'booking_completed';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();
                $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                $notification->save();

                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "'.$user_device_token.'",
                "notification": {
                    "title": "reemarc",
                    "body": "'.$notification['note'].'"
                },
                "data": {
                    "notification_type": "booking_completed",
                    "id": "'.$notification->id.'",
                    "user_id": "'.$notification['user_id'].'",
                    "appointment_id": "'.$notification['appointment_id'].'",
                    "treatment_id": "null",
                    "clinic_id": "'.$notification['clinic_id'].'",
                    "package_id": "null",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "'.$notification['note'].'",
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

                $data = [
                    'data' => [
                        "code" => 200,
                        'appointment' => $appointment,
                        "message" => "Data has been created"
                    ]
                ];
                return response()->json($data);
            }else{
                $data = [
                    'error' => [
                        'code' => 404,
                        'message' => "Data transaction filed"
                    ]
                ];
                return response()->json($data);
            }

        }else{

            $rs = $this->treatmentsRepository->get_treatment_status_by_user_id($params['user_id']);
            $status = 'session_booked';
            if($rs) {
                if($rs->status == 'package_delivered' || $rs->status == 'first_session_booked'){
                    $status = 'first_session_booked';
                }

                if($rs->status == 'first_session_booked' || $rs->status == 'session_booked'){
                    $first_session_obj = $this->appointmentsRepository->get_recent_session($params['user_id']);
                    if($first_session_obj) {
                        $a_id = $first_session_obj->id;
                        $noti_rs = $this->notificationRepository->get_notification_id_by_appointment_id($a_id);
                        // delete for notification table
                        $this->notificationRepository->delete($noti_rs->id);
                        // delete for appointment table
                        $this->appointmentsRepository->delete($a_id);
                    }
                }
            }

            // for session booking (treatment_id exist!)
            $user_obj = User::where('id', $params['user_id'])->first();
            $params['user_first_name'] = $user_obj->first_name;
            $params['user_last_name'] = $user_obj->last_name;
            $params['user_email'] = $user_obj->email;
            $params['user_phone'] = $user_obj->phone;
            $user_device_token = $user_obj->device_token;

            // for change clinic center for package delivery.
            $params['treatment_id'] = $session_exist->id;
            $treatment_obj = Treatments::where('id', $params['treatment_id'])->first();

            // If first session booked, take the clinic_id from treatment table.
            if($status == 'first_session_booked') {
                $params['clinic_id'] = $treatment_obj->clinic_id;
            }

            $clinic_obj = Clinic::where('id', $params['clinic_id'])->first();
            $params['clinic_name'] = $clinic_obj->name;
            $params['clinic_phone'] = $clinic_obj->phone;
            $params['clinic_address'] = $clinic_obj->address;
            $params['clinic_region'] = $clinic_obj->region;

            $start = \DateTime::createFromFormat('Y-m-d H:i', $param['booked_start']);
            $end = (\DateTime::createFromFormat("Y-m-d H:i", $param['booked_start']))->add(new \DateInterval("PT".$clinic_obj->duration."M"));
            $params['booked_start'] = $start->format('Y-m-d H:i');
            $date_for_notification = $start->format('M j, Y');
            $params['booked_end'] = $end->format('Y-m-d H:i');
            $params['booked_day'] = date_format($start,'D');
            $params['booked_date'] = date_format($start,'Y-m-d');
            $params['booked_time'] = date_format($start,'g:i a');

            $params['status'] = $status;
            $params['created_at'] = Carbon::now();

            $cancel_exist = $this->appointmentsRepository->check_cancel_exist($params['user_id'],$params['clinic_id'],$params['booked_start']);
            if($cancel_exist){
                $a_id = $cancel_exist['id'];

                $params['updated_at'] = Carbon::now();
                $updated_appointment = $this->appointmentsRepository->update($a_id, $params);
                if($updated_appointment){

                    // Treatment status update to treatment_processing
                    $param_treatment['status'] = $status;
                    $param_treatment['updated_at'] = Carbon::now();
                    $this->treatmentsRepository->update($treatment_obj->id, $param_treatment);

                    // Add Notification
                    $notification = new Notification();
                    $notification['user_id']            = $params['user_id'];
                    $notification['user_first_name']    = $params['user_first_name'];
                    $notification['user_last_name']     = $params['user_last_name'];
                    $notification['user_email']         = $params['user_email'];
                    $notification['appointment_id']     = $a_id;
                    $notification['treatment_id']       = $params['treatment_id'];
                    $notification['clinic_id']          = $params['clinic_id'];
                    $notification['package_id']         = $treatment_obj->package_id;
                    $notification['type']               = 'booking_completed';
                    $notification['is_read']            = 'no';
                    $notification['is_delete']          = 'no';
                    $notification['created_at']         = Carbon::now();
                    $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                    $notification->save();

                    // Add Record
                    $record = new Record();
                    $record['type'] = $status;
                    $record['appointment_id'] = $treatment_obj->appointment_id;
                    $record['treatment_id'] = $treatment_obj->id;
                    $record['user_id'] = $treatment_obj->user_id;
                    $record['note'] = "<p>The Booking was completed.</p><br><p>Clinic to address : ".$params['clinic_address']." at ".$params['booked_start']."</p>";
                    $record['created_at'] = Carbon::now();
                    $record->save();

                    // Update status on User table
                    $u_params['appointment_status'] = $status;
                    $u_params['treatment_status'] = $status;
                    $u_params['clinic_id'] = $params['clinic_id'];
                    $u_params['updated_at'] = Carbon::now();
                    $this->userRepository->update($params['user_id'], $u_params);

                    // send push notification
                    $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                    $header = [
                        'content-type: application/json'
                    ];

                    $postdata = '{
                    "token":  "'.$user_device_token.'",
                    "notification": {
                        "title": "reemarc",
                        "body": "'.$notification['note'].'"
                    },
                    "data": {
                        "notification_type": "booking_completed",
                        "id": "'.$notification->id.'",
                        "user_id": "'.$notification['user_id'].'",
                        "appointment_id": "'.$notification['appointment_id'].'",
                        "treatment_id": "'.$treatment_obj->id.'",
                        "clinic_id": "'.$notification['clinic_id'].'",
                        "package_id": "'.$treatment_obj->package_id.'",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "'.$notification['note'].'",
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

                    $data = [
                        'data' => [
                            "code" => 200,
                            "appointment" => $updated_appointment,
                            "message" => "Data has been updated"
                        ]
                    ];

                }else{
                    $data = [
                        'error' => [
                            'code' => 404,
                            'message' => "Data transaction filed"
                        ]
                    ];
                }
                return response()->json($data);
            }

            $double_book_a_day = $this->appointmentsRepository->check_double_book_a_day($params['user_id'], $params['booked_date']);
            if($double_book_a_day){
                $data = [
                    'error' => [
                        'code' => 400,
                        'message' => "You have a reservation on the same day. Please reschedule or cancel existing booking."
                    ]
                ];
                return response()->json($data);
            }

            $taken_book = $this->appointmentsRepository->check_taken_book($params['clinic_id'], $params['booked_start']);
            if($taken_book){
                $data = [
                    'error' => [
                        'code' => 400,
                        'message' => "We apologize, but the reservation time you selected is already booked. Please choose a different time or check our availability for other dates."
                    ]
                ];
                return response()->json($data);
            }

            $appointment = $this->appointmentsRepository->create($params);
            if($appointment){

                // Treatment status update to treatment_processing
                $param_treatment['status'] = $status;
                $param_treatment['updated_at'] = Carbon::now();
                $this->treatmentsRepository->update($treatment_obj->id, $param_treatment);

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $params['user_id'];
                $notification['user_first_name']    = $params['user_first_name'];
                $notification['user_last_name']     = $params['user_last_name'];
                $notification['user_email']         = $params['user_email'];
                $notification['appointment_id']     = $appointment->id;
                $notification['treatment_id']       = $params['treatment_id'];
                $notification['clinic_id']          = $params['clinic_id'];
                $notification['package_id']         = $treatment_obj->package_id;
                $notification['type']               = 'booking_completed';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();
                $notification['note']               = $params['clinic_name'] . " " . $params['booked_time'] . ", " . $date_for_notification;
                $notification->save();

                // Add Record
                $record = new Record();
                $record['type'] = $status;
                $record['appointment_id'] = $treatment_obj->appointment_id;
                $record['treatment_id'] = $treatment_obj->id;
                $record['user_id'] = $treatment_obj->user_id;
                $record['note'] = "<p>The Booking was completed.</p><br><p>Clinic to address : ".$params['clinic_address']." at ".$params['booked_start']."</p>";
                $record['created_at'] = Carbon::now();
                $record->save();

                // Update status on User table
                $u_params['appointment_status'] = $status;
                $u_params['treatment_status'] = $status;
                $u_params['clinic_id'] = $params['clinic_id'];
                $u_params['updated_at'] = Carbon::now();
                $this->userRepository->update($params['user_id'], $u_params);

                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                "token":  "'.$user_device_token.'",
                "notification": {
                    "title": "reemarc",
                    "body": "'.$notification['note'].'"
                },
                "data": {
                    "notification_type": "booking_completed",
                    "id": "'.$notification->id.'",
                    "user_id": "'.$notification['user_id'].'",
                    "appointment_id": "'.$notification['appointment_id'].'",
                    "treatment_id": "'.$notification['treatment_id'].'",
                    "clinic_id": "'.$notification['clinic_id'].'",
                    "package_id": "null",
                    "is_read": "no",
                    "is_delete": "no",
                    "note": "'.$notification['note'].'",
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

                $data = [
                    'data' => [
                        "code" => 200,
                        'appointment' => $appointment,
                        "message" => "Data has been created"
                    ]
                ];
                return response()->json($data);
            }else{
                $data = [
                    'error' => [
                        'code' => 404,
                        'message' => "Data transaction filed"
                    ]
                ];
                return response()->json($data);
            }

        }


    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function booking_cancel_app(Request $request)
    {
        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $apmt_obj = $this->appointmentsRepository->findById($appointment_id);
        if($apmt_obj->status == "cancel"){
            $data = [
                'error' => [
                    'code' => 404,
                    'message' => "You have already canceled."
                ]
            ];
            return response()->json($data);
        }

        $treatment_id = null;
        $params['status'] = 'cancel';
        $params['updated_at'] = Carbon::now();

        try {

            $appt = $this->appointmentsRepository->update($appointment_id, $params);
            $user_obj = $this->userRepository->findById($appt->user_id);
            $user_device_token = $user_obj->device_token;

            if ($appt) {

                // Update status on User table
                $u_params['appointment_status'] = 'cancel';
                $u_params['updated_at'] = Carbon::now();
                $this->userRepository->update($appt->user_id, $u_params);

                $treatment_obj = $this->treatmentsRepository->get_treatment_status_by_user_id($appt->user_id);
                if($treatment_obj){
                    // Update status on Treatment table
                    $t_params['status'] = 'cancel';
                    $t_params['updated_at'] = Carbon::now();
                    $this->treatmentsRepository->update($treatment_obj->id, $t_params);
                }

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $appt->user_id;
                $notification['user_first_name']    = $appt->user_first_name;
                $notification['user_last_name']     = $appt->user_last_name;
                $notification['user_email']         = $appt->user_email;
                $notification['appointment_id']     = $appt->id;
                $notification['treatment_id']       = null;
                $notification['clinic_id']          = $appt->clinic_id;
                $notification['package_id']         = null;
                $notification['type']               = 'booking_cancelled';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();

                $start = \DateTime::createFromFormat('Y-m-d H:i:s', $appt->booked_start);
                $date_for_notification = $start->format('M j');

                $notification['note']               = $appt->clinic_name . " " . $appt->booked_time . " " . $date_for_notification;
                $notification->save();

                // send push notification
                $url = "https://us-central1-reemarc-300aa.cloudfunctions.net/sendFCM";
                $header = [
                    'content-type: application/json'
                ];

                $postdata = '{
                    "token":  "'.$user_device_token.'",
                    "notification": {
                        "title": "reemarc",
                        "body": "'.$notification['note'].'"
                    },
                    "data": {
                        "notification_type": "booking_cancelled",
                        "id": "'.$notification->id.'",
                        "user_id": "'.$notification['user_id'].'",
                        "appointment_id": "'.$notification['appointment_id'].'",
                        "treatment_id": "null",
                        "clinic_id": "'.$notification['clinic_id'].'",
                        "package_id": "null",
                        "is_read": "no",
                        "is_delete": "no",
                        "note": "'.$notification['note'].'",
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

                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Appointment has been cancelled"
                    ]
                ];
                return response()->json($data);
            }else{
                $data = [
                    'error' => [
                        'code' => 404,
                        'message' => "Data transaction filed"
                    ]
                ];
                return response()->json($data);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_list()
    {
        return appointments::all();
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_upcoming_list(Request $request)
    {
        $param = $request->all();
        $clinic = $this->clinicRepository->findById($param['clinic_id']);

        // clinic disabled days
        if($clinic->disabled_days) {
            $clinic['disabled_days'] = explode(',', $clinic->disabled_days);
        }else{
            $clinic['disabled_days'] = null;
        }

        // clinic image
        $clinic_images = $this->fileAttachmentsRepository->get_clinic_img_by_clinic_id($clinic->id);
        if($clinic_images) {
            $clinic['images'] = url('/').'/storage'.$clinic_images['attachment'];
        }else{
            $clinic['images'] = null;
        }

        $appointments_list = $this->appointmentsRepository->get_upcoming_appointments_by_clinic_id($param['clinic_id']);
        if(sizeof($appointments_list)>0){
            $clinic->appointment = $appointments_list;
        }
        return $clinic;
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_complete_list(Request $request)
    {
        $param = $request->all();
        $clinic = $this->clinicRepository->findById($param['clinic_id']);

        // clinic disabled days
        if($clinic->disabled_days) {
            $clinic['disabled_days'] = explode(',', $clinic->disabled_days);
        }else{
            $clinic['disabled_days'] = null;
        }

        // clinic image
        $clinic_images = $this->fileAttachmentsRepository->get_clinic_img_by_clinic_id($clinic->id);
        if($clinic_images) {
            $clinic['images'] = url('/').'/storage'.$clinic_images['attachment'];
        }else{
            $clinic['images'] = null;
        }

        $appointments_list = $this->appointmentsRepository->get_complete_appointments_by_clinic_id($param['clinic_id']);
        if(sizeof($appointments_list)>0){
            $clinic->appointment = $appointments_list;
        }
        return $clinic;
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_upcoming_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $appointments_list = $this->appointmentsRepository->get_upcoming_appointments_by_user_id($param['user_id']);
        if(sizeof($appointments_list)>0){
            $user->appointment = $appointments_list;
        }
        return $user;
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_complete_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $appointments_list = $this->appointmentsRepository->get_complete_appointments_by_user_id($param['user_id']);
        if(sizeof($appointments_list)>0){
            $user->appointment = $appointments_list;
        }
        return $user;
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_cancel_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $appointments_list = $this->appointmentsRepository->get_cancel_appointments_by_user_id($param['user_id']);
        if(sizeof($appointments_list)>0){
            $user->appointment = $appointments_list;
        }
        return $user;
    }
}
