<?php

require_once __DIR__.'/../autoload.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once 'config.php';

$dok = new \joseffi\Bpjs\Pcare\Dokter($pcare_conf);
$doklist = $dok->getDokter(0, 10);
var_dump($doklist);
