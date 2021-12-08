<?php

# namespace App\Core\Helpers;

/**
 * Class FlashMessage
 *
 */
namespace App;

class FlashMessage
{
    /**
     *
     */
    const SESSION_KEY = "flash-message";

    /**
     * obté el valor associat a la clau indicada en el primer paràmetre
     * després de llegir el valor l'elimina.
     * @param string $key
     * @param string $defaultValue
     * @return mixed|string
     */
    public static function get(string $key, $defaultValue = ''){

        $value = $_SESSION[self::SESSION_KEY][$key]??$defaultValue;
        self::unset($key);
        return $value;
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value){
        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    /**
     * @param string $key
     */
    public static function unset(string $key){
        unset($_SESSION[self::SESSION_KEY][$key]);
    }
}
