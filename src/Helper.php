<?php
namespace App;

class Helper
{

    public static function configValue($key, $config = null)
    {
        if ($config === null) {
            $config = include(PROJECT_DIR . '/config/config.php');
        }
        $keys = explode('.', $key);
        $value = $config;
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                $value = null;
                break;
            }
        }
        return $value;
    }
}
