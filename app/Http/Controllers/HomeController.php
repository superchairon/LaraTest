<?php

namespace App\Http\Controllers;

use App\Helpers\CounterManager;
use App\Jobs\UpdateCounterJob;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        CounterManager::incMongoCounter('mongo_root_hits');
        return 'Go to the <a href="/home">counters</a> page';
    }
    public function home()
    {
        $counters = [
            ['description' => 'Mongo / hits', 'value' => CounterManager::getMongoCounter('mongo_root_hits')],
            ['description' => 'Mongo home page clicks counter', 'value' => CounterManager::incMongoCounter('mongo_views')],
            ['description' => 'Postgres home page clicks counter', 'value' => CounterManager::incPostgresCounter('postgres_views')],
            ['description' => 'Mongo jobs counter', 'value' => CounterManager::getMongoCounter('mongo_jobs')],
            ['description' => 'Postgres jobs counter', 'value' => CounterManager::getPostgresCounter('postgres_jobs')],
            ['description' => 'Mongo scheduler counter', 'value' => CounterManager::getMongoCounter('mongo_scheduler')],
            ['description' => 'Postgres scheduler counter', 'value' => CounterManager::getPostgresCounter('postgres_scheduler')],
        ];
        return view('welcome')
            ->with('counters', $counters);
    }

    public function job()
    {
        UpdateCounterJob::dispatch()->delay(now()->addSeconds(10));
        return redirect('/home');
    }

}
