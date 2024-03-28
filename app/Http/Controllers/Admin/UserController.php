<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\FileAttachments;
use App\Models\User;
use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\ClinicRepository;
use App\Repositories\Admin\FileAttachmentsRepository;
use App\Repositories\Admin\TreatmentsRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\Interfaces\RoleRepositoryInterface;
use App\Repositories\Admin\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Admin\Interfaces\UserRepositoryInterface;

use App\Repositories\Admin\UserRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\PermissionRepository;

use App\Authorizable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userRepository;
    private $appointmentsRepository;
    private $treatmentsRepository;
    private $fileAttachmentsRepository;
    private $clinicRepository;

    public function __construct(UserRepository $userRepository,
                                AppointmentsRepository $appointmentsRepository,
                                TreatmentsRepository $treatmentsRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                ClinicRepository $clinicRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->appointmentsRepository = $appointmentsRepository;
        $this->treatmentsRepository = $treatmentsRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->clinicRepository = $clinicRepository;

        $this->data['currentAdminMenu'] = 'users';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['filter'] = $params;
        $this->data['users'] = $this->userRepository->findAll($options);
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

        return view('admin.users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['regions'] = [
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
        $this->data['access_levels'] = [
            'Affiliate',
            'Customer Service',
            'Ecommerce',
            'Customer Service / Ecommerce',
            'Admin',
            'Call Center',
            'IT'
        ];
        $this->data['clinics'] = $this->clinicRepository->findAll();
        $this->data['genders_'] = [
            'M' => 'M',
            'F' => 'F',
        ];
        $this->data['gender'] = null;
        $this->data['clinic'] = null;
        $this->data['roleId'] = null;
        $this->data['access_level'] = null;
        $this->data['region'] = null;
        $this->data['role_'] = null;
//        $this->data['user_brand'] = null;

        return view('admin.users.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $params = $request->validated();

        $params['password'] = Hash::make($params['password']);

//        if (isset($params['user_brand'])) {
//            $params['user_brand'] = implode(', ', $params['user_brand']);
//        } else {
//            $params['user_brand'] = '';
//        }

        $user = $this->userRepository->create($params);

        if ($user) {
            if($request->file('c_attachment')){
                foreach ($request->file('c_attachment') as $file) {
                    $fileAttachments = new FileAttachments();

                    // file check if exist.
                    $originalName = $file->getClientOriginalName();
                    $destinationFolder = 'storage/images/users/'.$user->id.'/'.$originalName;

                    $fileName =$file->storeAs('users/'.$user->id, $originalName);

                    $fileAttachments['user_id'] = $user->id;
                    $fileAttachments['clinic_id'] = 0;
                    $fileAttachments['type'] = 'attachment_file_' . $file->getMimeType();
                    $fileAttachments['author_id'] = $user->id;
                    $fileAttachments['attachment'] = '/' . $fileName;
                    $fileAttachments['file_ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
                    $fileAttachments['file_type'] = $file->getMimeType();
                    $fileAttachments['file_size'] = $file->getSize();
                    $fileAttachments['date_created'] = Carbon::now();
                    $fileAttachments->save();
                }
            }

            return redirect('admin/users')
                ->with('success', __('users.success_create_message'));
        }else {
            return redirect('admin/users/create')
                ->with('error', __('users.fail_create_message'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function existing_user_pending($id)
    {
        $this->data['user'] = $this->userRepository->findById($id);

        return view('admin.users.show', $this->data);
    }

    public function create_first_appointment($user_obj){

        $clinic_obj = $this->clinicRepository->findById($user_obj->clinic_id);

        $params['user_id'] = $user_obj->id;
        $params['user_first_name'] = $user_obj->first_name;
        $params['user_last_name'] = $user_obj->last_name;
        $params['user_email'] = $user_obj->email;
        $params['user_phone'] = $user_obj->phone;
        $params['clinic_id'] = $user_obj->clinic_id;
        $params['clinic_name'] = $clinic_obj->name;
        $params['clinic_phone'] = $clinic_obj->phone;
        $params['clinic_address'] = $clinic_obj->address;
        $params['clinic_region'] = $clinic_obj->region;
        $params['status'] = 'complete';

        return $this->appointmentsRepository->create($params);
    }

    public function create_session_appointment($user_obj, $booked_start, $t_id){

        $clinic_obj = $this->clinicRepository->findById($user_obj->clinic_id);

        $params['user_id'] = $user_obj->id;
        $params['user_first_name'] = $user_obj->first_name;
        $params['user_last_name'] = $user_obj->last_name;
        $params['user_email'] = $user_obj->email;
        $params['user_phone'] = $user_obj->phone;
        $params['clinic_id'] = $user_obj->clinic_id;
        $params['clinic_name'] = $clinic_obj->name;
        $params['clinic_phone'] = $clinic_obj->phone;
        $params['clinic_address'] = $clinic_obj->address;
        $params['clinic_region'] = $clinic_obj->region;

        $temp = explode(',', $booked_start);
        $duration = 60;
        $start = \DateTime::createFromFormat('Y-m-d H:i', $temp[0].$temp[1]);
        $end = (\DateTime::createFromFormat("Y-m-d H:i", $temp[0].$temp[1]))->add(new \DateInterval("PT".$duration."M"));
        $params['booked_start'] = $start->format('Y-m-d H:i');
        $params['booked_end'] = $end->format('Y-m-d H:i');
        $params['booked_day'] = date_format($start,'D');
        $params['booked_date'] = date_format($start,'Y-m-d');
        $params['booked_time'] = date_format($start,'g:i a');

        $params['treatment_id'] = $t_id;
        $params['status'] = 'complete';

        return $this->appointmentsRepository->create($params);
    }


    public function create_treatment($user_obj, $apmt_obj, $status)
    {
        $params['appointment_id'] = $apmt_obj->id;
        $params['user_id'] = $user_obj->id;
        $params['clinic_id'] = $user_obj->clinic_id;
        $params['package_id'] = $apmt_obj->id;
        $params['session'] = $apmt_obj->id;
        $params['month'] = $apmt_obj->id;
        $params['ship_to_office'] = $apmt_obj->clinic_address;
        $params['status'] = $status;

        return $this->treatmentsRepository->create($params);
    }

    public function generate_past_bookings($first_date, $month, $user_obj, $t_id)
    {
        $first_session_date = $first_date;
//        ddd($first_date, $month);
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
        $index = [
            9 => 5,
            12 => 6,
            15 => 7,
            18 => 8,
            21 => 9,
            24 => 10,
            27 => 11,
            30 => 12,
            33 => 13,
            36 => 14
        ];
        $total = $index[$month];
        for($i=1; $i<=$total; $i++) {
            $temp_date = date('Y-m-d 10:00:00', strtotime("+$month_rule[$i]", strtotime($first_session_date)));
            if($temp_date <= date('Y-m-d H:i:s')) {
                $session_list[] = [
                    'num' => $i,
                    'session' => 'SESSION ' . $i,
                    'booked_start' => date('Y-m-d 08:00:00', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                    'rec_date' => date('Y-m-d H:i:s', strtotime("+$month_rule[$i]", strtotime($first_session_date))),
                    'clinic' => 'TBD',
                    'status' => 'Not Scheduled'
                ];

                ddd($first_date, $month, $session_list);
                $this->create_session_appointment($user_obj, $temp_date, $t_id);
            }
        }
    }

    public function existing_user_update(Request $request, $id)
    {
        $user_obj = $this->userRepository->findById($id);
        $param = $request->request->all();

        if($param['answer_1'] == 'no'){ // new -> first appointment(cho-dong) needed
            $u_params['user_type'] = 'existing_member';
            $u_params['updated_at'] = Carbon::now();

        }else{ // cho-dong finished!! (create appointment row)

            // create appointment row
            $apmt_obj = $this->create_first_appointment($user_obj);

            if($param['answer_3'] == 'no'){ // no : received yet -> (package_ordered)
                $u_params['user_type'] = 'existing_member';
                $u_params['treatment_status'] = 'package_ordered';
                $u_params['updated_at'] = Carbon::now();

                // create treatment row
                $treatment_obj = $this->create_treatment($user_obj, $apmt_obj, 'package_ordered');
                $u_params['treatment_id'] = $treatment_obj->id;

            }else{  // yes : received package -> (package_delivered)
                $u_params['user_type'] = 'existing_member';
                $u_params['treatment_status'] = 'package_delivered';
                $u_params['updated_at'] = Carbon::now();

                // create treatments row (treatment / multi appointments )
                // create treatment row
                $treatment_obj = $this->create_treatment($user_obj, $apmt_obj, 'package_delivered');
                $u_params['treatment_id'] = $treatment_obj->id;

                $first_date = $param['first_date'];
                $month = $param['answer_2'];

                $this->generate_past_bookings($first_date, $month,$user_obj, $u_params['treatment_id']);

            }
        }


        if($this->userRepository->update($id, $u_params)){
            return redirect('admin/patient_jira')
                ->with('success', __('users.success_updated_message', ['first_name' => $user_obj->first_name]));
        }else {
            return redirect('admin/patient_jira')
                ->with('error', __('users.fail_to_update_message', ['first_name' => $user_obj->first_name]));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( ($id != auth()->user()->id) && (auth()->user()->role !='admin') ) {
            return redirect('admin/campaign')
                ->with('error', 'Could not change.');
        }

        $user = $this->userRepository->findById($id);

        $this->data['user'] = $user;
        $this->data['region'] = $user->region;
        $this->data['role_'] = $user->role;
//        $this->data['user_brand'] = $user->user_brand;
        $this->data['clinic'] = $user->clinic_id;
        $this->data['gender'] = $user->gender;
        $this->data['yob'] = $user->yob;
        $options = [
            'user_id' => $id,
            'order' => [
                'date_created' => 'desc',
            ]
        ];
        $this->data['attach_files'] = $this->fileAttachmentsRepository->findAll($options);
        $this->data['regions'] = [
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

        $this->data['clinics'] = $this->clinicRepository->findAll();

        $this->data['genders_'] = [
            'M' => 'M',
            'F' => 'F',
        ];

        return view('admin.users.form', $this->data);
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
        $user = $this->userRepository->findById($id);
        $param = $request->request->all();
        $log_user = auth()->user();

        if($log_user['role'] != 'admin'){
            if($param['password'] == null){
                return redirect('admin/users/'.$id.'/edit')
                    ->with('error', 'Please enter your password to update');
            }
        }

//        if (isset($param['user_brand'])) {
//            $param['user_brand'] = implode(', ', $param['user_brand']);
//        } else {
//            $param['user_brand'] = '';
//        }
        if ($this->userRepository->update($id, $param)) {
            if($request->file('c_attachment')){

                foreach ($request->file('c_attachment') as $file) {
                    $fileAttachments = new FileAttachments();

                    // file size check
//                    if($file->getSize() > 20000000){
//                        return redirect('admin/campaign/'.$id.'/edit')
//                            ->with('error', __('You cannot upload files larger than 20 MB. Use google drive link or https://kissftp.kissusa.com:5001/ to upload files. Please add files location link in ticket description/note.'));
//                    }

                    // file check if exist.
                    $originalName = $file->getClientOriginalName();
                    $destinationFolder = 'storage/images/users/'.$id.'/'.$originalName;

                    $fileName =$file->storeAs('users/'.$id, $originalName);

                    $fileAttachments['user_id'] = $id;
                    $fileAttachments['clinic_id'] = 0;
                    $fileAttachments['type'] = 'attachment_file_' . $file->getMimeType();
                    $fileAttachments['author_id'] = $log_user->id;
                    $fileAttachments['attachment'] = '/' . $fileName;
                    $fileAttachments['file_ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
                    $fileAttachments['file_type'] = $file->getMimeType();
                    $fileAttachments['file_size'] = $file->getSize();
                    $fileAttachments['date_created'] = Carbon::now();
                    $fileAttachments->save();
                }
            }

            return redirect('admin/users/'.$id.'/edit')
                ->with('success', __('users.success_updated_message', ['first_name' => $user->first_name]));
        }

        return redirect('admin/users/'.$id.'/edit')
                ->with('error', __('users.fail_to_update_message', ['first_name' => $user->first_name]));
    }

    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        return view('admin.show.form', $this->data);
    }


    /***
     * API
     * @return
     */
    public function get_user_list()
    {
        $user_list = User::select(
            'id',
            'first_name',
            'last_name',
            'region',
            'role',
            'email',
            'phone',
            'gender',
            'yob',
            'device_token',
            'sns_login',
            'user_type',
            'created_at',
            'updated_at'
        )->get();

        return $user_list;

    }

    public function get_me(request $request)
    {
        try{
            $param = $request->all();
            Log::info($request);
            $user_obj = User::where('email', $param['email'])->first();
            if($user_obj){
                $data = [
                    'data' => [
                        'user' => $user_obj
                    ]
                ];
            }else{
                $data = [
                    'error' => [
                        'message' => "User not exist"
                    ]
                ];
            }
            return response()->json($data);
        }catch (\Exception $ex) {
            return response()->json([
                'msg' => $ex->getMessage() . ' [' . $ex->getCode() . ']'
            ]);
        }
    }


    /***
     * API
     * @return
     */
    public function users_update_app(request $request)
    {
        try{
            $param = $request->all();
            Log::info($request);

            $user_obj = User::where('email', $param['email'])->first();

            if($user_obj){
                if ($request->file('image')) {
                    foreach ($request->file('image') as $file) {
                        $originalName = $file->getClientOriginalName();
                        $fileName =$file->storeAs('users/'.$user_obj->id, $originalName);
                        $fileAttachments['user_id'] = $user_obj->id;
                        $fileAttachments['clinic_id'] = 0;
                        $fileAttachments['type'] = 'attachment_file_' . $file->getMimeType();
                        $fileAttachments['author_id'] = $user_obj->id;
                        $fileAttachments['attachment'] = '/' . $fileName;
                        $fileAttachments['file_ext'] = pathinfo($fileName, PATHINFO_EXTENSION);
                        $fileAttachments['file_type'] = $file->getMimeType();
                        $fileAttachments['file_size'] = $file->getSize();
                        $fileAttachments['date_created'] = Carbon::now();
                        $fileAttachments->save();
                    }
                }

                $user = $this->userRepository->update($user_obj['id'], $param);
                if($user){
                    $data = [
                        'data' => [
                            'user' => $user
                        ]
                    ];
                }else{
                    $data = [
                        'error' => [
                            'message' => "Error in updating"
                        ]
                    ];
                }
            }else{
                $data = [
                    'error' => [
                        'message' => "User not exist"
                    ]
                ];
            }

            return response()->json($data);

        }catch (\Exception $ex) {
            return response()->json([
                'msg' => $ex->getMessage() . ' [' . $ex->getCode() . ']'
            ]);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if ($user->id == auth()->user()->id) {
            return redirect('admin/users')
                ->with('error', 'Could not delete yourself.');
        }

        if ($this->userRepository->delete($id)) {
            return redirect('admin/users')
                ->with('success', __('users.success_deleted_message', ['first_name' => $user->first_name]));
        }
        return redirect('admin/users')
                ->with('error', __('users.fail_to_delete_message', ['first_name' => $user->first_name]));
    }

    public function api_sign_up(Request $request)
    {
        try{
            $params['email'] = $request['email'];
            $params['user_type'] = $request['user_type'];
//            $params['phone'] = $request['phone'];
            $params['password'] = Hash::make($request['password']);
            $params['first_name'] = $request['first_name'];
            $params['last_name'] = $request['last_name'];
//            $params['region'] = $request['region'];
            $params['role'] = 'patient';

            $rs = $this->userRepository->findByEmail($params['email']);

            if(count($rs) > 0){
                $data = [
                    'error' => [
                        'message' => "Email already exist"
                    ]
                ];
            }else{

                $user = $this->userRepository->create($params);

                if(!$user){
                    $data = [
                        'error' => [
                            'message' => "Error in Creating"
                        ]
                    ];
                }else{
                    if(!empty($request['device_token'])){
                        $params['device_token'] = $request['device_token'];
                        $user->update($params);
                    }
                    $data = [
                        'data' => [
                            'message' => "Success"
                        ]
                    ];
                }
            }
            return response()->json($data);

        }catch (\Exception $ex) {
            return response()->json([
                'msg' => $ex->getMessage() . ' [' . $ex->getCode() . ']'
            ]);
        }
    }

    public function log_in(Request $request)
    {
        try {
            $input = $request->all();
            $user_obj = User::select(
                'id',
                'first_name',
                'last_name',
                'region',
                'role',
                'email',
                'password',
                'phone',
                'gender',
                'yob',
                'device_token',
                'sns_login',
                'clinic_id',
                'user_type',
                'image',
                'firebase_image',
                'created_at',
                'updated_at'
            )->where('email', $input['email'])->first();

            if($user_obj){
                if (!$user_obj || !Hash::check($input['password'], $user_obj->password)) {
                    $data = [
                        'error' => [
                            'message' => "These credentials do not match our records."
                        ]
                    ];
                    return response()->json($data);
                }

                $token = $user_obj->createToken('my-app-token')->plainTextToken;
                if (!empty($input['device_token'])) {
                    $params['device_token'] = $input['device_token'];
                    $user_obj->update($params);
                }
                $data = [
                    'data' => [
                        'message' => "Log In success",
                        'token' => $token,
                        'user' => $user_obj
                    ]
                ];
                return response()->json($data);

            }else{
                $data = [
                    'error' => [
                        'message' => "User not exist."
                    ]
                ];
                return response()->json($data);
            }

        }catch (\Exception $ex) {
            return response()->json([
                'msg' => $ex->getMessage() . ' [' . $ex->getCode() . ']'
            ]);
        }
    }

    public function fileRemove($id)
    {
        $fileAssetAttachment = $this->fileAttachmentsRepository->findById($id);

        if($fileAssetAttachment->delete()){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

}

