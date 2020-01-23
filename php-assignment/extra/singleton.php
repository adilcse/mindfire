
<?php 
    echo "welcome <br>";
    class DataBaseConnecter { 
        private $servername = "localhost";
        private $username = "root";
        private $password = "Mindfire1";
        private $db = "php_profile";
        private static $obj;			
        private $conn; 
                        
        private final function __construct() { 
            $this->conn = new mysqli($this->servername, $this->username, $this->password,$this->db);
        } 
        
        public static function getInstance() { 
            if (!isset(self::$obj)) { 
                self::$obj = new DataBaseConnecter(); 
            } 
            
            return self::$obj; 
        } 
        public function getConnect() {
            return $this->conn; 
        } 
    }
        
    

    $DB = DataBaseConnecter::getInstance(); 
    
    $conn = $DB->getConnect();
    
    $sql="SELECT users.first_name,users.email,users.mobile_number,users.age,users.sex,states.state_id  
    FROM users INNER JOIN states ON users.state_id = states.state_id WHERE users.id=12;";
    try{
      
        $result=NULL;
        $result = $conn->query($sql);
        var_dump($result);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                print_r($row);
            }
        }
    }
    catch(Exception $e){
        die($conn->error);
    }



?> 
