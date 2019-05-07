<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
   /**
     * @param string $old
     * @param string $new
     **/
    public static function paramUpdate(string $old, string $new)
    {
        $path = __DIR__ . '/../../../config/params.php';

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $old,
                $new,
                file_get_contents($path)
            ));
            echo exec('composer du');
        }
    }
}
