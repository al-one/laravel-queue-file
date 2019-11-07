<?php

namespace Alone\LaravelQueueFile;

use Illuminate\Support;

class ServiceProvider extends Support\ServiceProvider
{

    public function boot()
    {
        /** @var \Illuminate\Queue\QueueManager $queue */
        $queue = $this->app['queue'];
        $queue->addConnector('file',function()
        {
            return new FileConnector;
        });
    }

}
