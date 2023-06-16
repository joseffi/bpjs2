<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Spesialis extends BpjsService 
{
    public function getReferensiSpesialis () {
        return $this->get('spesialis');
    }
    

    public function getReferensiSubSpesialis ($kdSpesialis) {
        return $this->get('spesialis/' . $kdSpesialis . '/subspesialis');
    }
    
    public function getReferensiSarana () {
        return $this->get('spesialis/sarana');
    }
    
    public function getReferensiKhusus () {
        return $this->get('spesialis/khusus');
    }
    
    public function getReferensiFaskesRujukanSubSpesialis ($kdSubSpesialis, $kdSarana, $tglEstRujuk) {
        return $this->get('spesialis/rujuk/subspesialis/' . $kdSubSpesialis . '/sarana/' . $kdSarana . '/tglEstRujuk/' . $tglEstRujuk);
    }
    
    public function getReferensiFaskesRujukanKhusus1 ($kdKhusus, $noKartu, $tglEstRujuk) {
        return $this->get('spesialis/rujuk/khusus/' . $kdKhusus . '/noKartu/' . $noKartu . '/tglEstRujuk/' . $tglEstRujuk);
    }
    
    public function getReferensiFaskesRujukanKhusus2 ($kdKhusus, $kdSubSpesialis, $noKartu, $tglEstRujuk) {
        return $this->get('spesialis/rujuk/khusus/' . $kdKhusus . '/subspesialis/' . $kdSubSpesialis . '/noKartu/' . $noKartu . '/tglEstRujuk/' . $tglEstRujuk);
    }
    
}