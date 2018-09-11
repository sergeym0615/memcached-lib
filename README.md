# Memcached-lib

Implemented get/set/delete. 

## Install

```bash
composer require sergeym0615/memcached-lib
```

## use

```php
use MemcachedLib\MemcahedLib;

#Default
$memcached = new MemcachedLib();

#Custom host and port
$host = '127.0.0.1';
$port = 11211
$memcached = new MemcachedLib($host, $port);
```
Save data
```php
$memcached->set( string $key , mixed $value [, int $time ] );
```
Get data
```php
$data = $memcached->get(string $key);
```
Removed data
```php
$memcached->delete(string $key);
```
