<?php

namespace App\Http\Controllers;

use App\Helpers\CounterManager;
use App\Jobs\UpdateCounterJob;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $counters = [
            ['description' => 'Mongo page clicks counter', 'value' => CounterManager::incMongoCounter('mongo_views')],
            ['description' => 'Postgres page clicks counter', 'value' => CounterManager::incPostgresCounter('postgres_views')],
            ['description' => 'Mongo jobs counter', 'value' => CounterManager::getMongoCounter('mongo_jobs')],
            ['description' => 'Postgres jobs counter', 'value' => CounterManager::getPostgresCounter('postgres_jobs')],
        ];
        return view('welcome')
            ->with('counters', $counters);
    }

    public function job()
    {
        UpdateCounterJob::dispatch()->delay(now()->addSeconds(10));
        return redirect('/');
    }

}
