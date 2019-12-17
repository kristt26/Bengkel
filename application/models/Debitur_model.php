<?php
class Debitur_Model extends CI_Model
{
    protected $DebiturTable = 'debitur';
    public function InsertDebitur($data)
    {
        $this->db->insert($this->DebiturTable, $data);
        return $this->db->insert_id();
    }
    public function GetDebitur($Periode)
    {
        $result = $this->db->query("SELECT * FROM debitur");
        $debiturs = $result->result_object();
        $result = $this->db->get("kriteria");
        $Kriteria = $result->result_object();
        foreach ($debiturs as $key => $debitur) {
            $result = $this->db->query("
                SELECT
                    `persyaratan`.*,
                    `datapersyaratan`.`nilai`
                FROM
                    `persyaratan`
                    LEFT JOIN `datapersyaratan` ON `persyaratan`.`idpersyaratan` =
                    `datapersyaratan`.`idpersyaratan`
                WHERE
                    iddebitur = '$debitur->iddebitur'
            ");
            $debitur->persyaratan = $result->result_object();
            $debitur->Kriteria = $Kriteria;
            foreach ($debitur->Kriteria as $key1 => $value1) {
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
                            datakriteria.iddebitur = '$value->iddebitur' AND
                            periode.idperiode = '$Periode->idperiode'
                ");
                $value1->subKriteria = $result->result_object();
            }
        }
        return $debiturs;
    }
    public function UpdateDebitur($iddebitur, $data)
    {
        $this->db->where("iddebitur", $iddebitur);
        $result = $this->db->update($this->DebiturTable, $data);
        return $result;
    }
    public function DeleteDebitur($iddebitur)
    {
        $this->db->where("iddebitur", $iddebitur);
        $result = $this->db->delete($this->DebiturTable);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
