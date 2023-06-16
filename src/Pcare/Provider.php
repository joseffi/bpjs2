<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Provider extends BpjsService {
    
    public function getProviderRayonasi ($start, $limit) {
        return $this->get('provider/' . $start . '/' . $limit);
    }
}