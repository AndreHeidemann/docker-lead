<?php
class CsvModel {

    
    
    public function insert($data)
    {
        include 'model/db.php';
        $db = new Database;
        // $host = "192.168.3.6";
        // $username = "root";
        // $password = "root";
        // $db = "LEADS_DB";

        // try {
        //     $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     // echo "<h2>Conectado com sucesso.<h2>";
        // } catch(PDOException $e) {
        //     // echo 'ERROR: ' . $e->getMessage();
        //     return ['status' => 0, 'msg' => 'Erro ao Conectar na Base: '.$e->getMessage()];
        // }

        $sql = "INSERT INTO LEADS_DB.lead(
                            ID,
                            FIRST_NAME,
                            LAST_NAME,
                            EMAIL,
                            GENDER,
                            IP_ADDRESS,
                            COMPANY,
                            CITY,
                            TITLE,
                            WEBSITE
                        )
                    VALUES(
                            :id,
                            :first_name,
                            :last_name,
                            :email,
                            :gender,
                            :ip_address,
                            :company,
                            :city,
                            :title,
                            :website
                        ) ";
        $execute = $db->customSelect($sql);
        // $stmt= $conn->prepare($sql);
        // $execute = $stmt->execute($data);
        if($execute){
            return ['status' => 1, 'msg' => 'Inserido registro com sucesso!', 'data' =>  $data];
        }else{
            return ['status' => 0, 'msg' => 'Erro ao inserir registro!', 'data' => $data];
        }


        

    }
}
