<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Dokter extends BpjsService
{
    public function getDokter ($start, $limit) {
        return $this->get('dokter/' . $start . '/' . $limit);
    }
}