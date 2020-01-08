<?php

class Periode_Model extends CI_Model
{
    protected $periodeTable = 'periode';
    public function Insert($Data)
    {
        $this->db->insert($this->KriteriaTable, $Data);
        return $this->db->insert_id();
    }
    public function Update($idperiode, $data)
    {
        $this->db->where("idperiode", $idperiode);
        $result = $this->db->update($this->periodeTable, $data);
        return $result;
    }
    public function Select()
    {
        $result = $this->db ->get($this->periodeTable);
        $periodes = $result->result_object();
        foreach ($periodes as $keyperiode => $periode) {
            // Get Debitur
            $result = $this->db->get("debitur");
            $debitur = $result->result_object();

            // Get Kriteria
            

            foreach ($debitur as $key => $value) {
                $result = $this->db->get("kriteria");
                $Kriteria = $result->result_object();
                $value->kriteria = $Kriteria;
                $num = 0;
                $num1 = 0;
                $Iddebitur = $value->iddebitur;
                foreach ($value->kriteria as $key1 => $value1) {
                    $result = $this->db->query("
                        SELECT
                            `subkriteria`.*,
                            `datakriteria`.`nilai`
                        FROM
                            `subkriteria`
                            LEFT JOIN `datakriteria` ON `subkriteria`.`idSubKriteria` =
                            `datakriteria`.`idSubKriteria`
                            LEFT JOIN `periode` ON `datakriteria`.`idperiode` = `periode`.`idperiode`
                        WHERE 
                            `subkriteria`.idkriteria = '$value1->idkriteria' AND
                            datakriteria.iddebitur = '$Iddebitur' AND
                            periode.idperiode = '$periode->idperiode'
                ");
                    if ($result->num_rows() > 0) {
                        $value1->subKriteria = $result->result_object();
                        foreach ($value1->subKriteria as $key => $value) {
                            $value->nilai =  doubleval($value->nilai);
                        }
                        $num1 += 1;
                    } else {
                        // $datasimpan = [
                        //     "namaSub" => $Data->namaSub,
                        //     "maxNilai" => $Data->maxNilai,
                        //     "idkriteria" => $Data->idkriteria,
                        //     "nilai" => 0
                        // ];
                        $num += 1;
                    }
                }
                if ($num1 <= 0) {
                    unset($debitur[$key]);
                }
            }
            $periode->debitur = $debitur;
        }
        return $periodes;
    }
    public function Delete($idKriteria)
    {
        $this->db->where("idKriteria", $idKriteria);
        $result = $this->db->delete($this->KriteriaTable);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
