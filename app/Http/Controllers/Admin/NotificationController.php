<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\notificationRepository;

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

}
