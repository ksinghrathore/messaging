<?php

namespace App\Jobs;

use App\Smser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $mobile;
    public $message;
    public $udh;

    public function __construct($mobile, $message, $udh)
    {
        $this->mobile = $mobile;
        $this->message = $message;
        $this->udh = $udh;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Smser::send($this->mobile, $this->message, $this->udh);
    }
}
