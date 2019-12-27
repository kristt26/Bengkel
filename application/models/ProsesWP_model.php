<?php

class ProsesWP_Model extends CI_Model
{
    public function HitungWP($idperiode)
    {
        $result = $this->db->get("debitur");
        $debitur = $result->result_object();
        foreach ($debitur as $key => $value) {
            $result = $this->db->get("kriteria");
            $Kriteria = $result->result_object();
            $value->Kriteria = $Kriteria;
            $num = 0;
            foreach ($value->Kriteria as $key1 => $value1) {
                $result = $this->db->query("
                    SELECT
                        AVG(`datakriteria`.`nilai`) as nilai
                    FROM
                        `subkriteria`
                        LEFT JOIN `datakriteria` ON `subkriteria`.`idSubKriteria` =
                        `datakriteria`.`idSubKriteria`
                    WHERE 
                        idperiode = '$idperiode' AND
                        `subkriteria`.idkriteria = '$value1->idkriteria' AND
                        datakriteria.iddebitur = '$value->iddebitur'
                ");
                if(doubleval($result->row('nilai'))>0){
                    $value1->nilai = doubleval($result->row('nilai'));
                }else{
                    $num += 1;
                }
            }
            if($num>0){
                unset($debitur[$key]);
            }
        }
        $Bobot = 1 / count($Kriteria);
        $VectorS['Nilai'] = array();
        foreach ($debitur as $key => $value) {
            $a = 1;
            $Alternatif = [
                "Nama" => $value->nama,
                "Code" => "A".($key+1),
                "nilai" => ""
            ];
            foreach ($value->Kriteria as $key1 => $value1) {
                $a *= pow($value1->nilai, $Bobot);                
            }
            $Alternatif['nilai'] = $a;
            array_push($VectorS['Nilai'], $Alternatif);
        }
        $VectorS = $VectorS['Nilai'];
        $NilaiVector['Nilai'] = array();
        foreach ($VectorS as $key => $value) {
            $Alternatif = [
                "Nama" => $value['Nama'],
                "Code" => "V".($key+1),
                "nilai" => ""
            ];
            $sum = array_reduce($VectorS, function($carry, $item)
            {
                return $carry + $item['nilai'];
            });
            $Alternatif['nilai'] = $value['nilai']/$sum;
            array_push($NilaiVector['Nilai'], $Alternatif);
        }
        $NilaiVector = $NilaiVector['Nilai'];
        $Data = [
            "Debitur" => $debitur,
            "VectorS" =>$VectorS,
            "NilaiVector" => $NilaiVector
        ];
        return $Data;
    }    
}
