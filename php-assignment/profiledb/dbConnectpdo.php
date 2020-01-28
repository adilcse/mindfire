
<?php 
    class DataBaseConnecter { 
        private $servername = "myawsdatabase.cgciww58dmdb.us-east-2.rds.amazonaws.com";
        private $username = "local";
        private $password = "mindfire";
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
        public function selectFromMysql($table,$columns,$condition=["1"=>"1"]){
            $col = implode(', ', $columns); 
            $con='';
            $begin = true;
            $val =[];
            foreach($condition as $key=>$value){
                if($begin){
                    $con .= $key." = ? ";
                    $begin = false;
                }
                else{
                    $con .= " AND ".$key." = ? ";
                }
                array_push($val,$value);
                
            }
            try{
               
                $sql="SELECT $col FROM $table WHERE $con ;";
               
                $stmt = $this->conn->prepare($sql);  
                $stmt->execute($val);
                
               return ($stmt->fetchAll());
              
               
            }catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            return false;
            }
        }
        public function selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition=["true"=>"true"],$lmt=''){
            $col = implode(', ', $columns); 
            $begin = true;
            $val =[];
            $con = '';
            foreach($whereCondition as $key=>$value){
                if($begin){
                    $con .= $key." = ? ";
                    $begin = false;
                }
                else{
                    $con .= " AND ".$key." = ? ";
                }
                array_push($val,$value);
                
            }
            $onCon='';
            $beginOn = true;
            foreach($onCondition as $key=>$value){
                if($beginOn){
                    $onCon .= $key." = ".$value;
                    $beginOn = false;
                }
                else{
                    $onCon .= " AND ".$key." = ".$value;
                }
             
                
            }
            $sql = "SELECT $col FROM $table $joinType $joinTable ON $onCon  WHERE $con $lmt";
            try{
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($val);  
                return ($stmt->fetchAll()); 
            }catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            return false;
            }
            
        }
        public function updateMysql($table,$setColumns,$condition)
        {
            $begin = true;
            $val=[];
            $col = '';
            foreach($setColumns as $key=>$value){
                if($begin){
                    $col .= $key." = ? ";
                    $begin = false;
                }
                else{
                    $col .= " , ".$key." = ? ";
                }
                array_push($val,$value);
                
            }
            $begin = true;
            $con = '';
            foreach($condition as $key=>$value){
                if($begin){
                    $con .= $key." = ? ";
                    $begin = false;
                }
                else{
                    $con .= " , ".$key." = ? ";
                }
                array_push($val,$value);
                
            }

            $sql="UPDATE $table SET $col WHERE $con;";
            try{
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($val);  
                return (true);  
            }catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            return false;
            }
        }
        public function insertIntoMysql($table,$columns,$values)
        {
            $col=implode(', ', $columns);  
            $q=[];
            foreach($values as $v){
                array_push($q,"?");
            }
            $val=implode(', ', $q);
            $sql_insert="INSERT INTO $table($col) VALUES($val)";
            try{
                $stmt_insert=$this->conn->prepare($sql_insert);
                $stmt_insert->execute($values);  
                
                return true;
            }catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            return false;
            }

        }
        public function deleteFromMysql($table,$condition)
        {
            $con='';
            $begin = true;
            $val =[];
            foreach($condition as $key=>$value){
                if($begin){
                    $con .= $key." = ? ";
                    $begin = false;
                }
                else{
                    $con .= " AND ".$key." = ? ";
                }
                array_push($val,$value);
                
            }
            $sql_delete="DELETE FROM user_skills WHERE $con"; 
            try{
               
                $stmt = $this->conn->prepare($sql_delete);  
                $stmt->execute($val);
                return true;
            }catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            return false;
            }

        }
        public function test()
        {
            $table="states";
            $columns=["state_id","state_name"];    
            var_dump($this->selectFromMysql($table,$columns));

        }
    }
    $DBConnector = DataBaseConnecter::getInstance(); 
   // $DBConnector->test();
   

?> 
