<?php
include 'model/csvModel.php';
class CsvService {

    public function service($file)
    {   
        $model = new csvModel();
        $fileName = $file['name'];  
        $fileSize = $file['size'];

        $fileExtension = pathinfo($fileName)['extension'];        
        $allowedTypes = ['csv'];

        if (!in_array($fileExtension, $allowedTypes)) {
            return json_encode(['status' => 0, 'msg' => 'Formato de arquivo não permitido. Favor selecionar um arquivo CSV.']);
        }

        if ($fileSize === 0) {
            return json_encode(['status' => 0, 'msg' => 'Arquivo vazio.']);
        }

        $data = $this->csvToArray($file);        
        if(empty($data)){
            return json_encode(['status' => 0, 'msg' => 'Nenhum registro encontrado no arquivo CSV.']);
        }else{
            $insertError = [];  
            $successInsertCount = 0;          
            foreach ($data as $row) {
                $insert = $model->insert($row);
                if ($insert['status']==0) {
                    array_push($insertError,$insert['data']);
                    ECHO '<pre>';
                    ECHO print_r($insert);
                    ECHO '</pre>';  
                    die();
                }else{
                    $successInsertCount++;
                }                
            }

            if(!empty($insertError)){
                $i=1;
                $endError = "Houve erro ao inserir: <br>";
                foreach ($insertError as $error) {
                    $endError .= $i." ".implode(', ',$error).";<br>";                    
                }
            }

            return json_encode(['status' => 1, 'msg' => 'Inserido '.$successInsertCount.' registro(s).'.$endError]);
        }
    }

    public function csvToArray($file)
    {        
        // Convertendo os dados do CSV para Array
        $tmpName        = $file['tmp_name'];        
        $csvAsArray     = array_map('str_getcsv', file($tmpName));        

        // Retira o Cabeçalho da quantidade de dados
        $csvArrayCount  = count($csvAsArray)-1;        

        // Cabeçalho do CSV
        $csvHeader      = $csvAsArray[0];        


        $arrayResponse = [];
        $arrayFinal = [];

        $i=1;
        $f=0;        
        while ($i <= $csvArrayCount){            
            $arrayTemp = [];
            $h=0;
            foreach ($csvHeader as $keyHeader => $valueHeader) {
                $arrayTemp[$valueHeader]=$csvAsArray[$i][$h];
                $h++;
            }
            $arrayResponse[$f]=$arrayTemp;
            $i++;
            $f++;
        }
        return $arrayResponse;        
    }
}