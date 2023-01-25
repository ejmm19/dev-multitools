<?php

namespace App\Http\Controllers\Multitools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        }catch (\Exception $e ) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
