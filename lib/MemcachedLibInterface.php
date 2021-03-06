<?php

namespace MemcachedLib;

interface MemcachedLibInterface
{

    /**
     * @param string $key
     * @param $data
     * @param int $time
     * @return bool
     */
    public function set(string $key, $data, int $time): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;
}