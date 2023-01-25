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
                throw new \Exception('Error en la respuesta');
            }
            $response = 'La tasa representativa del estado que rige para hoy es: '.$response->body();
            Log::info('get response successfully');
        }catch (\Exception $e ) {
            $response = $e->getMessage();
            Log::info('Error in response: '.$response);
        }
        return $response;
    }
}
