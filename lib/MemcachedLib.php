<?php

namespace MemcachedLib;

class MemcachedLib extends MemcachedLibConnect implements MemcachedLibInterface
{

    /**
     * @param string $key
     * @param $value
     * @param int $time
     * @return bool
     */
    public function set(string $key, $value, int $time = 0): bool
    {
        return $this->requestSet($key, $value, $time);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->requestGet($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return $this->requestDelete($key);
    }
}