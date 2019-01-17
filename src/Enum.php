<?php

namespace Cxj;

use \Exception;

abstract class Enum
{
    private $name;
    private static $enums;

    private function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns an assoc. array of ['ENUM_NAME' => $ENUM_VALUE] for all enum
     * values.
     * @return array
     * @throws Exception
     */
    public static function getAll(): array
    {
        $class = static::class;
        if (!isset(self::$enums[$class])) {
            static::init();
        }

        return self::$enums[$class];
    }

    /**
     * Return an enum value (object) from a string name.
     * @return $this
     */
    public static function fromString($name)
    {
        return static::__callStatic($name, []);
    }

    public function __toString()
    {
        return $this->name;
    }

    public static function __callStatic($name, $args)
    {
        $class = static::class;
        if (!isset(self::$enums[$class])) {
            static::init();
        }
        if (!isset(self::$enums[$class][$name])) {
            throw new \TypeError(
                'Undefined enum ' . $class . '::' . $name . '()'
            );
        }

        return self::$enums[$class][$name];
    }

    private static function init()
    {
        $class = static::class;

        if ($class === __CLASS__) {
            throw new \Exception(
                'Do not invoke methods directly on class Enum.'
            );
        }

        $doc = (new \ReflectionClass($class))->getDocComment();

        if (preg_match_all('/@method\s+static\s+(\w+)/i', $doc, $matches)) {
            foreach ($matches[1] as $name) {
                self::$enums[$class][$name] = new static($name);
            }
        }
        else {
            throw new \Exception(
                'Please provide a PHPDoc for ' . $class . ' with a static @method for each enum value.'
            );
        }
    }
}
