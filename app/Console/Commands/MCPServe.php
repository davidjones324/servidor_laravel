<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MCPServe extends Command
{
    protected $signature = 'mcp:serve';
    protected $description = 'Inicia el servidor MCP para Antigravity';

    public function handle()
    {
        $host = '127.0.0.1';
        $port = 8085;

        $this->info("Servidor MCP escuchando en http://$host:$port");

        // Crear servidor TCP
        $socket = stream_socket_server("tcp://$host:$port", $errno, $errstr);

        if (!$socket) {
            $this->error("Error al iniciar el servidor: $errstr ($errno)");
            return;
        }

        // Evita bloqueos y errores en Windows
        stream_set_blocking($socket, false);

        // Bucle principal del servidor
        while (true) {
            // Intentar aceptar conexión (timeout 1 segundo)
            $conn = @stream_socket_accept($socket, 1);

            if ($conn) {
                $input = trim(fgets($conn));

                $response = $this->handleRequest($input);

                fwrite($conn, $response . "\n");
                fclose($conn);
            }

            // Evita que el CPU se dispare
            usleep(100000);
        }

        fclose($socket);
    }

    private function handleRequest($input)
    {
        $data = json_decode($input, true);

        if (!$data || !isset($data['tool'])) {
            return json_encode(['error' => 'Petición inválida']);
        }

        switch ($data['tool']) {
            case 'ping':
                return json_encode(['result' => 'pong']);

            case 'listar_rutas':
                $routes = collect(\Route::getRoutes())->map(function ($route) {
                    return [
                    'uri' => $route->uri(),
                    'method' => implode('|', $route->methods()),
                    'name' => $route->getName(),
                    ];
                });

                return json_encode(['routes' => $routes]);

            default:
                return json_encode(['error' => 'Herramienta no encontrada']);
        }
    }
}
