<?php
namespace Flair\PhpUnit {

    class AutoLoader
    {
        protected $basePath = '';

        public function __construct()
        {
            $this->basePath = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
            $this->basePath .= 'src' . DIRECTORY_SEPARATOR;

            spl_autoload_register([$this, 'load'], true, true);
        }

        public function load($class)
        {
            if (stripos($class, 'Flair') === 0) {
                $file = str_replace(['\\'], DIRECTORY_SEPARATOR, $class) . '.php';
                $file = $this->basePath . $file;

                if (is_readable($file)) {
                    require $file;
                    return true;
                }
            }

            return false;
        }
    }
}
