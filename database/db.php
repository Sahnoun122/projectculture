<?php
// class DbConnection{
 
//     private $host = 'localhost';
//     private $username = 'root';
//     private $password = 'Khadija123@';
//     private $database = 'culture';
   
//     protected $connection;

   
//     public function __construct(){

//         if (!isset($this->connection)) {
//             $dsn = "mysql:host={$this->host};port=3306;dbname={$this->database};charset=utf8mb4";
//             $this->connection = new PDO($dsn, $this->username, $this->password);
//             $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//             $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//             if (!$this->connection) {
//                 echo 'Cannot connect to database server';
//                 exit;
//             }   else{
//                 echo "connecte correcte";
//             }         
//         } else{
//             echo "connecte correcte";

//         }   
//         echo "connecte correcte";
//     }

//     public function getConnection() {
//         return $this->connection;
//     }
// }





class DbConnection {
    
    private $host = 'localhost'; 
    private $db_name = 'culture'; 
    private $username = 'root'; 
    private $password = 'Khadija123@'; 
    public $connection;

    public function getConnection() {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }
}

?>



