<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Pendaftaran extends BpjsService
{
    public function getPendaftaranNoUrut ($noUrut, $tglDaftar) {
        return $this->get('pendaftaran/noUrut/' . $noUrut . '/tglDaftar/' . $tglDaftar);
    }
    
    public function getPendaftaranProvider ($tglDaftar, $start, $limit) {
        return $this->get('pendaftaran/tglDaftar/' . $tglDaftar . '/' . $start . '/' . $limit);
    }
    
    public function insertPendaftaran ($data = []) {
        return $this->post('pendaftaran/', $data);
    }
    
    public function deletePendaftaran ($noKartu, $tglDaftar, $noUrut, $kdPoli) {
        return $this->delete('pendaftaran/peserta/' . $noKartu . '/tglDaftar/' . $tglDaftar . '/noUrut/' . $noUrut . '/kdPoli/' . $kdPoli);
    }
}