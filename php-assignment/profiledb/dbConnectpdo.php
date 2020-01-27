
<?php 
    class DataBaseConnecter { 
        
    private $dbhost = "myawsdatabase.cgciww58dmdb.us-east-2.rds.amazonaws.com";
    private $dbport = "3306";
    private $dbname = "php_profile";
    private $charset = 'utf8' ;
    private $username = "local";
    private $password = "mindfire";


        private static $obj;			
        private $conn;                     
        private final function __construct() { 
            try{
                $this->conn = new PDO("mysql:host=$this->dbhost;port=$this->dbport;dbname=$this->dbname;charset=$this->charset", $this->username, $this->password);
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
