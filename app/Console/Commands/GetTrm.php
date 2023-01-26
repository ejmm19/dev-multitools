<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Env;

class GetTrm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trm:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var \App\Http\Controllers\Multitools\GetTrm
     */
    protected $trm;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        \App\Http\Controllers\Multitools\GetTrm $trm
    ) {
        $this->trm = $trm;
        parent::__construct();
    }

    public function handle()
    {
        $response = $this->trm->getTrmByService();
        $url = \config('dataelements.url');
        Http::post($url,
            [
                'text' => $response
            ]
        );
        Log::info('Send message to Slack');
    }
}
