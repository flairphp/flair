<?php
/**
 * a down and dirty loader
 *
 * ref: http://thephpeffect.com/recursive-glob-vs-recursive-directory-iterator/
 */
$path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src';
$dir = new RecursiveDirectoryIterator($path);
$iter = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($iter, '/\.php$/');

foreach ($files as $file) {
    include $file->getPathname();
}
