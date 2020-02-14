<?php 
// DataBaseConnecter class have all the method using database
require_once('database.php');
    class DataBaseConnecter extends Database { 
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
        //convert array to string for sql query.
        private function getColumnString($col){
            return implode(', ', $col); 
        }
        // convert array to string for sql
        private function getConditions($condition,$sep="AND",$q="?",$op=" = "){
            $con='';
            $val =[];
            if(!$q){
                foreach($condition as $key=>$value){
                    $con .= $key.$op.$value." ".$sep." ";         
                }
                $con = trim($con,$sep." "); 
            }else{
                foreach($condition as $key=>$value){
                    $con .= $key.$op.$q." ".$sep." ";
                    array_push($val,$value);            
                }
                $con = trim($con,$sep." ");
             }
        return array($val,$con);
        }
        private function getJoinCondition($joinTable,$joinType,$onCondition)
        {

            $result='';
            $index=0;
            foreach($onCondition as $key=>$value){
                $result.=$joinType[$index]." ".$joinTable[$index]." ON ".$key." = ".$value." ";
                $index++;
            }
            return $result;

            # code...
        }
        //run sql
        private function runSqlCommand($sql,$val,$type="select"){
            try{
                $stmt = $this->conn->prepare($sql);
                count($val>0) ? $res =$stmt->execute($val):$res = $stmt->execute; 
               
                if($type === "select")
                     return ($stmt->fetchAll());
                else
                   // if($res->errorInfo)
                    return true;     
            }catch(PDOException $e)
            {
                return $e;
            return false;
            }
        }
        //join table 
        public function selectFromMysqlJoin($table,$columns,$joinType,$joinTable,$onCondition,$whereCondition=["true"=>"true"],$lmt=''){
            $col = $this->getColumnString($columns);

        
            //generate and separated string for condition
           $conditions = $this->getConditions($whereCondition,"AND",false);
           $con = $conditions[1];
           $val1 = $conditions[0];
            $conditions = $this->getConditions($onCondition,"ON",false);
            $onCon = $conditions[1];
            $val2 = $conditions[0];
            $val = array_merge($val1,$val2);
            $joinCondition = $this->getJoinCondition($joinTable,$joinType,$onCondition);
            
          
            $sql = "SELECT $col FROM $table $joinCondition  WHERE $con $lmt";
           
            return $this->runSqlCommand($sql,$val,"select");
            
        }
        //to select any column from any table by giving condition
        public function selectFromMysql($table,$columns=['*'],$condition=["1"=>"1"]){
            $col = $this->getColumnString($columns);
            $conditions=$this->getConditions($condition);
            $val = $conditions[0];
            $con = $conditions[1];
            $sql="SELECT $col FROM $table WHERE $con ;";
            return $this->runSqlCommand($sql,$val);
        }
       
        public function updateMysql($table,$setColumns,$condition)
        {
            //generate comma separated string for column name
            $columns=$this->getConditions($setColumns,",");
            $val1 = $columns[0];
            $col = $columns[1];
            //generate and separated string for condition
           $conditions = $this->getConditions($condition);
           $con = $conditions[1];
           $val2 = $conditions[0];
           $val =  array_merge($val1,$val2);
            $sql="UPDATE $table SET $col WHERE $con;";
            return $this->runSqlCommand($sql,$val,"update");
            
        }
        public function insertIntoMysql($table,$columns,$values)
        {
            $col = $this->getColumnString($columns);
            //generate sql with ? for pdo insertion
            $q=[];
            foreach($values as $v){
                array_push($q,"?");
            }
            $val= $this->getColumnString($q);
            $sql_insert="INSERT INTO $table($col) VALUES($val)";
            return $this->runSqlCommand($sql_insert,$values,"insert");
           

        }
        public function deleteFromMysql($table,$condition)
        {
            $conditions=$this->getConditions($condition);
            $con=$conditions[1]; 
            $val =$conditions[0];
            $sql_delete="DELETE FROM $table WHERE $con"; 
           // return $sql_delete;
            return $this->runSqlCommand($sql_delete,$val,"delete");
        }
        // public function test(){
        //   $res =  $this->selectFromMysql("users",["first_name"],["age"=>26,"age"=>23]);
        //     var_dump($res);
        // }
       
    }
    $DBConnector = DataBaseConnecter::getInstance(); 
   
  //  $DBConnector->test();
   

?> 
