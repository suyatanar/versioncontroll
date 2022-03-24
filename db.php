<?php
include 'config.php';
class Database{
    private $servername = "localhost";
    private $db_username = "suyadanar_version";
    private $db_password = "wY18s6dRX)";
    private $db_name = "suyadanar_version";
    public function __construct(){

        if(!isset($this->db)){
            try {
                $conn = new PDO('mysql:host='.$this->servername.';dbname='.$this->db_name, $this->db_username, $this->db_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            } catch(PDOException $e) {
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }

    public function getALLVersion(){
        $query = $this->db->prepare('SELECT * FROM version');
        $query->execute();
        $all_data = $query->fetchAll();
        $version = array();
        foreach($all_data as $data){
            $version[$data['id']] = array(
                'id'    => $data['id'],
                'name'  => $data['name'],
                'timestamp'  => $data['timestamp']
            );
        }
        //header('Content-Type: application/json');
        return json_encode($version);
    }

    public function getVersion($id = "", $timestamp = ""){

        if(((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX)){
            $timestamp = date('Y-m-d H:i:s', $timestamp);
        } 

        $query = $this->db->prepare('SELECT * FROM version WHERE id ="' .$id. '" AND timestamp = "' .$timestamp. '"');
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $version = array();
        
        if(!empty($data)){
            $version[$data['id']] = array(
                'id'    => $data['id'],
                'name'  => $data['name'],
                'timestamp'  => $data['timestamp']
            );
            return json_encode($version);
        }

        return false;
    }

    public function getVersionByID($id){
        $query = $this->db->prepare('SELECT * FROM version WHERE id =' .$id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $version = array();
        
        if(!empty($data)){
            $version[$data['id']] = array(
                'id'    => $data['id'],
                'name'  => $data['name'],
                'timestamp'  => $data['timestamp']
            );
            return json_encode($version);
        }

        return false;
    }

    public function getVersionByTimestamp($timestamp){
        if(((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX)){
            $timestamp = date('Y-m-d H:i:s', $timestamp);
        } 
        $sql = 'SELECT * FROM version WHERE timestamp ="' .$timestamp .'"';
        $query = $this->db->prepare($sql);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $version = array();

        if(!empty($data)){
            $version[$data['id']] = array(
                'id'    => $data['id'],
                'name'  => $data['name'],
                'timestamp'  => $data['timestamp']
            );
            return json_encode($version);
        }

        return false;
        
    }

    public function updateVersionByID($id = "", $name = "", $timestamp = ""){

        if((!empty($id)) && (!empty($name) || !empty($timestamp))){
            $sql = "UPDATE `version` SET ";

            if(!empty($name)){
                $sql .= "`name` = :name, ";
            }
            if(!empty($timestamp)){

                if(((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX)){
                    $timestamp = date('Y-m-d H:i:s', $timestamp);
                }   
                $sql .= "`timestamp` = :timestamp ";      
            }            

            $sql .= " WHERE `id` = :id";
            $query = $this->db->prepare($sql);

            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $query->bindValue(':id', $id, PDO::PARAM_STR);

            if($query->execute()){
                echo "Updated";
            }else{
                echo "Update Failed";
            }
        }else{
            echo "Update Failed";
        }       

    }

    public function createVersionByID($id = "", $name = "", $timestamp = ""){

        $checkid = $this->getVersionByID($id);

        if(!empty($checkid)){
            $this->updateVersionByID($id, $name, $timestamp);
            return "Updated";
        }

        if((!empty($id)) && (!empty($name) || !empty($timestamp))){
            $sql = "INSERT INTO `version` (id, name, timestamp) VALUES (";
            $sql .= ":id, :name, ";

            if(((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX)){
                $timestamp = date('Y-m-d H:i:s', $timestamp);
            }                
            
            $sql .= ":timestamp ";
            $sql .= ")";

            $query = $this->db->prepare($sql);

            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
            $query->bindValue(':id', $id, PDO::PARAM_STR);

            if($query->execute()){
                echo "Created";
            }else{
                echo "Create Failed";
            }
        }else{
            echo "Create Failed";
        }       

    }
}


function debug($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>