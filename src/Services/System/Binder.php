<?php

namespace Botomatic\Engine\Services\System;

class Binder
{
    /**
     * @param string $class
     * @param string $alias
     *
     * @return mixed
     */
    public static function bind($class, $alias)
    {
        \Illuminate\Container\Container::getInstance()->bindIf($alias, function() use ($class) {
            return app()->make($class);
        });

        return app()->make($alias);
    }
}
