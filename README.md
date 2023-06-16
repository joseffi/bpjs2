# BPJS Kesehatan Indonesia
PHP package to access BPJS Kesehatan API :ambulance:.
This package is a wrapper of BPJS VClaim Web Service
https://dvlp.bpjs-kesehatan.go.id/VClaim-Katalog

Created because i don't really wanna get my hands dirty coz of using the old php-curl
:shit: example.

#### Installation :fire:

`composer require joseffi/bpjs`

#### Example Usage :confetti_ball:
```php
//use your own bpjs config
$vclaim_conf = [
    'cons_id' => '123456',
    'secret_key' => '123456',
    'base_url' => 'https://dvlp.bpjs-kesehatan.go.id',
    'service_name' => 'vclaim-rest'
];

// or Pcare config
$pcare_conf = [
    'cons_id'       => '123456',
    'secret_key'    => 'abcdef',
    'user_key'      => '6bbfb9e9b535cd9c32bd77451050c6a0',
    'base_url'      => 'https://apijkn-dev.bpjs-kesehatan.go.id',
    'service_name'  => 'pcare-rest-dev',
    'pcare_user'    => 'mimin',
    'pcare_pass'    => 'password',
];

// use Referensi service
// https://dvlp.bpjs-kesehatan.go.id/VClaim-Katalog/Referensi

$referensi = new joseffi\Bpjs\VClaim\Referensi($vclaim_conf);
var_dump($referensi->diagnosa('A00'));

//use Peserta service
//https://dvlp.bpjs-kesehatan.go.id/VClaim-Katalog/Peserta

$peserta = new joseffi\Bpjs\VClaim\Peserta($vclaim_conf);
var_dump($peserta->getByNoKartu('123456789','2018-09-16'));
```
See /tests directory for more examples
