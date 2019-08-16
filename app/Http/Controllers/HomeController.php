<?php

namespace App\Http\Controllers;

use App\Helpers\CounterManager;
use App\Jobs\UpdateCounterJob;
use Google\Cloud\Logging\LoggingClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            CounterManager::incMongoCounter('mongo_root_hits');
        } catch (\Exception $e) {
        } catch (\Error $e) {
        }
        return view('welcome');
    }

    public function counters()
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
        return view('counters')
            ->with('counters', $counters);
    }

    public function job()
    {
        UpdateCounterJob::dispatch()->delay(now()->addSeconds(10));
        return redirect('/home');
    }

    public function log()
    {
        $message = "";
        try {
            switch (random_int(0, 4)) {
                case 0:
                    Log::debug('This is a debug message');
                    $message = "DEBUG";
                    break;
                case 1:
                    Log::info('This is a info message');
                    $message = "INFO";
                    break;
                case 2:
                    Log::warning('This is a warning message');
                    $message = "WARNING";
                    break;
                case 3:
                    Log::error('This is an error message');
                    $message = "ERROR";
                    break;
                case 4:
                    Log::critical('This is a critical message');
                    $message = "CRITICAL";
                    break;

            }
        } catch (\Exception $e) {
        }
//        $logging = new LoggingClient();
//        $logger = $logging->psrLogger('app');
//        $logger->info('Hello World');
//        $logger->error('Oh no');
        return "A random log entry was created, with severity = " . $message;
    }

    public function bug()
    {
        $x = array();
        $x = $x[0];
        return $x;
    }

}
