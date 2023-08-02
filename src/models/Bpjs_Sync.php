<?php 
namespace joseffi\Bpjs\models;

class Bpjs_Sync extends \DB\SQL\Mapper {

    protected $this_site_id;
    protected $table;

    function __construct($db, $table='bpjs_sync', $site_id='') {
        parent::__construct($db, $table);
        $this->table        = $table;
        $this->this_site_id = $site_id;
    }

    // returns id or false
    function add($method, $service_name, $feature, $data=[], $headers=[]) {
        $bsy = new Bpjs_Sync($this->db, $this->table);
        $id  = uniqid(); 
        $bsy->id            = $id;
        $bsy->site_id       = $this->this_site_id;
        $bsy->service_name  = $service_name;
        $bsy->feature       = $feature;
        $bsy->method        = $method;
        $bsy->post_data     = json_encode($data);
        $bsy->header        = json_encode($headers);
        $bsy->save();

        return $id;
    }

    function list_pending_by_site($limit=0) {
        $opts = null;
        $ans = [];
        if (!empty($limit))
            $opts = ['limit' => intval($limit)];
        foreach ($this->find(['site_id=:site_id AND response_code IS NULL', [':site_id'=>$this->this_site_id]], $opts) as $row) {
            $row = $row->cast();
            foreach (['post_data', 'headers'] as $f) {
                if (!empty($row[$f]))
                    $row[$f] = json_decode(($row[$f] ?? '[]'), true);
                else 
                    $row[$f] = [];
            }            
            
            $ans[] = $row;
        }
        return $ans;
    }

    // returns true or false
    function flag_request_start($id='') {
        $bsy = new Bpjs_Sync($this->db, $this->table);
        $bsy->load(['id=:id AND site_id=:site_id', [':id'=>$id, ':site_id'=>$this->this_site_id]]);

        if ($bsy->dry()) return false;
        $bsy->request_time = date("Y-m-d H:i:s");
        $bsy->save();

        return true;
    }

}