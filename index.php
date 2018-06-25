<?php
namespace Index;

require __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'consts.php';

use function Functions\{csp, load};
use const Consts\{CSP};

csp(CSP);
load('html');
