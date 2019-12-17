<?php
class Debitur_Model extends CI_Model
{
    protected $DebiturTable = 'debitur';
    public function InsertDebitur($data)
    {
        $this->db->insert($this->DebiturTable, $data);
        return $this->db->insert_id();
    }
    public function GetDebitur()
    {
        $result = $this->db->query("SELECT * FROM debitur");
        $debiturs = $result->result_object();
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
