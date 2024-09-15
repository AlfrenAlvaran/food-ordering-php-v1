<?php


class Food {
    private $DNS = 'mysql:host=localhost;dbname=foodel';
    private $db_name="root";
    private $db_password ="chen0502";
    private $option_exexption = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $connection;

    public function OpenConnection () {
        try{
            $this->connection = new PDO($this->DNS, $this->db_name, $this->db_password, $this->option_exexption);
            return $this->connection;
        }catch(PDOException $e){
            echo "ERROR CONNECTION".$e->getMessage();
        }
    }



    public function Sign_customer () {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign_in'])) {
            $conn = $this->OpenConnection();
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['name']);
            try{
                if($this->checkExistAccount($email)==0){    
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO customer (`name`,`email`,`password`) VALUES (?,?,?)");
                    $stmt->execute([$name, $email, $hashed]);
                }
            }catch(PDOException $e) {
                echo "There was a problem in the insseting: ".$e->getMessage();
            }
            
        }   
    }

    public function Customer_login () {

    }


    public function set_session() {

    }


    public function checkExistAccount ($email) {
        $conn = $this->OpenConnection();
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
        $stmt->execute([$email]);
        $total = $stmt->rowCount();
        return $total;
    }
}



$shop = new Food();