<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AssetNotificationUserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['currentAdminMenu'] = 'dashboard';
        return view('admin.dashboard.index', $this->data);
    }

    public function test()
    {
        $this->data['currentAdminMenu'] = 'dashboard';

        $obj = new AssetNotificationUserRepository();
        $this->data['items'] = $obj->getCopyWriterStatus();

        return view('admin.dashboard.test', $this->data);
    }
}
