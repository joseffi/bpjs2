<?php
spl_autoload_register(function ($className) {
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__;

    // replace prefix
    $prefix = 'joseffi\\Bpjs\\';
    if(substr($className, 0, strlen($prefix)) === $prefix)
        $className = substr($className, strlen($prefix));
    
    echo $className;

    $className = str_replace('\\', $ds, $className);
    $file = "{$dir}{$ds}src{$ds}{$className}.php";

    echo $file;

    if (is_readable($file)) require_once $file;
});