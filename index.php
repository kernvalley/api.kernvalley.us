<?php
namespace Index;

require __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use \Header;
use function Functions\{csp, load};
use const Consts\{CSP};

csp(CSP);
load('html');
