<?php
class TableModel {
    public $hostname, $dbname, $username, $password, $conn;
    public function select()
    {
        
        $sql = "SELECT * FROM LEADS_DB.LEAD";
        $this->host_name = "mysql";
        $this->dbname = "LEADS_DB";
        $this->username = "root";
        $this->password = "root";
        // Conexão com a base
        try {            
            $this->conn = new PDO("mysql:host=$this->host_name;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {            
            return ['status' => 0, 'msg' => 'Erro ao conectar na base! '.$e->getMessage()];
        }
        // Executa insert
        try {
            try {
                $this->conn->exec(
                        "CREATE TABLE IF NOT EXISTS `LEAD` (
                                                    `ID` int(11) DEFAULT NULL,
                                                    `FIRST_NAME` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
                                                    `LAST_NAME` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
                                                    `EMAIL` varchar(254) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
                                                    `GENDER` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
                                                    `IP_ADDRESS` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
                                                    `COMPANY` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
                                                    `CITY` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
                                                    `TITLE` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
                                                    `WEBSITE` varchar(2083) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL
                                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
                );
            } catch(PDOException $e) {
                return ['status' => 0, 'msg' => 'Erro ao criar tabela. '.$e->getMessage()];                
            }            
            $stmt = $this->conn->prepare($sql);
            $execute = $stmt->execute();
            $lead = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return ['status' => 0, 'msg' => 'Erro ao buscar registros '.$e->getMessage()];
        }
        return ['status' => 1, 'msg' => 'Consulta de registros realizada com sucesso!', 'data' =>  $lead];
    }
    
}