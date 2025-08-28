<?php

namespace App\Jobs;

use App\Models\JobPosting;
use App\Services\TenantManager;
use Elastic\Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncJobToElasticsearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $jobUuid) {}

    public function handle(Client $es, TenantManager $tenants): void
    {
        $job = JobPosting::where('uuid', $this->jobUuid)->first();
        if (! $job) return;

        $index = config('elastic.index_prefix') . '_' . $tenants->current()->slug;

        $payload = [
            'index' => $index,
            'id'    => $job->uuid,
            'body'  => [
                'title'       => $job->title,
                'description' => $job->description,
                'location'    => $job->location,
                'salary'      => $job->salary,
                'created_at'  => $job->created_at?->toAtomString(),
            ],
        ];

        $es->indices()->create(['index'=>$index], ['client'=>['ignore'=>400]]);
        $es->index($payload);
    }
}
