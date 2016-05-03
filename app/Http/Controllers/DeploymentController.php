<?php

namespace App\Http\Controllers;

use App\Deployment\DeploymentService;
use Illuminate\Http\Request;

use App\Http\Requests;

class DeploymentController extends Controller
{

    public function index(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');
        return view('admin.deployment.index', compact('deployment'));
    }
}
