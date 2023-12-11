<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\Notification;
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

    public function follow_up()
    {

        $this->data['currentAdminMenu'] = 'appointment_follow_up';

//        $params = $request->all();

//        $this->data['filter'] = $params;
        $this->data['appointments'] = $appointments_list = $this->appointmentsRepository->get_patients_list_by_clinic_id(1);


//        $appointments_list = $this->appointmentsRepository->get_upcoming_appointments();
//
//        // Campaign_asset_detail
//        if(sizeof($appointments_list)>0){
//            foreach ($appointments_list as $k => $appointment){
//                $a_id = $appointment->id;
//                $appointment_detail = $this->appointmentsRepository->get_appointment_detail($a_id);
//                $appointments_list[$k]->appointment = $appointment_detail;
//            }
//        }

        return view('admin.appointment_follow_up.index', $this->data);
    }

    public function follow_up_complete(Request $request)
    {
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
            $t_params['status'] = 'package_option_ready';
            $t_params['created_at'] = Carbon::now();

            $this->treatmentsRepository->create($t_params);

            return redirect('admin/appointment_follow_up')
                ->with('success', 'Follow Up Success!');
        }


    }


    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function booking_from_app(Request $request)
    {
        $param = $request->all();
        $params['user_id'] = $param['user_id'];
        $user_obj = User::where('id', $params['user_id'])->first();
        $params['user_first_name'] = $user_obj->first_name;
        $params['user_last_name'] = $user_obj->last_name;
        $params['user_email'] = $user_obj->email;
        $params['user_phone'] = $user_obj->phone;

        $params['clinic_id'] = $param['clinic_id'];
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

        $params['status'] = 'Upcoming';
        $params['created_at'] = Carbon::now();

        $cancel_exist = $this->appointmentsRepository->check_cancel_exist($params['user_id'],$params['clinic_id'],$params['booked_start']);
        if($cancel_exist){
            $a_id = $cancel_exist['id'];
            $params['status'] = 'Upcoming';
            $params['updated_at'] = Carbon::now();
            if($this->appointmentsRepository->update($a_id, $params)){

                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $params['user_id'];
                $notification['user_first_name']    = $params['user_first_name'];
                $notification['user_last_name']     = $params['user_last_name'];
                $notification['user_email']         = $params['user_email'];
                $notification['appointment_id']     = $a_id;
                $notification['treatment_id']       = 0;
                $notification['type']               = 'booking_requested';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();
                $notification['note']               = "Your booking at ". $params['clinic_name'] . " is at " . $params['booked_time'] . " " . $date_for_notification;
                $notification->save();

                $noti_res['notification_id']    = $notification->id;
                $noti_res['notification_title'] = 'Initial treatment booked';
                $noti_res['notification_body']  = $notification->note;
                $noti_res['user_id']            = $notification->user_id;
                $noti_res['user_first_name']    = $notification->user_first_name;
                $noti_res['user_last_name']     = $notification->user_last_name;
                $noti_res['user_email']         = $notification->user_email;
                $noti_res['appointment_id']     = $notification->appointment_id;
                $noti_res['type']               = $notification->type;
                $noti_res['is_read']            = $notification->is_read;
                $noti_res['is_delete']          = $notification->is_delete;
                $noti_res['note']               = $notification->note;

                $data = [
                    'data' => [
                        "code" => 200,
                        'notification' => $noti_res,
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

            // Add Notification
            $notification = new Notification();
            $notification['user_id']            = $params['user_id'];
            $notification['user_first_name']    = $params['user_first_name'];
            $notification['user_last_name']     = $params['user_last_name'];
            $notification['user_email']         = $params['user_email'];
            $notification['appointment_id']     = $appointment->id;
            $notification['treatment_id']       = 0;
            $notification['type']               = 'booking_requested';
            $notification['is_read']            = 'no';
            $notification['is_delete']          = 'no';
            $notification['created_at']         = Carbon::now();
            $notification['note']               = "Your booking at ". $params['clinic_name'] . " is at " . $params['booked_time'] . " " . $date_for_notification;
            $notification->save();

            // Send Notification
//            $rs_notification = $this->send_notificatoin();
//            $new_params['response'] = $rs_notification;
//            $this->notificationRepository->update($new_noti->id, $new_params);

            $noti_res['notification_id']    = $notification->id;
            $noti_res['notification_title'] = 'Initial treatment booked';
            $noti_res['notification_body']  = $notification->note;
            $noti_res['user_id']            = $notification->user_id;
            $noti_res['user_first_name']    = $notification->user_first_name;
            $noti_res['user_last_name']     = $notification->user_last_name;
            $noti_res['user_email']         = $notification->user_email;
            $noti_res['appointment_id']     = $notification->appointment_id;
            $noti_res['type']               = $notification->type;
            $noti_res['is_read']            = $notification->is_read;
            $noti_res['is_delete']          = $notification->is_delete;
            $noti_res['note']               = $notification->note;

            $data = [
                'data' => [
                    "code" => 200,
                    'appointment' => $appointment,
                    'notification' => $noti_res,
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

    public function send_notificatoin()
    {
        $client = new Client();

        $res = $client->request(
            'POST',
            'https://us-central1-denti-find.cloudfunctions.net/sendFCM',
            [
                "headers" => [
                  "Content-Type" => "application/json"
                ],
                "token" => "eag-Vno5QpGNuiVhGdJ2wO:APA91bG2wQbDlWinplUg4QEblKf_KsOtcZLvkCaEjwavCct2Q4Fm5tsnRok8x-zUKekO8XyxgTKgKdmkK7wf1bP9TxDw6Tx35PuzmVEyj_S4DKBJ4DG2jeFH3tW_Mdj7xSwpnq2JZnZt",
                "notification" => [
                    "title" => "Your Notification Title Test",
                    "body" => "Your Notification Body"
                ],
                "data" => [
                    "message_id" => "1",
                    "image_url" => "",
                    "user_id" => "228",
                    "appointment_id" => "28",
                    "type" => "booking_requested",
                    "clinic_name" => "Newyork Yonsei Dental Clinic",
                    "clinic_address" => "3F JUN Building, 825-9 Yeoksam-dong, Gangnam-gu, Seoul",
                    "booked_time" => "10=>00 am",
                    "booked_date" => "2023-12-04",
                    "clinic_web_url" => "https=>//www.dugonismile.com/",
                    "clinic_phone" => "6505885042",
                    "note" => "Your booking at Newyork Yonsei Dental Clinic is at 10=>00 am Dec 4, 2023",
                    "status"=> "unread",
                    "created_at" => "2023-11-30 12:00:00"
                ]
            ]);

        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
        }

        return $response_data;
    }

    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function booking_cancel_app(Request $request)
    {
        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $params['status'] = 'Cancel';
        $params['updated_at'] = Carbon::now();

        try {
                $appt = $this->appointmentsRepository->update($appointment_id, $params);
            if ($appt) {


                // Add Notification
                $notification = new Notification();
                $notification['user_id']            = $appt->user_id;
                $notification['user_first_name']    = $appt->user_first_name;
                $notification['user_last_name']     = $appt->user_last_name;
                $notification['user_email']         = $appt->user_email;
                $notification['appointment_id']     = $appt->id;
                $notification['treatment_id']       = 0;
                $notification['type']               = 'booking_cancelled';
                $notification['is_read']            = 'no';
                $notification['is_delete']          = 'no';
                $notification['created_at']         = Carbon::now();

                $start = \DateTime::createFromFormat('Y-m-d H:i:s', $appt->booked_start);
                $date_for_notification = $start->format('M j, Y');

                $notification['note']               = "Your booking at ". $appt->clinic_name . " is at " . $appt->booked_time . " " . $date_for_notification . " has been cancelled.";
                $notification->save();

                $noti_res['notification_id']    = $notification->id;
                $noti_res['notification_title'] = 'Initial treatment Cancelled';
                $noti_res['notification_body']  = $notification->note;
                $noti_res['user_id']            = $notification->user_id;
                $noti_res['user_first_name']    = $notification->user_first_name;
                $noti_res['user_last_name']     = $notification->user_last_name;
                $noti_res['user_email']         = $notification->user_email;
                $noti_res['appointment_id']     = $notification->appointment_id;
                $noti_res['type']               = $notification->type;
                $noti_res['is_read']            = $notification->is_read;
                $noti_res['is_delete']          = $notification->is_delete;
                $noti_res['note']               = $notification->note;

                $data = [
                    'data' => [
                        "code" => 200,
                        "notification" => $noti_res,
                        "message" => "Appointment has been canceled"
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
