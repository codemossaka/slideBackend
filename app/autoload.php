<?php

    function autoloadClass($class)
    {
        require $class . '.php';
    }

    spl_autoload_register('autoloadClass');