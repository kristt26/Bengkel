<?php

class ProsesWP_Model extends CI_Model
{
    public function HitungWP()
    {
        $this->db->where("status", "Lanjut");
        $result = $this->db->get("debitur");
        $debitur = $result->result_object();
        $result - $this->db->get("kriteria");
        $Kriteria = $result->result_object();
        foreach ($debitur as $key => $value) {
            $value->Kriteria = $Kriteria;
            foreach ($value->Kriteria as $key1 => $value1) {
                $Nilai = 0;
                $result = $this->db->query("SELECT * FROM subkriteria WHERE idkriteria = '$value1->idkriteria'");
                $value1->SubKriteria = $result->result_object();
                foreach ($value1->SubKriteria as $key2 => $value2) {
                    $result = $this->db->query("
                        SELECT
                            *
                        FROM
                            `datakriteria`
                        LEFT JOIN `periode` ON `periode`.`idperiode` = `datakriteria`.`idperiode`
                        WHERE 
                            periode.status = 'AKTIF' AND
                            datakriteria.iddebitur = '$value->iddebitur' AND
                            datakriteria.idSubKriteria = '$value2->idSubKriteria'
                    ");
                    if($result->num_rows()>0){
                        
                    }
                }
            }
        }
    }    
}
