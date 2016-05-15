<?php

namespace App\Http\Controllers;

use App\Deployment\DeploymentService;
use App\Deployment\ElasticIndexService;
use App\Jobs\UpdateElasticsearchIndex;
use Carbon\Carbon;
use Grimm\Book;
use Grimm\Person;
use Illuminate\Http\Request;

use App\Http\Requests;

class DeploymentController extends Controller
{

    public function index(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        return view('admin.deployment.index', compact('deployment'));
    }

    public function triggerDeployment(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        if ($deployment->inProgress()) {
            abort(503);
        }

        $deployment->setInProgress();

        $this->dispatch(new UpdateElasticsearchIndex(Carbon::now(), auth()->user()));

        return response()->json(['data' => ['action' => 'ok', 'books' => Book::count(), 'people' => Person::count()]]);
    }

    public function blankify(ElasticIndexService $indexService)
    {
        $this->authorize('admin.deployment');

        $indexService->dropIndex('grimm');

        // We have to still create the index to prevent API errors
        $indexService->createIndex('grimm', $indexService->mappingsFromProvider());

        return response()->json(['data' => ['action' => 'ok', 'message' => 'Der Index wurde geleert']]);
    }

    public function status(DeploymentService $deployment)
    {
        $this->authorize('admin.deployment');

        return response()->json(['data' => $deployment->status()]);
    }
}
