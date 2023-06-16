<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class StatusPulang extends BpjsService {
    
    public function getStatusPulang ($rawatInap = TRUE) {
        return $this->get('statuspulang/rawatInap/' . $rawatInap);
    }
}