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
    
      public function validate($conn) {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
          } else {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
              $nameErr = "Only letters and white space allowed";
            }
          }
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


class Row {
  public $numCells = 0;
  public function message() {
    echo "<p>The row has {$this->numCells} cells.</p>";
  }
}
?>