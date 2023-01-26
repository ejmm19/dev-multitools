<?php

namespace App\Http\Controllers\Multitools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetTrm extends Controller
{
    public function execute()
    {

        return view('trm.trm', [
            'trm' => $this->getTrmByService()
        ]);
    }

    public function getTrmByService(): string
    {
        try {
            $response = Http::get('https://api.anicamenterprises.com/v1/rates/trm/CO');
            if ($response->failed()) {
                throw new \Exception('Error in response');
            }
            $response = 'Trm today : '.$response->body();
            Log::info('get response successfully');
        }catch (\Exception $e ) {
            $response = $e->getMessage();
            Log::info('Error in response: '.$response);
        }
        return $response;
    }

    public function sendMessageTrm()
    {
        $trm = $this->getTrmByService();
        $url = \config('dataelements.url');
        try {
            $response = Http::post($url,
                [
                    'text' => $trm
                ]
            );
            if ($response != 'ok') {
                throw new \Exception('Error in webhook, response: '.$response);
            }
            Log::info('Send message to Slack');
        }catch (\Exception $e) {
            Log::error('Error to send message: '.$e->getMessage());
        }
    }
}
