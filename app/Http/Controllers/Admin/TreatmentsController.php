<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use App\Models\Clinic;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\Admin\FileAttachmentsRepository;
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
    private $clinicRepository;
    private $fileAttachmentsRepository;
    private $userRepository;

    public function __construct(TreatmentsRepository $treatmentsRepository,
                                ClinicRepository $clinicRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                UserRepository $userRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->treatmentsRepository = $treatmentsRepository;
        $this->clinicRepository = $clinicRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->userRepository = $userRepository;

        $this->data['currentAdminMenu'] = 'treatments_list';
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

        return view('admin.treatments.index', $this->data);
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
        $treatments = $this->treatmentsRepository->findById($id);

        $this->data['treatments'] = $treatments;
        $this->data['user_id'] = $treatments->user_id;
        $this->data['user_first_name'] = $treatments->user_first_name;
        $this->data['user_last_name'] = $treatments->user_last_name;
        $this->data['user_email'] = $treatments->user_email;
        $this->data['user_phone'] = $treatments->user_phone;
        $this->data['clinic_id'] = $treatments->clinic_id;
        $this->data['clinic_name'] = $treatments->clinic_name;
        $this->data['clinic_phone'] = $treatments->clinic_phone;
        $this->data['clinic_address'] = $treatments->clinic_address;
        $this->data['clinic_region'] = $treatments->clinic_region;
        $this->data['booked_date'] = $treatments->booked_date;
        $this->data['booked_start'] = $treatments->booked_start;
        $this->data['booked_end'] = $treatments->booked_end;
        $this->data['booked_day'] = $treatments->booked_day;
        $this->data['booked_time'] = $treatments->booked_time;
        $this->data['status'] = $treatments->status;
        $this->data['created_at'] = $treatments->created_at;

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
        ];
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
        $treatments = $this->treatmentsRepository->findById($id);
        $param = $request->request->all();

        if ($this->treatmentsRepository->update($id, $param)) {
            return redirect('admin/treatments_list')
                ->with('success', __('users.success_updated_message', ['name' => $treatments->name]));
        }

        return redirect('admin/treatments_list')
                ->with('error', __('users.fail_to_update_message', ['name' => $treatments->name]));
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
                $appointment_detail = $this->treatmentsRepository->get_appointment_detail($c_id);
                $clinic_list[$k]->appointment = $appointment_detail;
            }
        }


        $treatments_list = $this->treatmentsRepository->get_upcoming_treatments();

        // Campaign_asset_detail
        if(sizeof($treatments_list)>0){
            foreach ($treatments_list as $k => $appointment){
                $a_id = $appointment->id;
                $appointment_detail = $this->treatmentsRepository->get_appointment_detail($a_id);
                $treatments_list[$k]->appointment = $appointment_detail;
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

        $this->treatmentsRepository->create($params);

        $this->data['currentAdminMenu'] = 'appointment_make';

        return redirect('admin/appointment_make/')
            ->with('success', __('Data has been Booked.'));
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
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

        $cancel_exist = $this->treatmentsRepository->check_cancel_exist($params['user_id'],$params['clinic_id'],$params['booked_start']);
        if($cancel_exist){
            $a_id = $cancel_exist['id'];
            $params['status'] = 'Upcoming';
            $params['updated_at'] = Carbon::now();
            if($this->treatmentsRepository->update($a_id, $params)){
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

        $double_book_a_day = $this->treatmentsRepository->check_double_book_a_day($params['user_id'], $params['booked_date']);
        if($double_book_a_day){
            $data = [
                'error' => [
                    'code' => 400,
                    'message' => "A booking already exists for the same date"
                ]
            ];
            return response()->json($data);
        }

        $taken_book = $this->treatmentsRepository->check_taken_book($params['clinic_id'], $params['booked_start']);
        if($taken_book){
            $data = [
                'error' => [
                    'code' => 400,
                    'message' => "A booking already exists for another patient"
                ]
            ];
            return response()->json($data);
        }

        $appointment = $this->treatmentsRepository->create($params);
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
            $notification['created_at']         = Carbon::now();
            $notification['note']               = "Your booking at ". $params['clinic_name'] . " is at " . $params['booked_time'] . " " . $date_for_notification;
            $notification->save();

            // Send Notification


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
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function booking_cancel_app(Request $request)
    {
        $param = $request->all();
        $appointment_id = $param['appointment_id'];
        $params['status'] = 'Cancel';
        $params['updated_at'] = Carbon::now();

        try {
            if ($this->treatmentsRepository->update($appointment_id, $params)) {
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
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_list()
    {
        return treatments::all();
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_upcoming_list(Request $request)
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

        $treatments_list = $this->treatmentsRepository->get_upcoming_treatments_by_clinic_id($param['clinic_id']);
        if(sizeof($treatments_list)>0){
            $clinic->appointment = $treatments_list;
        }
        return $clinic;
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_complete_list(Request $request)
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

        $treatments_list = $this->treatmentsRepository->get_complete_treatments_by_clinic_id($param['clinic_id']);
        if(sizeof($treatments_list)>0){
            $clinic->appointment = $treatments_list;
        }
        return $clinic;
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_upcoming_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $treatments_list = $this->treatmentsRepository->get_upcoming_treatments_by_user_id($param['user_id']);
        if(sizeof($treatments_list)>0){
            $user->appointment = $treatments_list;
        }
        return $user;
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_complete_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $treatments_list = $this->treatmentsRepository->get_complete_treatments_by_user_id($param['user_id']);
        if(sizeof($treatments_list)>0){
            $user->appointment = $treatments_list;
        }
        return $user;
    }

    /***
     * API
     * @return Treatments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_treatments_cancel_list_profile(Request $request)
    {
        $param = $request->all();
        $user = $this->userRepository->findById($param['user_id']);
        $treatments_list = $this->treatmentsRepository->get_cancel_treatments_by_user_id($param['user_id']);
        if(sizeof($treatments_list)>0){
            $user->appointment = $treatments_list;
        }
        return $user;
    }
}
