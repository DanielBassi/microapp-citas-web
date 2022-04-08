<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Core\Repositories\ApiRestWS;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    private $key;
    private $api;

    public function __construct()
    {
        $this->key = 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTY0NTM2OTkzNywiaWF0IjoxNjQ1MzY5OTM3fQ.OCnwNZWRhiH6uYm0r0cZugTuL5XWY8d6ES-lwlVeSko';
        $this->api = new ApiRestWS();
    }

    public function index( $jwt )
    {
        $response = json_decode( json_encode( $this->validateJwt( $jwt ) ) );

        /* Validar que el JWT este firmado */
        if( isset( $response->error ) )
            die( $response->message );

        $this->crearCookies(
            json_decode(
                $this->api->obtenerInformacionDelAfiliado( 9010000468, $response->TipoIdentificacion, "999", date('Y-m-d') )
            )[0]
        );

        return view('index');
    }

    public function buscarTurnos( Request $request )
    {
        return $this->api->consultarAgendaDisponible(
            Cookie::get('codigo_usr'),
            "058",
            "999",
            Cookie::get('codigo_sede'),
            "AM",
            5,
            date('Y-m-d')
        );
    }

    public function asignarTurno( Request $request )
    {
        return $this->api->asignarCita(
            Cookie::get('codigo_usr'),
            $request->id_turno
        );
    }

    private function crearCookies( $afiliado )
    {
        Cookie::queue(Cookie::make('codigo_usr', $afiliado->codigo_usuario, 120));
        Cookie::queue(Cookie::make('codigo_sede', $afiliado->codigo_sede, 120));
    }

    private function validateJwt( $jwt )
    {
        try
        {
            $data = JWT::decode($jwt, new Key($this->key, 'HS256'));
            return $this->getDataJwt( $data );
        }
        catch (\Throwable $th)
        {
            return [
                'message' => $th->getMessage(),
                'error' => true
            ];
        }
    }

    private function getDataJwt( $jwt )
    {
        return [
            'TipoIdentificacion' => $jwt->TipoIdentificacion,
            'NumeroIdentificacion' => $jwt->NumeroIdentificacion
        ];
    }
}
