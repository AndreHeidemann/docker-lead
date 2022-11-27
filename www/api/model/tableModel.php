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