<?php



class Connection {
    
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;


    function __construct(){
        $listadatos = $this->connectionData();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->connection = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
        if($this->connection->connect_errno){
            echo "algo va mal con la conexion";
            die();
        }

    }

    private function connectionData(){
        $direction = dirname(__FILE__);
        $jsondata = file_get_contents($direction . "/" . "config");
        return json_decode($jsondata, true);
    }


    private function charsetConvert($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }


    public function getData($sqlstr){
        $results = $this->connection->query($sqlstr);
        if ($results != '') {
            $resultArray = array();
            foreach ($results as $key) {
                $resultArray[] = $key;
            }
            return $this->charsetConvert($resultArray);
        }
        return false;
    }



    public function nonQuery($sqlstr){
        $results = $this->connection->query($sqlstr);
        return $this->connection->affected_rows;
    }


    //INSERT 
    public function nonQueryId($sqlstr){
        $results = $this->connection->query($sqlstr);
        $filas = $this->connection->affected_rows;
        if($filas >= 1){
            return $this->connection->insert_id;
        }else{
            return 0;
        }
    }
     
    //encriptar

    protected function encriptar($string){
        return md5($string);
    }

}



?>