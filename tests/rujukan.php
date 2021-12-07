<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once 'config.php';

$vruj = new \Nsulistiyawan\Bpjs\VClaim\Rujukan($vclaim_conf);
$rujukan = $vruj->cariByNoKartu('Peserta', '0002033613472', true);
var_dump($rujukan);
