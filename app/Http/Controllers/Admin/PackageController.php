<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\PackageRepository;

use Illuminate\Support\Facades\Hash;

class PackageController extends Controller
{
    private $packageRepository;

    public function __construct(PackageRepository $packageRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->packageRepository = $packageRepository;

        $this->data['currentAdminMenu'] = 'package';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['packages'] = $this->packageRepository->findAll();

        return view('admin.package.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data['Package'] = $this->packageRepository->findAll();

        return view('admin.package.form', $this->data);
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

        if ($this->packageRepository->create($params)) {
            return redirect('admin/package')
                ->with('success', 'Success to create new Brand');
        }

        return redirect('admin/package/create')
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
        $this->data['user'] = $this->packageRepository->findById($id);

        return view('admin.package.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->packageRepository->findById($id);


//        $this->data['package'] = $this->packageRepository->findAll();
//        $this->data['teams'] = [
//            'KDO',
//            'Brand',
//            'Creative'
//        ];
//        $this->data['roles_'] = [
//            'Admin' => 'admin',
//            'Doctor' => 'doctor',
//            'Patient' => 'patient',
//            'Operator' => 'operator',
//        ];
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
        $user = $this->packageRepository->findById($id);

        if ($this->packageRepository->update($id, $request->validated())) {
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
