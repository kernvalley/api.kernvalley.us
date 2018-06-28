<?php
namespace Autoloader;

require __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'consts.php';

use const \Consts\{BASE};

spl_autoload_register('spl_autoload');
set_include_path(BASE . 'classes');
