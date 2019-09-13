<?php
class Kriteria_Model extends CI_Model
{
    protected $KriteriaTable = 'Kriteria';
    public function Insert($Data)
    {
        $this->db->insert($this->KriteriaTable, $Data);
        return $this->db->insert_id();
    }
    public function Update($iddebitur, $data)
    {
        $this->db->where("iddebitur", $iddebitur);
        $result = $this->db->update($this->KriteriaTable, $data);
        return $result;
    }
    public function Select($idKriteria)
    {
        if($idKriteria==NULL){
            $result = $this->db->query("SELECT * FROM kriteria");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data;
            }else{
                return 0;
            }
        }else{
            $result = $this->db->query("SELECT * FROM kriteria WHERE idKriteria = '$idKriteria'");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }
    }
    public function Delete($idKriteria)
    {
        $this->db->where("idKriteria", $idKriteria);
        $result = $this->db->delete($this->KriteriaTable);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}