<?php

namespace MemcachedLib;

class MemcachedLib extends MemcachedLibConnect implements MemcachedLibInterface
{

    /**
     * @param string $host
     * @param int $port
     */
    public function setServer(string $host = '127.0.0.1', int $port = 11211): void
    {
        $this->createConnect($host, $port);
    }

    /**
     * @param string $key
     * @param $value
     * @param int $time
     * @return bool
     */
    public function set(string $key, $value, int $time = 0): bool
    {
        return $this->request('STORED', $key, $value, $time);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->request('GET', $key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return $this->request('DELETED', $key);
    }
}