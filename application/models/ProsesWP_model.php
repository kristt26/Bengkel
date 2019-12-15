<?php

class ProsesWP_Model extends CI_Model
{
    public function HitungWP()
    {
        $this->db->where("status", "Lanjut");
        $result = $this->db->get("debitur");
        $debitur = $result->result_object();
        $result - $this->db->get("kriteria");
        $debitur->Kriteria = $result->result_object();
        foreach ($debitur->Kriteria as $key => $value) {
            $Nilai = 0;
            $this->db->query("
                SELECT 
                    AVG(nilai) as Nilai
                FROM
                    subkriteria
                WHERE
            
            idKriteria", $value->idKriteria);

        }

    }    
}
