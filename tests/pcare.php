<?php

require_once __DIR__.'/../autoload.php';
require_once __DIR__.'/../vendor/autoload.php';
require_once 'config.php';

/*
$dok = new \joseffi\Bpjs\Pcare\Dokter($pcare_conf);
$doklist = $dok->getDokter(0, 10);
var_dump($doklist);
*/
$spes = new \joseffi\Bpjs\Pcare\Spesialis($pcare_conf);
$speslist = $spes->getReferensiSpesialis();
var_dump($speslist);


/*
$peserta = new \joseffi\Bpjs\Pcare\Peserta($pcare_conf);
$data = $peserta->getPeserta('0001261832477');
var_dump($data);
*/

/*
$poli = new \joseffi\Bpjs\Pcare\Poli($pcare_conf);
$data = $poli->getPoliFKTP(0, 10);
var_dump($data);
*/

/*
$sadar = new \joseffi\Bpjs\Pcare\Kesadaran($pcare_conf);
$data = $sadar->getKesadaran();
var_dump($data);
*/

$provider = new \joseffi\Bpjs\Pcare\Provider($pcare_conf);
$data = $provider->getProviderRayonasi(0, 100);
var_dump($data);