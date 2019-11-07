<?php

namespace Alone\LaravelQueueFile;

use Illuminate\Queue\Jobs\Job;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Job as JobContract;

class FileJob extends Job implements JobContract
{

    /**
     * The File queue instance.
     *
     * @var FileQueue
     */
    protected $fileQueue;

    /**
     * The raw job payload.
     *
     * @var string
     */
    protected $job;

    /**
     * The JSON decoded version of "$job".
     *
     * @var array
     */
    protected $decoded;

    /**
     * Create a new job instance.
     *
     * @param  \Illuminate\Container\Container  $container
     * @param  FileQueue  $fileQueue
     * @param  string  $job
     * @param  string  $queue
     * @return void
     */
    public function __construct(Container $container,FileQueue $fileQueue,$job,$queue)
    {
        $this->fileQueue = $fileQueue;
        $this->job       = $job;
        $this->queue     = $queue;
        $this->container = $container;
        $this->decoded   = $this->payload();
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        parent::delete();
        $this->fileQueue->popOrRelease($this->queue,$this->job,false);
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0)
    {
        parent::release($delay);
        $this->fileQueue->popOrRelease($this->queue,$this->job,false);
        $this->fileQueue->later($delay,$this,$this->decoded['data'] ?? '',$this->queue);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return ($this->decoded['attempts'] ?? 0) + 1;
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->decoded['id'] ?? null;
    }

}
