<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Http::post(env('URL_WEBHOOK_SLACK'),
            [
                'text' => $response
            ]
        );
        Log::info('Send message to Slack');
    }
}
