<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Obat extends BpjsService
{
    public function getDPHO ($keyword, $start, $limit) {
        return $this->get('obat/dpho/' . $keyword . '/' . $start . '/' . $limit);
    }
    
    public function getObatKunjungan ($noKunjungan) {
        return $this->get('obat/kunjungan/' . $noKunjungan);
    }
    
    public function insertObat ($data = []) {
        return $this->post('obat/kunjungan', $data);
    }
    
    public function deleteObat ($kdObatSK, $noKunjungan) {
        return $this->delete('obat/' . $kdObatSK . '/kunjungan/' . $noKunjungan);
    }
}