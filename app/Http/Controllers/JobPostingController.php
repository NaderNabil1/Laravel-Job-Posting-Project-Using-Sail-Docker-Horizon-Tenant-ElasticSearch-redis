<?php
namespace App\Http\Controllers;

use App\Events\JobPosted;
use App\Jobs\SyncJobToElasticsearch;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function index()
    {
        return JobPosting::latest()->paginate();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'location'=>'nullable|string',
            'salary'=>'nullable|integer',
        ]);

        $job = JobPosting::create($data);

        // HEAVY WORK AFTER RESPONSE
        SyncJobToElasticsearch::dispatch($job->uuid)->afterResponse();
        event(new JobPosted($job->uuid)); // Listener is queued (see next section)

        return response()->json($job, 201);
    }

    public function show(JobPosting $job)
    {
        return $job;
    }

    public function update(Request $request, JobPosting $job)
    {
        $job->update($request->only('title','description','location','salary'));
        SyncJobToElasticsearch::dispatch($job->uuid)->afterResponse();
        return $job;
    }

    public function destroy(JobPosting $job)
    {
        $job->delete();
        return response()->noContent();
    }
}
