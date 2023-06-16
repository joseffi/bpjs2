<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Poli extends BpjsService
{
    public function getPoliFKTP ($start, $limit) {
        return $this->get('poli/fktp/' . $start . '/' . $limit);
    }
}