
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
         //  echo "Connection failed: " . $e->getMessage();

           $this->conn = false;
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
        public function selectFromMysql($table,$columns=['*'],$condition=["1"=>"1"]){
            $col = implode(', ', $columns); 
            $con='';
            $val =[];
            foreach($condition as $key=>$value){
                $con .= $key." = ? "." AND ";
                array_push($val,$value);            
            }
            $con = trim($con," AND ");
           

            try{
               
                $sql="SELECT $col FROM $table WHERE $con ;";
                $stmt = $this->conn->prepare($sql);  
                $stmt->execute($val);
                
               return ($stmt->fetchAll());
              
               
            }catch(PDOException $e)
            {
           // echo $sql . "<br>" . $e->getMessage();
            return false;
            }
        }
        public function selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition=["true"=>"true"],$lmt=''){
            $col = implode(', ', $columns); 
            $val =[];
            $con = '';
            foreach($whereCondition as $key=>$value){
                    $con .= $key." = ? "." AND "; 
                array_push($val,$value);  
            }
            $con = trim($con," AND");
            $onCon='';
            foreach($onCondition as $key=>$value){
                    $onCon .= $key." = ".$value." AND ";  
                    array_push($val,$value);
            }
           $onCon= trim($onCon," AND ");
            $sql = "SELECT $col FROM $table $joinType $joinTable ON $onCon  WHERE $con $lmt";
            try{
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($val);  
                return ($stmt->fetchAll()); 
            }catch(PDOException $e)
            {
          //  echo $sql . "<br>" . $e->getMessage();
            return false;
            }
            
        }
        public function updateMysql($table,$setColumns,$condition)
        {
           
            $val=[];
            $col = '';
            foreach($setColumns as $key=>$value){
                $col .= $key." = ? "." , ";    
                array_push($val,$value);    
            }
            $col = trim($col,", ");
           

           
            $con = '';
            foreach($condition as $key=>$value){  
                $con .= $key." = ? AND";      
                array_push($val,$value);   
            }
            $con =  trim($con,'AND');
           
            $sql="UPDATE $table SET $col WHERE $con;";
            echo $sql.'\n';
            try{
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($val);  
                return (true);  
            }catch(PDOException $e)
            {
             

          //  echo $sql . "<br>" . $e->getMessage();
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
          //  echo $sql . "<br>" . $e->getMessage();
            return false;
            }

        }
        public function deleteFromMysql($table,$condition)
        {
            $con='';
           
            $val =[];
            foreach($condition as $key=>$value){
             
                    $con .= $key." = ? AND ";
                   
                array_push($val,$value);
                
            }
            $con = trim($con,"AND ");
            $sql_delete="DELETE FROM $table WHERE $con"; 
            try{
               
                $stmt = $this->conn->prepare($sql_delete);  
                $stmt->execute($val);
                return true;
            }catch(PDOException $e)
            {
            
            return false;
            }

        }
        public function test(){
          $res =  $this->selectFromMysql("users",["first_name"],["age"=>26,"age"=>23]);
            var_dump($res);
        }
       
    }
    $DBConnector = DataBaseConnecter::getInstance(); 
   
  //  $DBConnector->test();
   

?> 
