<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ClinicRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    private $clinicRepository;

    public function __construct() // phpcs:ignore
    {
        parent::__construct();

        $this->data['currentAdminMenu'] = 'api';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $params = $request->all();

        return view('admin.api.index', $this->data);
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
            'China'
        ];

        $this->data['roleId'] = null;
        $this->data['access_level'] = null;
        $this->data['team'] = null;
        $this->data['region'] = null;
        $this->data['user_brand'] = null;

        return view('admin.clinic.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($this->clinicRepository->create($request->all())) {
            return redirect('admin/clinic')
                ->with('success', 'Success to create new clinic');
        }

        return redirect('admin/Clinic/create')
            ->with('error', 'Fail to create new clinic');
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
        $clinic = $this->clinicRepository->findById($id);

        $this->data['clinic'] = $clinic;
        $this->data['name'] = $clinic->name;
        $this->data['address'] = $clinic->address;
        $this->data['description'] = $clinic->description;
        $this->data['latitude'] = $clinic->latitude;
        $this->data['longitude'] = $clinic->longitude;
        $this->data['region'] = $clinic->region;
        $this->data['tel'] = $clinic->tel;
        $this->data['latitude'] = $clinic->latitude;

        $this->data['region_'] = [
            'New York',
            'San Francisco',
            'Seoul',
            'Busan',
            'Jeju',
            'China'
        ];

        return view('admin.clinic.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicRequest $request, $id)
    {
        $clinic = $this->clinicRepository->findById($id);

        if ($this->clinicRepository->update($id, $request->validated())) {
            return redirect('admin/clinic')
                ->with('success', __('users.success_updated_message', ['name' => $clinic->name]));
        }

        return redirect('admin/clinic')
                ->with('error', __('users.fail_to_update_message', ['name' => $clinic->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clinic = $this->clinicRepository->findById($id);

        if ($this->clinicRepository->delete($id)) {
            return redirect('admin/clinic')
                ->with('success', __('users.success_deleted_message', ['name' => $clinic->name]));
        }
        return redirect('admin/clinic')
                ->with('error', __('users.fail_to_delete_message', ['name' => $clinic->name]));
    }
}
