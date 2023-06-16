<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Diagnosa extends BpjsService
{
    public function getDiagnosa ($keyword, $start, $limit) {
        return $this->get('diagnosa/' . $keyword . '/' . $start . '/' . $limit);
    }
}