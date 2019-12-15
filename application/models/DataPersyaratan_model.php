<?php
class Kriteria_Model extends CI_Model
{
    protected $DataPersyaratan = 'datapersyaratan';
    public function Insert($Data)
    {
        $this->db->insert($this->DataPersyaratan, $Data);
        return $this->db->insert_id();
    }
    public function Update($iddatapersyaratan, $data)
    {
        $this->db->where("iddatapersyaratan", $iddatapersyaratan);
        $result = $this->db->update($this->DataPersyaratan, $data);
        return $result;
    }
    public function Select($iddatapersyaratan)
    {
        if($iddatapersyaratan==NULL){
            $result = $this->db->get($this->SubKriteriaModel);
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }else{
            $result = $this->db->where("iddatapersyaratan", $iddatapersyaratan);
            if($result->num_rows()){
                return $result->result_object();
            }else{
                return 0;
            }
        }
    }
    public function Delete($iddatapersyaratan)
    {
        $this->db->where("iddatapersyaratan", $iddatapersyaratan);
        $result = $this->db->delete($this->SubKriteriaModel);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}