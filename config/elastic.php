<?php

return [
    'host' => env('ELASTIC_HOST', 'http://elasticsearch:9200'),
    'index_prefix' => env('ELASTIC_INDEX_PREFIX', 'jobs'),
];
