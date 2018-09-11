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
    }

    public function testSetKey()
    {
        $key = 'setKey';
        $value = [11, 12];
        $this->assertTrue($this->memory->set($key, $value));
    }

    public function testGetKey()
    {
        $key = 'getKey';
        $value = [11, 12];
        $this->assertTrue($this->memory->set($key, $value));
        $this->assertEquals($value, $this->memory->get($key));
    }

    public function testGetKeyNotFound()
    {
        $key = 'key';
        $this->assertNull($this->memory->get($key));
    }

    public function testDeleteKey()
    {
        $key = 'deleteKey';
        $value = 'deleteValue';
        $this->assertTrue($this->memory->set($key, $value));
        $this->assertTrue($this->memory->delete($key));
    }

    public function testDeleteKeyNotFound()
    {
        $key = 'key';
        $this->assertFalse($this->memory->delete($key));
    }
}