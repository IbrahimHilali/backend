<?php

namespace App\Http\Controllers;

use App\Deployment\DeploymentService;
use App\Jobs\UpdateElasticsearchIndex;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class DeploymentController extends Controller
{

    public function index(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');
        return view('admin.deployment.index', compact('deployment'));
    }

    public function triggerDeployment(DeploymentService $deployment)
    {
        if ($deployment->inProgress()) {
            throw new MethodNotAllowedHttpException();
        }

        $deployment->setInProgress();

        $this->dispatch(new UpdateElasticsearchIndex(Carbon::now(), auth()->user()));

        return response()->json(['action' => 'ok']);
    }
}