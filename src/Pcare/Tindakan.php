<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Tindakan extends BpjsService 
{
    public function getReferensiTindakan ($kdTkp, $start, $limit) {
        return $this->get('tindakan/kdTkp/' . $kdTkp . '/' . $start . '/' . $limit);
    }
    
    public function getTindakanKunjungan ($noKunjungan) {
        return $this->get('tindakan/kunjungan/' . $noKunjungan);
    }
    
    public function insertTindakan ($data = []) {
        return $this->post('tindakan', $data);
    }
    
    public function updateTindakan ($data = []) {
        return $this->put('tindakan', $data);
    }
    
    public function deleteTindakan ($kdTindakanSK, $noKunjungan) {
        return $this->delete('tindakan/' . $kdTindakanSK . '/kunjungan/' . $noKunjungan);
    }
}