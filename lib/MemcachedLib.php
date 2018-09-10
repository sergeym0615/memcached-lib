<?php

namespace MemcachedLib;

class MemcachedLib implements MemcachedLibInterface
{

    /**
     * @param string $host
     * @param int $port
     */
    public function setServer(string $host, int $port): void
    {
        // TODO: Implement setServer() method.
    }

    /**
     * @param string $key
     * @param $data
     * @param int $time
     * @return bool
     */
    public function set(string $key, $data, int $time): bool
    {
        // TODO: Implement set() method.
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        // TODO: Implement delete() method.
    }
}