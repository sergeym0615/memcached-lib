<?php

namespace Test;

use MemcachedLib\MemcachedLib;
use PHPUnit\Framework\TestCase;

class MemcachedTest extends TestCase
{
    protected $memory;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->memory = new MemcachedLib();
        $this->memory->setServer();
    }

    public function testSetKey()
    {
        $key = 'setKey';
        $value = [11, 12];
        $this->assertTrue($this->memory->set($key, $value));
    }
}