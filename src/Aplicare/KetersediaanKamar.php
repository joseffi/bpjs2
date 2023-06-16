<?php
namespace joseffi\Bpjs\Aplicare;

use Joseffi\Bpjs\BpjsService;

class KetersediaanKamar extends BpjsService
{

    public function refKelas()
    {
        return $this->get('ref/kelas');
    }
    public function bedGet($kodePpk, $start, $limit)
    {
        return $this->get('bed/read/'.$kodePpk.'/'.$start.'/'.$limit);
    }
    public function bedCreate($kodePpk, $data = [])
    {
        return $this->post('bed/create/'.$kodePpk, $data, ['Content-Type', 'application/json']);
    }
    public function bedUpdate($kodePpk, $data = [])
    {
        return $this->put('bed/update/'.$kodePpk, $data);
    }
    public function bedDelete($kodePpk, $data = [])
    {
        return $this->delete('bed/delete/'.$kodePpk, $data);
    }
}
