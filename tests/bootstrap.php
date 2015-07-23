<?php
function phpUnitFlairAutoLoader($class)
{
    $class == ltrim($class, '\\');

    if (stripos($class, 'Flair') === 0) {
        $baseDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;

        $file = substr($class, strlen('Flair'));
        $file = ltrim($file, '\\');
        $file = str_replace(['\\'], DIRECTORY_SEPARATOR, $file) . '.php';
        $file = $baseDir . $file;
        require $file;
        return true;
    }

    return false;
}

spl_autoload_register('phpUnitFlairAutoLoader', true, true);
