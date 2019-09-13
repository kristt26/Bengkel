<?php
class DataKriteria_Model extends CI_Model
{
    protected $DataKriteriaTable = 'datakriteria';
    public function Insert($Data)
    {
        $this->db->insert($this->DataKriteriaTable, $Data);
        return $this->db->insert_id();
    }
    public function Update($iddatakriteria, $data)
    {
        $this->db->where("iddatakriteria", $iddatakriteria);
        $result = $this->db->update($this->DataKriteriaTable, $data);
        return $result;
    }
    public function Select($idpersyaratan)
    {
        if($idpersyaratan==NULL){
            $result = $this->db->query("SELECT * FROM datakriteria");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data;
            }else{
                return 0;
            }
        }else{
            $result = $this->db->query("SELECT * FROM datakriteria WHERE iddatakriteria = '$iddatakriteria'");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }
    }
    public function Delete($iddatakriteria)
    {
        $this->db->where("idpersyaratan", $iddatakriteria);
        $result = $this->db->delete($this->DataKriteriaTable);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}