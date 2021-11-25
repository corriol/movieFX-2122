<?php
declare(strict_types=1);

//namespace DesignPatterns\Structural\Registry;

//use InvalidArgumentException;

abstract class Registry
{
    public const LOGGER = 'logger';
    public const PDO = 'PDO';

    /**
     * this introduces global state in your application which can not be mocked up for testing
     * and is therefore considered an anti-pattern! Use dependency injection instead!
     *
     * @var Service[]
     */
    private static array $services = [];

    private static array $allowedKeys = [
        self::LOGGER,
        self::PDO
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
    public static function getPDO() {

    }
}
