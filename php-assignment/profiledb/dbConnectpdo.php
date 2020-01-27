
<?php 
    class DataBaseConnecter { 
        private $servername = "localhost";
        private $username = "root";
        private $password = "Mindfire1";
        private $db = "php_profile";
        private static $obj;			
        private $conn;                     
        private final function __construct() { 
            try{
                $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }   
            catch(PDOException $e)
            {
            echo "Connection failed: " . $e->getMessage();
            }
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


?> 
