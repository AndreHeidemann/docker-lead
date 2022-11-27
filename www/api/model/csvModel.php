<?php
class CsvModel {

    public $hostname, $dbname, $username, $password, $conn;
    
    
    public function insert($data)
    {        
        $sql = "INSERT INTO LEADS_DB.LEAD(
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
                            upper(:first_name),
                            upper(:last_name),
                            lcase(:email),
                            upper(:gender),
                            :ip_address,
                            upper(:company),
                            upper(:city),
                            upper(:title),
                            :website
                        ) ";
        $this->host_name = "mysql";
        $this->dbname = "LEADS_DB";
        $this->username = "root";
        $this->password = "root";
        // Conexão com a base
        try {
            $this->conn = new PDO("mysql:host=$this->host_name;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {            
            return ['status' => 0, 'msg' => 'Erro ao conectar na base! '.$e->getMessage(), 'data' => $data];
        }
        // Executa insert
        try {
            $stmt = $this->conn->prepare($sql);   
            $stmt->bindValue(':id', $data['id']);            
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':ip_address', $data['ip_address']);
            $stmt->bindValue(':company', $data['company']);
            $stmt->bindValue(':city', preg_replace('/[^A-Za-z0-9\-]/', '', $data['city']));            
            $stmt->bindValue(':title', $data['title']);
            $stmt->bindValue(':website', $data['website']);
            $execute = $stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return ['status' => 0, 'msg' => 'Erro ao inserir registro! '.$e->getMessage(), 'data' => $data];
        }
        return ['status' => 1, 'msg' => 'Inserido registro com sucesso!', 'data' =>  $data];
    }
}
