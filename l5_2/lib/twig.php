<?php
//
//require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/user_data/apukhtina/vendor/autoload.php';//neto

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'debug' => true,
    'cache' => 'tmp/cache',
    'auto_reload' => true
));
$filter = new Twig_SimpleFilter('my', function ($string) {
    return ((int)$string == 0) ? 'в работе' : 'закрыто';
});
$twig->addFilter($filter);
$twig->addExtension(new Twig_Extension_Debug());
return $twig;