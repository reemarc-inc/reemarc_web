<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\NotificationRepository;

use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->notificationRepository = $notificationRepository;

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
            $data = [
                'data' => [
                    'notification_list' => $notification_list
                ]
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
        $params['delete'] = 'yes';
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

}
