<?php

class SubKriteria_Model extends CI_Model
{
    protected $SubKriteriaTable = 'subkriteria';
    public function Insert($Data)
    {
        $this->db->insert($this->SubKriteriaTable, $Data);
        return $this->db->insert_id();
    }
    public function Update($idSubkriteria, $data)
    {
        $this->db->where("idSubKriteria", $idSubkriteria);
        $result = $this->db->update($this->SubKriteriaTable, $data);
        return $result;
    }
    public function Select($idSubkriteria)
    {
        if($idSubkriteria==NULL){
            $result = $this->db->get($this->SubKriteriaModel);
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }else{
            $this->db->where("idSubKriteria", $idSubkriteria);
            $result = $this->db->get($this->SubKriteriaTable);
            if($result->num_rows()){
                return $result->result_object();
            }else{
                return 0;
            }
        }
    }
    public function Delete($idSubKriteria)
    {
        $this->db->where("idSubKriteria", $idSubKriteria);
        $result = $this->db->delete($this->SubKriteriaTable);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}
