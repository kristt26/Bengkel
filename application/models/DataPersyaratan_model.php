<?php
class DataPersyaratan_Model extends CI_Model
{
    protected $DataPersyaratan = 'datapersyaratan';
    public function Insert($Datas, $iddebitur)
    {
        $this->db->trans_begin();
        foreach ($Datas as $key => $data) {
            if(!isset($data->iddatapersyaratan)){
                $data->iddebitur = $iddebitur;
                $this->db->insert($this->DataPersyaratan, $data);
                $data->iddatapersyaratan = $this->db->insert_id();
            }else{
                $this->db->where("iddatapersyaratan", $a);
                $this->db->update($this->DataPersyaratan, $data);
            }
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false ;
        }else{
            $this->db->trans_commit();
            return $Datas;
        }
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