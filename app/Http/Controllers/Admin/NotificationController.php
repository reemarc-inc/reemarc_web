<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Notification;
use App\Models\Record;
use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\ClinicRepository;
use App\Repositories\Admin\TreatmentsRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\NotificationRepository;

use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    private $notificationRepository;
    private $clinicRepository;
    private $userRepository;
    private $appointmentsRepository;
    private $treatmentsRepository;

    public function __construct(NotificationRepository $notificationRepository,
                                ClinicRepository $clinicRepository,
                                UserRepository $userRepository,
                                AppointmentsRepository $appointmentsRepository,
                                TreatmentsRepository $treatmentsRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->notificationRepository = $notificationRepository;
        $this->clinicRepository = $clinicRepository;
        $this->userRepository = $userRepository;
        $this->appointmentsRepository = $appointmentsRepository;
        $this->treatmentsRepository = $treatmentsRepository;

        $this->data['currentAdminMenu'] = 'notification';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['notifications'] = $this->notificationRepository->findAll();

        return view('admin.notification.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        return view('admin.notification.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->request->all();

        if ($this->notificationRepository->create($params)) {
            return redirect('admin/notification')
                ->with('success', 'Success to create new notification');
        }

        return redirect('admin/notification/create')
            ->with('error', 'Fail to create new notification');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = $this->notificationRepository->findById($id);

        return view('admin.notification.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['notification'] = $this->notificationRepository->findById($id);

        return view('admin.notification.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {;
        $notification = $this->notificationRepository->findById($id);
        $param = $request->request->all();

        if ($this->notificationRepository->update($id, $param)) {
            return redirect('admin/notification')
                ->with('success', __('users.success_updated_message', ['name' => $notification->name]));
        }

        return redirect('admin/notification')
                ->with('error', __('users.fail_to_update_message', ['name' => $notification->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $notification = $this->notificationRepository->findById($id);

        if ($this->notificationRepository->delete($id)) {
            return redirect('admin/notification')
                ->with('success', 'Success to Delete the notification');
        }
        return redirect('admin/notification')
                ->with('error', 'Fail to Delete the notification');
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

    public function get_notification_list(Request $request)
    {
        $param = $request->all();

        $notification_list = $this->notificationRepository->get_notification_list_by_user_id($param['user_id']);
        if(sizeof($notification_list)>0){

//            $list = array();
//            $check = array();
//
//            foreach ($notification_list as $index => $row){
//                if(!in_array($row->notification_type, $check)){
//                    $list[$index] = $row;
//                }
//                array_push($check, $row->notification_type);
//            }

            $data = [
                'data' => $notification_list
            ];
            return response()->json($data);
        }else{
            $data = [
                'error' => [
                    'message' => "These credentials do not match our records."
                ]
            ];
            return response()->json($data);
        }
    }

    public function delete_notification(Request $request)
    {
        $param = $request->all();
        $params['is_delete'] = 'yes';
        $params['updated_at'] = Carbon::now();

        try{
            if($this->notificationRepository->update($param['id'], $params)){
                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Notification has been deleted"
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

    public function read_notification(Request $request)
    {
        $param = $request->all();
        $params['is_read'] = 'yes';
        $params['updated_at'] = Carbon::now();

        try{
            if($this->notificationRepository->update($param['id'], $params)){
                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Notification has been update to read"
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

    public function location_confirm(Request $request)
    {
        $param = $request->all();
        $clinic_id = $param['clinic_id'];
        $clinic_obj = $this->clinicRepository->findById($clinic_id);
        $clinic_address = $clinic_obj->address;

        $treatment_id = $param['treatment_id'];
        $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
        if($treatment_obj->status == 'location_confirmed'){
            $data = [
                'error' => [
                    'code' => 404,
                    'message' => "You have already confirmed the location."
                ]
            ];
            return response()->json($data);
        }
        $user_id = $treatment_obj->user_id;

        $user_obj = $this->userRepository->findById($user_id);

        $params['clinic_id'] = $clinic_id;
        $params['ship_to_office'] = $clinic_address;
        $params['status'] = 'location_confirmed';
        $params['updated_at'] = Carbon::now();

//        $notification = new Notification();
//        $notification['user_id']            = $user_obj->id;
//        $notification['user_first_name']    = $user_obj->first_name;
//        $notification['user_last_name']     = $user_obj->last_name;
//        $notification['user_email']         = $user_obj->email;
//        $notification['appointment_id']     = $treatment_obj->appointment_id;
//        $notification['treatment_id']       = $treatment_id;
//        $notification['type']               = 'location_confirm';
//        $notification['is_read']            = 'no';
//        $notification['is_delete']          = 'no';
//        $notification['created_at']         = Carbon::now();
//        $notification['note']               = 'Ship to address : ' . $clinic_address;
//        $notification->save();

        // Add Record
        $record = new Record();
        $record['type'] = 'location_confirm';
        $record['appointment_id'] = $treatment_obj->appointment_id;
        $record['treatment_id'] = $treatment_id;
        $record['user_id'] = $treatment_obj->user_id;
        $record['note'] = "<p>The Location was confirmed.</p><br><p>Ship to address : ".$clinic_address."</p>";
        $record['created_at'] = Carbon::now();
        $record->save();

        // Update status on user table
        $u_params['treatment_status'] = 'location_confirmed';
        $u_params['clinic_id'] = $clinic_id;
        $this->userRepository->update($user_id, $u_params);

        try {
            if ($this->treatmentsRepository->update($treatment_id, $params)){
                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Location confirmed"
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

        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function confirm_your_visit(Request $request)
    {
        $param = $request->all();
        $treatment_id = $param['treatment_id'];
        $apmt_rs = $this->appointmentsRepository->get_last_treatment_session($treatment_id);

        if($apmt_rs == null){
            $data = [
                'error' => [
                    'code' => 404,
                    'message' => "There are no scheduled appointments."
                ]
            ];
            return response()->json($data);
        }
        $appointment_id = $apmt_rs['id'];
        $appointment_obj = $this->appointmentsRepository->findById($appointment_id);

        if($appointment_obj->status == 'session_completed'){
            $data = [
                'error' => [
                    'code' => 404,
                    'message' => "You have already confirmed your visit."
                ]
            ];
            return response()->json($data);
        }

        $params['status'] = 'session_completed';
        $params['updated_at'] = Carbon::now();

        // Add Record
        $record = new Record();
        $record['type'] = 'session_completed';
        $record['appointment_id'] = $appointment_id;
        $record['treatment_id'] = $treatment_id;
        $record['user_id'] = $appointment_obj->user_id;
        $record['note'] = "<p>We have confirmed the patient's visit.</p>";
        $record['created_at'] = Carbon::now();
        $record->save();

        // Update status on user table
        $u_params['treatment_status'] = 'session_completed';
        $u_params['appointment_status'] = 'session_completed';
        $u_params['updated_at'] = Carbon::now();
        $this->userRepository->update($appointment_obj->user_id, $u_params);

        // Update status on treatment table
        $t_params['status'] = 'session_completed';
        $t_params['updated_at'] = Carbon::now();
        $this->treatmentsRepository->update($treatment_id, $t_params);

        try {
            $updated_appointment = $this->appointmentsRepository->update($appointment_id, $params);
            if ($updated_appointment){
                $data = [
                    'data' => [
                        "code" => 200,
                        "message" => "Visit confirmed"
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

        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
