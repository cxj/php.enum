<?php
/**
 * @file example.php
 * Replace with one line description.
 */

namespace Cxj;

require_once "../vendor/autoload.php";

/**
 * @method static RED()
 * @method static GREEN()
 * @method static BLUE()
 */
class Color extends Enum
{
}

$red   = Color::RED();
$red2  = Color::RED();
$green = Color::GREEN();

var_dump($red === $red2);
var_dump($red == $red2);
var_dump($red === $green);
var_dump($red == $green);
var_dump((string)$red);
var_dump((string)$green);
var_dump($red === Color::fromString('RED'));
var_dump(Color::getAll());


try {
    $geern = Color::GEERN(); // Intentional typo. Throws.
}
catch (\Throwable $e) {
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
}

echo "\nTest directly calling Enum method.  Should throw exception.\n";
try {
    Enum::getAll(); // Shouldn't call methods directly on Enum. Throws.
}
catch (\Throwable $e) {
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
}
