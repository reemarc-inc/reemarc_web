<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\appointments;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Repositories\Admin\AppointmentsRepository;
use App\Repositories\Admin\ClinicRepository;

use Illuminate\Support\Facades\Hash;

class AppointmentsController extends Controller
{
    private $appointmentsRepository;
    private $clinicRepository;

    public function __construct(AppointmentsRepository $appointmentsRepository,
                                ClinicRepository $clinicRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->appointmentsRepository = $appointmentsRepository;
        $this->clinicRepository = $clinicRepository;

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
        $this->data['name'] = $appointments->name;
        $this->data['address'] = $appointments->address;
        $this->data['description'] = $appointments->description;
        $this->data['latitude'] = $appointments->latitude;
        $this->data['longitude'] = $appointments->longitude;
        $this->data['region'] = $appointments->region;
        $this->data['tel'] = $appointments->tel;
        $this->data['booking_start'] = $appointments->booking_start;
        $this->data['booking_end'] = $appointments->booking_end;
        $this->data['dentist_name'] = $appointments->dentist_name;

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
            return redirect('admin/appointments')
                ->with('success', __('users.success_updated_message', ['name' => $appointments->name]));
        }

        return redirect('admin/appointments')
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
            return redirect('admin/appointments')
                ->with('success', __('users.success_deleted_message', ['name' => $appointments->name]));
        }
        return redirect('admin/appointments')
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
        $this->data['clinics'] = $this->clinicRepository->findAll($options);
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
            $date[]=date('D, M j',strtotime("+{$i} day",time()));
        }
        $this->data['next_week_dates'] = $date;

        $this->data['time_spots'] = [
            '9:00 am',
            '10:00 am',
            '11:00 am',
            '12:00 pm',
            '1:00 pm',
            '2:00 pm',
            '3:00 pm',
            '4:00 pm',
            '5:00 pm'
        ];

        return view('admin.appointment_make.index', $this->data);
    }


    /***
     * API
     * @return Appointments[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_appointments_list()
    {
        return appointments::all();
    }

}
