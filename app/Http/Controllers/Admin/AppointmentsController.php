<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\ClinicRepository;

use Illuminate\Support\Facades\Hash;

class AppointmentsController extends Controller
{
    private $appointmentsRepository;
    private $clinicRepository;
    private $userRepository;

    public function __construct(AppointmentsRepository $appointmentsRepository,
                                ClinicRepository $clinicRepository,
                                UserRepository $userRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->appointmentsRepository = $appointmentsRepository;
        $this->clinicRepository = $clinicRepository;
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
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Operator' => 'operator',
        ];
        $this->data['team_'] = !empty($params['team']) ? $params['team'] : '';
        $this->data['role_'] = !empty($params['role']) ? $params['role'] : '';

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
                $data = [
                    'data' => [
                        "code" => 200,
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
                    'message' => "A booking already exists for the same date"
                ]
            ];
            return response()->json($data);
        }

        $taken_book = $this->appointmentsRepository->check_taken_book($params['clinic_id'], $params['booked_start']);
        if($taken_book){
            $data = [
                'error' => [
                    'code' => 400,
                    'message' => "A booking already exists for another patient"
                ]
            ];
            return response()->json($data);
        }

        $appointment = $this->appointmentsRepository->create($params);
        if($appointment){
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
            if ($this->appointmentsRepository->update($appointment_id, $params)) {
                $data = [
                    'data' => [
                        "code" => 200,
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
