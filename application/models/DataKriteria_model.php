<?php
class DataKriteria_Model extends CI_Model
{
    protected $DataKriteriaTable = 'datakriteria';
    public function Insert($Datas, $iddebitur, $idperiode)
    {
        
        $this->db->trans_begin();
        foreach ($Datas as $key => $data) {
            foreach ($data->subKriteria as $key1 => $sub) {
                $DataSimpan = [
                    "iddebitur" => $iddebitur,
                    "nilai" => $sub->nilai,
                    "idSubKriteria" => $sub->idSubKriteria,
                    "idperiode" => $idperiode
                ];
                $this->db->where("iddebitur", $iddebitur);
                $this->db->where("idperiode", $idperiode);
                $this->db->where("idSubKriteria", $sub->idSubKriteria);
                $result = $this->db->get("datakriteria");
                if($result->num_rows()>0){
                    $this->db->set("nilai", $sub->nilai);
                    $this->db->where("iddebitur", $iddebitur);
                    $this->db->where("idperiode", $idperiode);
                    $this->db->where("idSubKriteria", $sub->idSubKriteria);
                    $this->db->update("datakriteria");
                }else{
                    $this->db->insert($this->DataKriteriaTable, $DataSimpan);
                    $sub->iddatakriteria = $this->db->insert_id();
                }
            }
        }
        if($this->db->trans_status()==FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return $Datas;
        }
    }
    public function Update($iddatakriteria, $data)
    {
        $this->db->where("iddatakriteria", $iddatakriteria);
        $result = $this->db->update($this->DataKriteriaTable, $data);
        return $result;
    }
    public function Select($idperiode)
    {
        
        // if($idpersyaratan==NULL){
        //     $result = $this->db->query("SELECT * FROM datakriteria");
        //     if($result->num_rows()){
        //         $Data = $result->result_object();
        //         return $Data;
        //     }else{
        //         return 0;
        //     }
        // }else{
        //     $result = $this->db->query("SELECT * FROM datakriteria WHERE iddatakriteria = '$iddatakriteria'");
        //     if($result->num_rows()){
        //         $Data = $result->result_object();
        //         return $Data[0];
        //     }else{
        //         return 0;
        //     }
        // }
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