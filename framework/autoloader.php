<?php namespace Framework;

/**
 * Class Autoloader
 * @package Lab8\Framework
 *
 * Modified from the original to pertain to my project.
 *
 * CREDIT: http://blaketv.com/2014/08/14/php-autoload-classes/
 *   Blake Erikson
 */

class Autoloader
{
    public $basePath = null;

    /**
     * Set the basepath for the projects
     */
    public function __construct()
    {
        $this->basePath = __DIR__ . "/..";
    }

    public function loadApp($class)
    {
        $dir = $this->basePath;
        $this->load($class, $dir);
    }

    public function loadFramework($class)
    {
        $dir = $this->basePath;
        $this->load($class, $dir);
    }

    // private

    private function load($class, $dir)
    {
        // strip off any leading namespace separator from PHP 5.3
        $class = ltrim($class, '\\');

        // didn't originally convert the namespace to lowercase
        $class = strtolower($class);

        // the eventual file path
        $subpath = '';

        // is there a PHP 5.3 namespace separator?
        $pos = strrpos($class, '\\');
        if ($pos !== false) {
            // convert namespace separators to directory separators
            $ns = substr($class, 0, $pos);
            $subpath = str_replace('\\', DIRECTORY_SEPARATOR, $ns)
                . DIRECTORY_SEPARATOR;
            // remove the namespace portion from the final class name portion
            $class = substr($class, $pos + 1);
        }

        // convert underscores in the class name to directory separators
        $subpath .= str_replace('_', DIRECTORY_SEPARATOR, $class);

        // previx with the central directory location and suffix with .php,
        // then require it.
        $file = $dir . DIRECTORY_SEPARATOR . $subpath . '.php';
        if (is_file($file)) {
            if (strpos($file, 'Templates') !== false) {
                // skip
            } else {
                require $file;
            }
        }
    }
}