<?php

namespace App\Http\Controllers;

use App\Services\TenantManager;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function search(Request $request, Client $es, TenantManager $tenants)
    {
        $q = $request->query('q', '*');
        $index = config('elastic.index_prefix').'_'.$tenants->current()->slug;

        $res = $es->search([
            'index' => $index,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'  => $q,
                        'fields' => ['title^2','description','location'],
                    ],
                ],
            ],
        ]);

        return $res->asArray()['hits']['hits'] ?? [];
    }
}
