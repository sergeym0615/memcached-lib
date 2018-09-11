<?php

namespace MemcachedLib;

class MemcachedLibConnect
{
    private $socket;

    /**
     * MemcachedLibAbstract constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host = '127.0.0.1', int $port = 11211)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        try {
            if (!$this->socket) {
                $this->exception('Error create socket: ' . socket_strerror(socket_last_error()));
            }
            if (false === socket_connect($this->socket, $host, $port)) {
                $this->exception('Error create connect: ' . socket_strerror(socket_last_error()));
            }
        } catch (\Exception $e) {
            $this->showException($e);
        }
    }

    /**
     * Close connection
     */
    public function __destruct()
    {
        socket_close($this->socket);
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
     * @param string $key
     * @param string $value
     * @param int $time
     * @return bool
     */
    protected function requestSet(string $key, $value = '', int $time = 0): bool
    {
        $setValue = is_string($value) ? $value : serialize($value);
        $length = strlen($setValue);
        $data = "set $key 0 $time $length\r\n$setValue\r\n";
        $this->socketWrite($data);
        return $this->socketRead();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    protected function requestGet(string $key)
    {
        $data = "get $key\r\n";
        $this->socketWrite($data);
        return $this->getValue($this->socketRead());
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function requestDelete(string $key): bool
    {
        $data = "delete $key\r\n";
        $this->socketWrite($data);
        return $this->socketRead();
    }

    /**
     * @param $value
     */
    private function socketWrite(string $value): void
    {
        socket_write($this->socket, $value);
    }

    /**
     * @return string|bool
     */
    private function socketRead()
    {
        $socketData = '';
        try {
            while ($buffer = socket_read($this->socket, 2048)) {
                $socketData .= $buffer;
                if (preg_match('/^STORED|END|DELETED\\r\\n$/', $socketData)) {
                    return $socketData;
                }
                if (preg_match('/^NOT_STORED|NOT_FOUND|EXISTS|ERROR|CLIENT_ERROR|SERVER_ERROR\\r\\n$/'
                    , $socketData))
                {
                    $this->exception($socketData);
                }
            }
        } catch (\Exception $e) {
            $this->showException($e);
            return false;
        }
    }

    /**
     * @param string $message
     * @throws \Exception
     */
    private function exception(string $message): void
    {
        throw new \Exception($message);
    }

    /**
     * @param \Exception $exception
     */
    private function showException(\Exception $exception)
    {
        echo $exception->getMessage();
    }
}