<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once 'config.php';

$vmon = new \Nsulistiyawan\Bpjs\VClaim\Monitoring($vclaim_conf);
$hist = $vmon->historyPelayanan('0002060579755', date('Y-m-d', strtotime('90 days ago')), date('Y-m-d'));
var_dump($hist);
