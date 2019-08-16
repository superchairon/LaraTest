<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 2019-08-15
 * Time: 20:02
 */

namespace App\Helpers;


use Illuminate\Log\ParsesLogConfiguration;
use Monolog\Logger;

class StackdriverDriver
{
    use ParsesLogConfiguration;

    public function __invoke($config)
    {
        return new Logger($this->parseChannel($config), [
            new StackdriverHandler(
                $config['labels'], $config['logName'], $this->level($config)
            ),
        ]);
//        return new Logger($this->parseChannel($config), [
//            $this->prepareHandler(new StackdriverHandler(
//                $config['lables'], $this->level($config)
//            ), $config),
//        ]);
    }

    protected function getFallbackChannelName()
    {
        return 'unknown';
    }
}