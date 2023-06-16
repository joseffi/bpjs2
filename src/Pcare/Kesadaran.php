<?php
namespace joseffi\Bpjs\Pcare;

use joseffi\Bpjs\BpjsService;

class Kesadaran extends BpjsService
{
    public function getKesadaran () {
        return $this->get('kesadaran');
    }
}