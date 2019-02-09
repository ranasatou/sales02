<?php
class DB{
    private $USER = "root";
    private $PW = "";
    private $dns = "mysql:dbname=salesmanagement;host=localhost;charset=utf8";

    private function Connectdb(){
        try{
            //echo "d";
            //exit;
            $pdo = new PDO($this->dns,$this->USER,$this->PW);
            //var_dump($pdo);
            //exit('test');
            return $pdo;
        }catch(Exception $e){
            //var_dump($e);
            //exit;
            return false;
        }
    }

    protected function executeSQL($sql,$array){
        try{
            //echo "c";
            //exit;
            if(!$pdo = $this->Connectdb())return false;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($array);
            //echo "a";
            //var_dump($stmt);
            return $stmt;
        }catch(Exception $e){
            return false;
        }
    }
}

?>