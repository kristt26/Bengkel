<?php
class Persyaratan_Model extends CI_Model
{
    protected $PersyatanTable = 'Persyaratan';
    public function Insert($Data)
    {
        $this->db->insert($this->PersyatanTable, $Data);
        return $this->db->insert_id();
    }
    public function Update($idpersyaratan, $data)
    {
        $this->db->where("idpersyaratan", $idpersyaratan);
        $result = $this->db->update($this->PersyatanTable, $data);
        return $result;
    }
    public function Select($idpersyaratan)
    {
        if($idpersyaratan==NULL){
            $result = $this->db->query("SELECT * FROM persyaratan");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data;
            }else{
                return 0;
            }
        }else{
            $result = $this->db->query("SELECT * FROM persyaratan WHERE idpersyaratan = '$idpersyaratan'");
            if($result->num_rows()){
                $Data = $result->result_object();
                return $Data[0];
            }else{
                return 0;
            }
        }
    }
    public function Delete($idpersyaratan)
    {
        $this->db->where("idpersyaratan", $idpersyaratan);
        $result = $this->db->delete($this->PersyatanTable);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}