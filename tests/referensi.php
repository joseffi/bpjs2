<?php

require_once __DIR__.'/../autoload.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once 'config.php';

$vc = new joseffi\Bpjs\VClaim\Referensi($vclaim_conf);
var_dump($vc->dokterDpjp('2', '2021-12-09', 'INT'));
