<?php

namespace Alone\LaravelQueueFile;

use Illuminate\Queue\Connectors\ConnectorInterface;

class FileConnector implements ConnectorInterface
{
    /**
     * queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue|FileQueue
     */
    public function connect(array $config)
    {
        return new FileQueue(
            data_get($config,'path'),
            data_get($config,'queue','default')
        );
    }
}
