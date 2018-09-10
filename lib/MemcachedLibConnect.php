<?php

namespace MemcachedLib;

class MemcachedLibConnect
{
    private $socket;

    /**
     * MemcachedLibAbstract constructor.
     * Create socket
     */
    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('Error create socket');
    }

    /**
     * Close connection
     */
    public function __destruct()
    {
        socket_close($this->socket);
    }

    /**
     * @param string $host
     * @param int $port
     */
    protected function createConnect(string $host, int $port): void
    {
        socket_connect($this->socket, $host, $port)  or die('Error create connect');
    }
}