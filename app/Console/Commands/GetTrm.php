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
        Http::post('https://hooks.slack.com/services/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',
            [
                'text' => $response
            ]
        );
        Log::info('Send message to Slack');
    }
}
