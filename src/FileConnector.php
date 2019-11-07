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
            $config['path'] ?? null,
            $config['queue'] ?? 'default'
        );
    }
}
