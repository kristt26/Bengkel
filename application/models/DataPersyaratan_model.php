<?php
class DataPersyaratan_Model extends CI_Model
{
    protected $DataPersyaratan = 'datapersyaratan';
    public function Insert($Datas, $iddebitur)
    {
        $this->db->trans_begin();
        foreach ($Datas as $key => $data) {
            $a = [
                "idpersyaratan" => $data->idpersyaratan,
                "nilai" => $data->nilai,
                "iddebitur" => $iddebitur
            ];
            if(!isset($data->iddatapersyaratan)){
                $data->iddebitur = $iddebitur;
                $this->db->insert($this->DataPersyaratan, $a);
                $data->iddatapersyaratan =  
            }else{
                $this->db->where("iddatapersyaratan", $data->iddatapersyaratan);
                $this->db->update($this->DataPersyaratan, $a);
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
        $result = $this->db->query("SELECT * FROM debitur");
        $debiturs = $result->result_object();
        $result = $this->db->get("kriteria");
        $Kriteria = $result->result_object();
        foreach ($debiturs as $key => $debitur) {
            $result = $this->db->query("
                SELECT
                    `persyaratan`.*,
                    `datapersyaratan`.`nilai`,
                    `datapersyaratan`.`iddatapersyaratan`
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
                            datakriteria.iddebitur = '$debitur->iddebitur'
                ");
                $value1->subKriteria = $result->result_object();
            }
        }
        return $debiturs;
        // if($iddatapersyaratan==NULL){
        //     $result = $this->db->get($this->SubKriteriaModel);
        //     if($result->num_rows()){
        //         $Data = $result->result_object();
        //         return $Data[0];
        //     }else{
        //         return 0;
        //     }
        // }else{
        //     $result = $this->db->where("iddatapersyaratan", $iddatapersyaratan);
        //     if($result->num_rows()){
        //         return $result->result_object();
        //     }else{
        //         return 0;
        //     }
        // }
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