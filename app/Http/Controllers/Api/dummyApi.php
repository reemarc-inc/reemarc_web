<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dummyApi extends Controller
{
    function getData()
    {
        return ["name"=>"jin"];
    }
}
