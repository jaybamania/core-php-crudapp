<?php
namespace Ops;
require("include/connect.php");

class Add {
//   public $title = "";
//   public $numRows = 0;

    public $name = "";
    public $email = "";
    public $phone = "";
    public $address = "";

  public function insert($conn) {
    // echo "<p>Table '{$this->title}' has {$this->numRows} rows.</p>";
    $insert="insert into members(`name`, `phone`, `email`, `address`) values('{$this->name}','{$this->phone}','{$this->email}','{$this->address}');";
    $runn=mysqli_query($conn, $insert);
    if($runn){
        return 1;
    }else{
        return 0;
    }
  }
}

class CheckEmail {

    public $email = "";

    public function checkEmail($conn) {
       $duplicate = mysqli_query($conn,"select * from members where email='{$this->email}' ");
       if (mysqli_num_rows($duplicate)>0)
        {
            $emailError = "<p style='color:red;'> This email is already registered</p>";
            return 0;
        }
        else{
            return 1;
        }
    }
 }

 class Validations {
    //   public $title = "";
    //   public $numRows = 0;
    
        public $name = "";
        public $email = "";
        public $phone = "";
        public $address = "";

        public $nameErr = "";
        public $emailErr = "";
        public $phoneErr = "";
        public $addressErr = "";

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    
      public function validate_name() {
        if (empty($this->name)) {
            $this->nameErr = "Name is required";
            return $this->nameErr;
          } 
      }
      public function validate_email(){
          if (empty($this->email)) {
            $this->emailErr = "Email is required";
            return $this->emailErr;
          } else {
            $this->email = $this->test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "Invalid email format";
                return $this->emailErr;
            }
          }
        }  
        public function validate_address(){
          if (empty($this->address)) {
            $this->addressErr = "Address is required";
            return $this->addressErr;
          } 
        }

        public function validate_phone(){
          if (empty($this->phone)) {
            $this->phoneErr = "Phone No is Required";
            return $this->phoneErr;
          } 
        // echo "<p>Table '{$this->title}' has {$this->numRows} rows.</p>";
      }
    }


class Row {
  public $numCells = 0;
  public function message() {
    echo "<p>The row has {$this->numCells} cells.</p>";
  }
}
?>