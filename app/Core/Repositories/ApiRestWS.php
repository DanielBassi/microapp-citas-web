<?php

namespace App\Core\Repositories;

    class ApiRestWS
    {
        private $url_base;
        private $token;
        private $client;
        private $secret;
        private $customer;
        private $parametros;

        public function __construct()
        {
            $this->url_base = "https://training.aacustomers.com/aa_panacap/pana/rest/";
            $this->token;
            $this->client = "X-Client-Id: rest901";
            $this->secret = "X-Secret: rest9012022";
            $this->customer = "X-Custom-Id: 901";
            $this->parametros = [];
            $this->obtenerToken();
        }

        public function asignarCita(string $codigo_usr, string $id_turno)
        {
            $this->parametros = array(
                "codigo_usr" => $codigo_usr,
                "id_turno" => $id_turno
            );

            return $this->realizarPeticion("router.php/citas/setapp", array($this->token));
        }

        public function consultarAgendaDisponible(string $codigo_usr, string $codigo_med, string $codigo_esp, int $codigo_sede, string $jornada, int $numero_citas, string $fecha_inical)
        {
            $this->parametros = array(
                "codigo_usr" => $codigo_usr,
                "codigo_med" => $codigo_med,
                "codigo_esp" => $codigo_esp,
                "codigo_sede" => $codigo_sede,
                "jornada" => $jornada,
                "numero_citas" => $numero_citas,
                "fecha_inicial" => $fecha_inical
            );

            return $this->realizarPeticion("router.php/citas/consagen", array($this->token));
        }

        public function obtenerInformacionDelAfiliado(int $identificacion, string $tipo_identificacion, string $codigo_especialidad, string $fecha_deseada)
        {
            $this->parametros = array(
                "identi_usr" =>  $identificacion,
                "tipo_doc" => $tipo_identificacion,
                "codigo_esp" => $codigo_especialidad,
                "fecha_deseada" => $fecha_deseada
            );

            return $this->realizarPeticion("router.php/citas/getdataaf", array( $this->token ));
        }

        private function obtenerToken(): void
        {
            $this->token = "X-TOKEN: ".json_decode($this->realizarPeticion("auth_server.php", array( $this->client, $this->secret, $this->customer)))->token;
        }

        private function realizarPeticion( string $recurso, array $header )
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "{$this->url_base}{$recurso}", //url a la que se conecta
                CURLOPT_RETURNTRANSFER => true, //devuelve el resultado como una cadena del tipo curl_exec
                CURLOPT_FOLLOWLOCATION => true, //sigue el encabezado que le envíe el servidor
                CURLOPT_ENCODING => "", // permite decodificar la respuesta y puede ser"identity", "deflate", y "gzip", si está vacío recibe todos los disponibles.
                CURLOPT_MAXREDIRS => 10, // Si usamos CURLOPT_FOLLOWLOCATION le dice el máximo de encabezados a seguir
                CURLOPT_TIMEOUT => 30, // Tiempo máximo para ejecutar
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // usa la versión declarada
                CURLOPT_CUSTOMREQUEST => "POST", // el tipo de petición, puede ser PUT, POST, GET o Delete dependiendo del servicio
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_POSTFIELDS => json_encode($this->parametros)
            ));

            $response = curl_exec($curl);// respuesta generada
            $err = curl_error($curl); // muestra errores en caso de existir

            curl_close($curl); // termina la sesión

            return $response;
        }
    }

    //$api = new ApiRestWS();

    //var_dump($api->obtenerInformacionDelAfiliado(9010000468, "CC", "999", "2020-02-05"));
    //var_dump($api->obtenerCodigoUsuario(9010000468, "CC", "999", "2020-02-05"));
    //var_dump( $api->consultarAgendaDisponible() );
