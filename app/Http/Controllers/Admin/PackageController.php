<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Repositories\Admin\TreatmentsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Repositories\Admin\PackageRepository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    private $packageRepository;
    private $treatmentsRepository;

    public function __construct(PackageRepository $packageRepository,
                            TreatmentsRepository $treatmentsRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->packageRepository = $packageRepository;
        $this->treatmentsRepository = $treatmentsRepository;

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
                ->with('success', 'Success to create new Package');
        }

        return redirect('admin/package/create')
            ->with('error', 'Fail to create new Package');
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
        $this->data['package'] = $this->packageRepository->findById($id);

        return view('admin.package.form', $this->data);
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
        $package = $this->packageRepository->findById($id);
        $param = $request->request->all();

        if ($this->packageRepository->update($id, $param)) {
            return redirect('admin/package')
                ->with('success', __('users.success_updated_message', ['name' => $package->name]));
        }

        return redirect('admin/package')
                ->with('error', __('users.fail_to_update_message', ['name' => $package->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $package = $this->packageRepository->findById($id);

        if ($this->packageRepository->delete($id)) {
            return redirect('admin/package')
                ->with('success', 'Success to Delete the Package');
        }
        return redirect('admin/package')
                ->with('error', 'Fail to Delete the Package');
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

    public function get_package_by_treatment_id(Request $request)
    {
        try{
            $param = $request->all();
            Log::info($request);

            $treatment_id = $param['treatment_id'];
            $treatment_obj = $this->treatmentsRepository->findById($treatment_id);
            if($treatment_obj){
                $package_id = $treatment_obj->package_id;
                $package_obj = $this->packageRepository->findById($package_id);

                if($package_obj){
                    $data = [
                        'data' => [
                            'package' => $package_obj
                        ]
                    ];
                }else{
                    $data = [
                        'error' => [
                            'message' => "Package not exist"
                        ]
                    ];
                }
            }else{
                $data = [
                    'error' => [
                        'message' => "Treatment not exist"
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

}
