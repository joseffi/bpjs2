<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Peserta extends BpjsService
{
    public function getPeserta ($keyword) {
        return $this->get('peserta/' . $keyword);
    }
    
    public function getPesertaJenisKartu ($jnsKartu , $keyword) {
        return $this->get('peserta/' . $jnsKartu . '/' . $keyword);
    }
}