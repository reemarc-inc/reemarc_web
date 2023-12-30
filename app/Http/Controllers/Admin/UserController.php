<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\FileAttachments;
use App\Models\User;
use App\Repositories\Admin\FileAttachmentsRepository;
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

use App\Repositories\Admin\CampaignBrandsRepository;

use App\Authorizable;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;
    private $fileAttachmentsRepository;
    private $campaignBrandsRepository;

    public function __construct(UserRepository $userRepository,
                                FileAttachmentsRepository $fileAttachmentsRepository,
                                CampaignBrandsRepository $campaignBrandsRepository) // phpcs:ignore
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->fileAttachmentsRepository = $fileAttachmentsRepository;
        $this->campaignBrandsRepository = $campaignBrandsRepository;

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

        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
        $this->data['regions'] = [
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
        $this->data['access_levels'] = [
            'Affiliate',
            'Customer Service',
            'Ecommerce',
            'Customer Service / Ecommerce',
            'Admin',
            'Call Center',
            'IT'
        ];
        $this->data['genders_'] = [
            'M' => 'M',
            'F' => 'F',
        ];
        $this->data['gender'] = null;
        $this->data['roleId'] = null;
        $this->data['access_level'] = null;
        $this->data['region'] = null;
        $this->data['role_'] = null;
        $this->data['user_brand'] = null;

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

        if (isset($params['user_brand'])) {
            $params['user_brand'] = implode(', ', $params['user_brand']);
        } else {
            $params['user_brand'] = '';
        }

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
        if ( ($id != auth()->user()->id) && (auth()->user()->role !='admin') ) {
            return redirect('admin/campaign')
                ->with('error', 'Could not change.');
        }

        $user = $this->userRepository->findById($id);

        $this->data['user'] = $user;
        $this->data['region'] = $user->region;
        $this->data['role_'] = $user->role;
        $this->data['user_brand'] = $user->user_brand;
        $this->data['gender'] = $user->gender;
        $this->data['yob'] = $user->yob;
        $this->data['brands'] = $this->campaignBrandsRepository->findAll();
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
        ];
        $this->data['roles_'] = [
            'Admin' => 'admin',
            'Doctor' => 'doctor',
            'Patient' => 'patient',
            'Operator' => 'operator',
        ];
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

        if (isset($param['user_brand'])) {
            $param['user_brand'] = implode(', ', $param['user_brand']);
        } else {
            $param['user_brand'] = '';
        }
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
            'created_at',
            'updated_at'
        )->get();

        return $user_list;

    }


    /***
     * API
     * @return
     */
    public function users_update_app(request $request)
    {
        try{
            $param = $request->all();
            $user_obj = User::where('email', $param['email'])->first();

            if($user_obj){
                if ($request->file('image')) {
                    foreach ($request->file('image') as $file) {
                        $fileAttachments = new FileAttachments();

                        // file check if exist.
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

