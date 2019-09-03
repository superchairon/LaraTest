<?php

namespace App\Exceptions;

use Exception;
use Google\Cloud\Core\Report\SimpleMetadataProvider;
use Google\Cloud\ErrorReporting\Bootstrap;
use Google\Cloud\Logging\LoggingClient;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            // Ensure Stackdriver is initialized and handle the exception
            $monitoredResource = [
                'type' => 'global',
            ];
            $labels = config('logging.channels.stackdriver.labels');
            $logName = config('logging.channels.stackdriver.logName');
            $logger = (new LoggingClient())
                ->psrLogger('app-error', [
                    'batchEnabled' => true,
                    'debugOutput' => true,
                    'batchOptions' => [
                        'numWorkers' => 2
                    ],
                    'metadataProvider' => new SimpleMetadataProvider($monitoredResource, '', $logName, '', $labels)
                ]);
            if ($logger) {
                Bootstrap::init($logger);
                Bootstrap::exceptionHandler($exception);
            }
            parent::report($exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
