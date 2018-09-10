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
        socket_connect($this->socket, $host, $port) or die('Error create connect');
    }

    /**
     * @param string $result
     * @return mixed|null
     */
    private function getValue(string $result)
    {
        return preg_match("/[^\s]+ \d+ \d+\\r\\n(.+)\\r/", $result, $findValue)
            ? $value = @unserialize($findValue[1]) ? unserialize($findValue[1]) : $findValue[1]
            : null;
    }

    /**
     * @param string $type STORED|GET\DELETED
     * @param string $key
     * @param string $value
     * @param int $time
     * @return mixed
     */
    protected function request(string $type, string $key, $value = '', int $time = 0)
    {
        switch ($type) {
            case 'STORED':
                $setValue = is_string($value) ? $value : serialize($value);
                $length = strlen($setValue);
                $data = "set $key 0 $time $length\r\n$setValue\r\n";
                break;
            case 'GET':
                $data = "get $key\r\n";
                $this->socketWrite($data);
                return $this->getValue($this->socketRead());
            case 'DELETED':
                $data = "delete $key\r\n";
                break;
            default:
                return false;
        }
        $this->socketWrite($data);
        return trim($this->socketRead()) === $type;
    }

    /**
     * @param $value
     */
    private function socketWrite(string $value): void
    {
        socket_write($this->socket, $value);
    }

    /**
     * @return string
     */
    private function socketRead(): string
    {
        return socket_read($this->socket, 2048);
    }
}