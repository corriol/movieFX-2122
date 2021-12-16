<?php
declare(strict_types=1);


namespace App;

//use InvalidArgumentException;

use App\Alex\Config;
use Exception;
use PDO;

abstract class Registry
{
    public const LOGGER = 'logger';
    public const PDO = 'PDO';
    public const ROUTER = 'router';

    /**
     * this introduces global state in your application which can not be mocked up for testing
     * and is therefore considered an anti-pattern! Use dependency injection instead!
     *
     */
    private static array $services = [];

    private static array $allowedKeys = [
        self::LOGGER,
        self::PDO,
        self::ROUTER
    ];

    public static function set(string $key, $value)
    {
        if (!in_array($key, self::$allowedKeys)) {
            throw new Exception('Invalid key given');
        }

        self::$services[$key] = $value;
    }

    public static function get(string $key)
    {
        if (!in_array($key, self::$allowedKeys) || !isset(self::$services[$key])) {
            throw new InvalidArgumentException('Invalid key given');
        }
        return self::$services[$key];
    }
    public static function setPDO(ConfigInterface $config) {
        $pdo = new PDO($config->getDataSourceName());
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        static::set(self::PDO, $pdo);
    }

    public static function getPDO()
    {
        return static::get(self::PDO);
    }
}
