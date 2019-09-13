<?php
class Debitur_Model extends CI_Model
{
    protected $DebiturTable = 'debitur';
    public function InsertDebitur($data)
    {
        $this->db->insert($this->DebiturTable, $data);
        return $this->db->insert_id();
    }
    public function GetDebitur($IdDebitur)
    {
        if($IdDebitur==NULL){
            $result = $this->db->query("SELECT * FROM debitur");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data;
            }else{
                return 0;
            }
        }else{
            $result = $this->db->query("SELECT * FROM debitur WHERE iddebitur = '$IdDebitur'");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }
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
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}