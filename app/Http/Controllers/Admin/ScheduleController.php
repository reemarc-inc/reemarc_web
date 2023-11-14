<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\ScheduleRepository;

use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{
    private $scheduleRepository;

    public function __construct(scheduleRepository $scheduleRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->scheduleRepository = $scheduleRepository;

        $this->data['currentAdminMenu'] = 'dashboard';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['currentAdminMenu'] = 'dashboard';

        if($request->ajax()) {
            $data = Schedule::whereDate('event_start', '>=', $request->start)
                ->whereDate('event_end',   '<=', $request->end)
                ->get(['id', 'event_name', 'event_start', 'event_end']);
            return response()->json($data);
        }

        return view('admin.dashboard.index');
    }

    public function calendarEvents(Request $request)
    {
        switch ($request->type) {
            case 'create':
                $event = CrudEvents::create([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'edit':
                $event = CrudEvents::find($request->id)->update([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = CrudEvents::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # ...
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['schedules'] = $this->scheduleRepository->findAll();

        return view('admin.schedules.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params['campaign_name'] = $request['campaign_name'];

        if ($this->scheduleRepository->create($params)) {
            return redirect('admin/schedules')
                ->with('success', 'Success to create new Brand');
        }

        return redirect('admin/schedules/create')
            ->with('error', 'Fail to create new Brand');
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
        $user = $this->userRepository->findById($id);

        $this->data['user'] = $user;
        $this->data['team'] = $user->team;
        $this->data['role_'] = $user->role;
        $this->data['schedules'] = $this->scheduleRepository->findAll();
        $this->data['teams'] = [
            'KDO',
            'Brand',
            'Creative'
        ];
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Operator' => 'operator',
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
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepository->findById($id);

        if ($this->userRepository->update($id, $request->validated())) {
            return redirect('admin/users')
                ->with('success', __('users.success_updated_message', ['first_name' => $user->first_name]));
        }

        return redirect('admin/users')
                ->with('error', __('users.fail_to_update_message', ['first_name' => $user->first_name]));
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
}
