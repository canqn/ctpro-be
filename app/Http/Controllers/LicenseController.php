<?php

namespace App\Http\Controllers;

use App\Models\MachineLicense;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        return view('content/license/index');
    }
}
